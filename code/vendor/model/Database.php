<?php

class Database
{
    protected $env;
    protected $pdo;

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

        return $this->pdo;
    }
    
    /**
    * envを定義して取得
    * @return array $env
    */
    public function getEnv()
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
        $this->env = array_combine($keys, $values);

        return $this->env;
    }

}
