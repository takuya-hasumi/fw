<?php

class OrmController extends DbController
{
    public function action()
    {
        // 任意のテンプレートを置換して読み込み
        $this->view('orm', '置換したよ');

        // Modelオブジェクトを取得
        $user = Users::find(1);
        // Modelオブジェクトからプロパティを取得
        $user_name = $user->name;
        var_dump($user_name);
        
        // オブジェクトに対してupdate処理
        // $user->update('name', 'update hasumin');

        // 別なModelから取得
        $inno = Inno::find(2);
        $user_name = $inno->user_name;
        var_dump($user_name);

    }
}
