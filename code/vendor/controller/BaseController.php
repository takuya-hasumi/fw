<?php
// 抽象クラスの定義
abstract class BaseController
{
    // 抽象メソッドの定義
    abstract public function action();

    /**
    * コントローラで実行する
    */
    public function execAction()
    {
        try {
            $this->action();
        } catch (Exception $e) {
            echo $e->getMessage() . "で例外が発生しました";
        }

    }

    /**
    * HTMLへの出力
    * @return string $file
    */
    public function view($file_name, $replace) {
        $file = $this->getTemplate($file_name);
        $file = $this->replaceParams($file, $replace);
        $this->viewHtml($file);
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
     * バリデーションをチェックする
     * @param array $form_condition
     * @return bool
     */
    public function checkValidate(array $form_condition)
    {
        // リクエストを取得
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $request = $_POST;
        }
        
        // バリデータのチェック
        if (isset($request)) {
            require('./vendor/configs/Validation.php');
            $validation = new Validation();
            // リクエストのバリデーションが正しいかチェック
            $errors = $validation->validate($form_condition, $request);
        }

        // エラーが起きてたら箇所と内容を表示
        if (empty($errors)) {
            echo "送信に成功しました！";
        } else {
            foreach ($errors as $value) {
                echo $value . '<br>';
            }
        }

    }

}
