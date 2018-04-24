<?php
// 抽象クラスの定義
abstract class BaseController
{
    // DBに接続するコンストラクタ
    public function __construct()
    {
        global $pdo;
        global $env;

        // グローバル定義した$pdoに対してdb接続とトランザクションを貼る
        $env = $this->getEnv();
        $pdo = new PDO(
            'mysql:host=mysql;dbname=' . $env['DB_DATABASE'],
            $env['DB_USERNAME'],
            $env['DB_PASSWORD'],
            [
                PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
        $pdo->beginTransaction();

    }

    // 抽象メソッドの定義
    abstract public function Action();

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
    public function regParams($file, $params)
    {
        // テンプレートを呼び出す
        $pattern_value = '[a-z]*';
        $pattern = '/{{' . $pattern_value . '}}/';

        // テンプレートエンジン的な置換
        $subject = $file;
        $replacement = "reg " . $params . "!!";
        $replace = preg_replace($pattern, $replacement, $subject);

        return $replace;
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
        $env = [
            'DB_DATABASE' => $env_database[1],
            'DB_USERNAME' => $env_username[1],
            'DB_PASSWORD' => $env_password[1]
        ];

        return $env;
    }

}
