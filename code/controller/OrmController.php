<?php

require('./model/Users.php');

class OrmController extends BaseController
{
    public function action()
    {
        // 任意のテンプレートを置換して読み込み
        $this->view('orm', '置換したよ');

        // ORマッパーを利用する準備
        Users::connect();
        $data = [
            'user_name' => 'oreframe'
        ];
        Users::add($data);
        $name = Users::show('user_name', '1');
        // 取得した値で本文を置換
        $this->orequent('name', $name['user_name']);
        Users::disconnect();

    }
}
