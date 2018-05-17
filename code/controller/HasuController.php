<?php
class HasuController extends DbController
{
    public function action()
    {
        // 任意のテンプレートを置換して読み込み
        $this->view('hasumin', '置換したよ');
        
        // データベースに書き込む
        $user_name = "hasumin";
        $stmt = $this->pdo->prepare("INSERT INTO commit_table (user_name) VALUES (:user_name)");
        $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        // if (!$stmt->execute()) {
        //     throw new PDOException('テーブルの書き込みに失敗したZ');
        // }

    }
}
