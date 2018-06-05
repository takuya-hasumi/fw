<?php

class Model
{
    // public static $controller;
    public static $table;
    public static $pdo;

    // DBに接続する
    public static function connect()
    {
        // 対象テーブルを定義
        self::$table = lcfirst(get_called_class());        
        // PDO接続
        require("./vendor/model/Database.php");
        $database = new Database();
        Model::$pdo = $database->connectDb();
    }

    // DBとの接続を切る
    public static function disconnect()
    {
        Model::$pdo = null;
    }

    // select文を実行する
    public static function show($column = null, $id = null)
    {
        // SQLの生成
        $sql = $column ? 
               "select " . $column . " from " . self::$table :
               "select * from " . self::$table;
        $where = $id ?: "";
        if ($where) {
            $sql .= " where id = " . $where;
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

    // データの追加
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

    // データの更新
    public static function update($id, $data)
    {
        
    }

    // データの削除
    public static function delete($column, $id)
    {
        
    }

    // テーブルの生成
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

    // クエリを実行する
    public static function query($sql)
    {
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute();
        return $result;
    }

}
