<?php
// 抽象クラスの定義
abstract class BaseController
{
    protected $pdo;
    protected $env;

    // DBに接続するコンストラクタ
    public function __construct()
    {
        $this->connectDb();
    }

    // 処理終了時に
    public function __destruct()
    {
        $this->pdo = null;
    }

    // 抽象メソッドの定義
    abstract public function action();

    /**
    * コントローラで実行する
    */
    public function execAction()
    {
        try {
            // 例外が発生しなければコミット
            $this->pdo->beginTransaction();
            $this->action();
            $this->pdo->commit();

        } catch (PDOException $e) {
            echo "コミットできませんでした" . $e->getMessage();
            $this->pdo->rollBack();
        } catch (Exception $e) {
            echo "例外が発生しました" . $e->getMessage();
            $this->pdo->rollBack();
        }

    }

    /**
    * テンプレートを呼び出す
    * @param  mixed $file_name
    * @return mixed $file
    */
    public function getTemplate($file_name)
    {
        $file = file_get_contents("./views/" . $file_name . ".html");
        return $file;
    }

    /**
    * 置換する
    * @param  array $file
    * @param  array $params
    * @return array $replace
    */
    public function replaceParams($file, $params)
    {
        // パラメータの取得
        $url_param = strstr($_SERVER["REQUEST_URI"], '?');
        $url_param = str_replace('?', '', $url_param);
        preg_match('/([a-z]*)\=([a-z0-9]*)/', $url_param, $parameters);
        $key = $parameters[1];
        $val = $parameters[2];

        // 置換対象の定義
        $pattern_value = '[a-z]*';
        $pattern = '/{{' . $pattern_value . '}}/';
        // 置換対象と置換数の定義
        preg_match_all($pattern, $file, $matches);
        $matches_cnt = count($matches[0]);
        $keyword = ['{{', '}}'];
        // 置換対象ごとに置換する
        for ($i=0; $i < $matches_cnt; $i++) {
            preg_match($pattern, $file, $match);
            // 本文中にクエリと同じキーワードがあったらクエリの値で置き換え
            if ($key && preg_match('/'.$key.'/', $match[0], $temp)) {
                $replacement = str_replace($match[0], $val, $match[0]);
            // それ以外の置換文字は引数指定
            } else {
                $replace_text = str_replace($keyword, '', $match[0]);
                $replacement = $params . ": " . $replace_text;
            }
            $pattern_text = '/' . $match[0] . '/';
            $file = preg_replace($pattern_text, $replacement, $file);
        }

        return $file;
    }

    /**
    * 置換したファイルをもとにHTMLを表示する
    * @param  mixed $file
    */
    public function viewHtml($file)
    {
        // 出力
        return (print $file) ? true: false;
    }

    /**
    * envを定義して取得
    * @return array $env
    */
    public function getEnv()
    {
        // envファイルの読み込みと設定
        $file = file_get_contents("./.env");
        preg_match("/DB_DATABASE=(\w+)/", $file , $env_database);
        preg_match("/DB_USERNAME=(\w+)/", $file , $env_username);
        preg_match("/DB_PASSWORD=(\w+)/", $file , $env_password);
        $this->env = [
            'DB_DATABASE' => $env_database[1],
            'DB_USERNAME' => $env_username[1],
            'DB_PASSWORD' => $env_password[1]
        ];

        return $this->env;
    }

    /**
     * データベースに接続する
     */
    public function connectDb()
    {
        // dbに接続する
        $this->env = $this->getEnv();
        $this->pdo = new PDO(
            'mysql:host=mysql;dbname=' . $this->env['DB_DATABASE'],
            $this->env['DB_USERNAME'],
            $this->env['DB_PASSWORD'],
            [
                PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }

}
