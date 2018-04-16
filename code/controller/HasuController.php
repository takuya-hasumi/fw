<?php
class HasuController extends BaseController
{
    public function Action()
    {
        try {
            $env = $this->getEnv();

            // db接続とトランザクション
            // $pdo = new PDO('mysql:dbname=' . $env['DB_DATABASE'], $env['DB_USERNAME'], $env['DB_PASSWORD']);
            // $pdo->beginTransaction();

            // 処理
            // 任意のテンプレートの呼び出し
            $file = $this->getTemplate("hasumin");

            // 呼び出したテンプレートを置換
            $file = $this->regParams($file, "置換したで");

            // HTMLに出力
            $this->viewHtml($file);

            // コミット
            // $pdo->commit();
        } catch (PDOException $e) {
            echo "コミットできませんでした" . $e->getMessage();
            // $pdo->rollBack();
        }
    }
}
