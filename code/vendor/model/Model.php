<?php

class Model
{
    // シングルトン風
    public static $pdo;
    public static $env;
    public static $object;
    public $table;

    public function __construct() 
    {
        // 対象テーブルを定義
        $this->table = lcfirst(get_called_class());
        // PDO接続
        if (!isset(self::$pdo)) {
            self::$env = $this->getEnv();
            self::$pdo = $this->getPdo();
        }
    }
    
    /**
     * DBに接続する
     */
    public static function connectDb()
    {
        // PDO接続
        self::setEnv();
        self::setPdo();
        
        return self::$pdo;
    }

    /**
     * ユーザが作成したModelを一括で読みこむ
     */
    public static function loadModels() 
    {
        foreach(glob('./model/*') as $file){
            if(is_file($file)){
                require_once($file);
            }
        }
    }

    /**
     * Modelオブジェクトを取得
     *
     * @param integer $id
     * @return Model $model
     */
    public static function find(int $id) 
    {
        // オブジェクトの生成
        $class = get_called_class();
        $model = new $class;
        self::$object = $model;
        // self::$object[] = $model;

        // カラム定義を取得
        $table = lcfirst(get_called_class());
        $sql = "show columns from " . $table;
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // カラム一覧を取得
        foreach ($result as $keys => $values) {
            foreach ($values as $key => $value) {
                if ($key == 'Field') {
                    $columns[] = $value;
                }
            }
        }
        
        // id項目がなければオブジェクト自身を返す
        $val = preg_grep('/.*id/', $columns);
        if ($val) {
            $id_column = $val[0];
        } else {
            return $model;
        }
        
        // バリューを取得
        $sql = "select * from " . $table . " where " . $id_column . " = '" . $id . "'";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // プロパティの追加
        foreach ($result[0] as $key => $value) {
            $model->$key = $value;
        }

        // Modelオブジェクトを返す
        return $model;
    }

    /**
    * 自身のenvを取得
    *
    * @return Model::$env 
    */
    public static function getEnv()
    {
        if (!isset(self::$env)) {
            self::setEnv();
        }
        return self::$env;
    }

    /**
    * 自身のpdoを取得
    *
    * @return Model::$env 
    */
    public static function getPdo()
    {
        if (!isset(self::$pdo)) {
            self::setPdo();
        }
        return self::$pdo;
    }

    /**
     * オブジェクトを取得
     * オブジェクトがプロパティにセットされていなかったらセット
     * 
     * @return Model::$object 自身のオブジェクトを返す
     */
    public static function getObject()
    {
        if (!isset(self::$object)) {
            self::setObject();
        }
        return self::$object;
    }

    /**
    * 自身のプロパティにenvをセット
    */
    public static function setEnv()
    {
        // envファイルの読み込みと設定
        $file = file_get_contents("./.env");
        preg_match_all("/(?P<key>DB_(\w+))=(?P<value>(\w+))/", $file, $matches);
        foreach ($matches as $key => $value) {
            if (is_string($key)) {
                $params[$key] = $value;
            }
        }
        $keys = $params['key'];
        $values = $params['value'];
        $env = array_combine($keys, $values);

        self::$env = $env;
    }

    /**
    * 自身のプロパティにpdoをセット
    *
    * @param Model $pdo
    */
    public static function setPdo()
    {
        if (!isset(self::$env)) {
            self::setEnv();
        }
        
        self::$pdo = new PDO(
            'mysql:host=mysql;dbname=' . self::$env['DB_DATABASE'],
            self::$env['DB_USERNAME'],
            self::$env['DB_PASSWORD'],
            [
                // エラーレポートの設定（例外を投げる）
                PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION,
                // プリペアドステートメント（ネイティブのプリペアドステートメントを設定）
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }
    
    /**
     * 自身のプロパティにオブジェクトをセット
     *
     */
    public static function setObject()
    {
        $called_class = get_called_class();
        self::$object[] = new $called_class();
    }

    /**
     * DBとの接続を切る
     */
    public static function disconnect()
    {
        self::$pdo = null;
    }

    /**
     * データの更新
     * @param string $property
     * @param string $value
     */
    public function update($property, $update_value)
    {
        // プロパティが存在すればアップデート（エラーハンドリング）
        if (!property_exists(self::$object, $property)) {
            return;
        }

        // update処理
        $sql = "update " . self::$object->table . " set " . $property . " = '" . $update_value . "'";
        $stmt = self::$pdo->prepare($sql);
        if (!$stmt->execute()) {
            throw new Exception(self::$object->tale . "テーブルの更新に失敗しました");
        }
    }

    /**
     * select文を実行する
     * @todo 未実装
     * @param array $columns
     * @param array $where
     * @return void
     */
    public static function show($columns = null, $where = null)
    {
        // SQLの生成
        if ($columns) {
            $column = implode(", ", $columns);
            $sql = "select " . $column . " from " . self::$table;
        } else {
            $sql = "select * from " . self::$table;
        }

        // where句を指定していれば条件付与
        if ($where) {
            $i = 1;
            $count = count($where);
            foreach ($where as $key => $value) {
                if ($i == $count) {
                    $conditions .=  $key . " = " . $value;
                    break;
                }
                $conditions .=  $key . " = " . $value . " and ";
                $i++;
            }

            $sql .= " where " . $conditions;
        }

        // 生成したSQLを実行し、結果を取得する
        $stmt = Model::$pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result) {
            return $result;
        } else {
            throw new PDOException("データの取得に失敗しました", 1);
            return false;
        }

    }

    /**
     * データの追加
     * @todo 未実装
     * @param array $data
     * @return bool
     */
    public static function add($data)
    {
        // 追加するカラムと値を定義
        $column = implode(", ", array_keys($data));
        // valueはセミコロンをそれぞれつける
        $values = array_values($data);
        for ($i=0; $i < count($values); $i++) {
            $values[$i] = '"' . $values[$i] . '"';
        }
        $value  = implode(", ", $values);

        // SQLの実行
        $sql = "INSERT INTO " . self::$table . " (" . $column . ") VALUES (" . $value . ")";
        $stmt = Model::$pdo->prepare($sql);
        if (!$stmt->execute()) {
            throw new PDOException("データの追加に失敗しました", 1);
            return false;
        }

        return true;
    }

    /**
     * データの削除
     * @todo 未実装
     * @param array $column
     * @param array $id
     * @return void
     */
    public static function delete($column, $id)
    {

    }

    /**
     * テーブルの生成
     * @todo 未実装
     * @param [type] $table
     * @param [type] $datas
     * @return void
     */
    public static function create($table, $datas)
    {
        $sql = "CREATE TABLE IF NOT EXISTS  " . $table ."(";
        // 追加死体カラムをそれぞれ指定
        foreach($data as $key => $value ) {
            $columns .= "'" . $key . "' " . implode(", ", $value) . ",";
        }
        $sql .= $columns . ");";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    /**
     * クエリを実行する
     * @todo 未実装
     * @param [type] $sql
     * @return void
     */
    public static function query($sql)
    {
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute();
        return $result;
    }

}
