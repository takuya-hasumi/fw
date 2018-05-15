<?php
class Route
{
    protected $status = "200";

    /**
     * ルーティングを取得
     * @return array $params コントローラ、クエリをパラメータとして返す
     */
    public function getRoute()
    {
        // リクエストURL取得
        $request_url = $_SERVER["REQUEST_URI"];
        // コントローラ取得
        $controller = $this->getController($request_url);
        // 各クエリ取得
        $query  = $this->getQuery($request_url);
        // コントローラ、クエリをパラメータとして返す
        $params = [
            'controller' => $controller['controller_name'],
            'query'      => $query['query_name']
        ];

        return $params;
    }

    /**
     * モジュール名を取得
     * @param  string $request_url
     * @return array  $controller
     */
    protected function getController($request_url)
    {
        // リクエストURLからコントローラ名を抽出
        preg_match("/(?P<controller_name>\/[a-z]*)/", $request_url, $path);
        $controller['controller_name'] = trim($path['controller_name'], "/");

        return $controller;
    }

    /**
     * クエリ名を取得
     * @param  string $request_url
     * @return array  $query
     */
    protected function getQuery($request_url)
    {
        preg_match("/(?P<query_name>[\?].[a-zA-Z0-9&=]*)/", $request_url, $query_name);
        $query['query_name'] = trim($query_name['query_name'], "?");

        return $query;
    }

    /**
     * ルーティングによって任意のコントローラーのパスを選択
     * @param  string $controller_name
     * @return array $controller コントローラ名とパスを保持した配列
     */
    public function selectController($controller_name)
    {
        // コントローラ名を大文字に変換する
        $controller_name = ucfirst($controller_name);
        // コントローラのパスを指定
        if (!empty($controller_name)) {
            $controller_path = "./controller/" . $controller_name . "Controller.php";
        } else {
            $controller_path = "./controller/IndexController.php";
        }
        $controller = [
            'controller_name' => $controller_name,
            'controller_path' => $controller_path
        ];

        return $controller;
    }

    /**
     * クラス名を取得
     * @param  array $controller コントローラ名とパスを保持した配列
     * @return string $class_name
     */
    public function getClassName($controller)
    {
        // コントローラを読み込んでクラス名を指定
        if ($file = file_exists($controller['controller_path'])) {
            require($controller['controller_path']);
            $class_name = !empty($controller['controller_name']) ? $controller['controller_name'] . "Controller" : "IndexController";
        } else {
            // パスが存在しなければ404を返す
            require("./vendor/controller/ExceptionController.php");
            $class_name = "ExceptionController";
            $status     = 404;
        }
        http_response_code($status);

        return $class_name;
    }
}
