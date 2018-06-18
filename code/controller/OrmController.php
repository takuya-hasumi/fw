<?php

class OrmController extends DbController
{
    public function action()
    {
        // 任意のテンプレートを置換して読み込み
        $this->view('orm', '置換したよ');

        // ORマッパーを利用して名前を取得
        // Modelオブジェクトを取得
        $user = Users::find(1);
        // var_dump($user);
        // Modelオブジェクトを用いて取得したプロパティを代入したい
        $user_name = $user->name;
        
        // オブジェクトに対してupdate処理
        $user->update('name', 'update hasumin');

        // $commit = Commit_table::find(71);
        // var_dump($commit);
        // $commit_name = $commit->user_name;
        // var_dump($commit_name);
        
        // $data = [
        //     'user_name' => 'oreframe'
        // ];
        // Users::add($data);
        // $columns = ['id'];
        // $where = [
        //     'id' => '1',
        //     'name' => 'hasumin'
        // ];
        // $name = Users::show($columns, $where);
        // 取得した値で本文を置換
        // $this->orequent('name', $name['user_name']);
        // Users::disconnect();

    }
}
