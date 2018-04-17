<?php
class HasuController extends BaseController
{
    public function Action()
    {
        try {
            $env = $this->getEnv();

            // db接続とトランザクション
            $pdo = new PDO(
                'mysql:host=mysql;dbname=' . $env['DB_DATABASE'],
                $env['DB_USERNAME'],
                $env['DB_PASSWORD'],
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false,
                )
            );
            $pdo->beginTransaction();

            // 任意のテンプレートの呼び出し
            if (!$file = $this->getTemplate("hasumin")) {
                throw new Exception('テンプレートの呼び出しに失敗しました。');
            }

            // 呼び出したテンプレートを置換
            if (!$file = $this->regParams($file, "置換したで")) {
                throw new Exception('テンプレートの置換に失敗しました。');
            }

            // HTMLに出力
            if (!$this->viewHtml($file)) {
                throw new Exception('HTMLの出力に失敗しました。');
            }

            // 例外が発生しなければコミット
            $stmt = $pdo -> prepare("INSERT INTO commit_table (user_name) VALUES (:user_name)");
            $stmt->bindParam(':user_name', $env['DB_USERNAME'], PDO::PARAM_STR);
            if (!$stmt->execute()) {
                throw new Exception('テーブルの書き込みに失敗だZ');
            }
            $pdo->commit();

        } catch (PDOException $e) {
            echo "コミットできませんでした" . $e->getMessage();
            $pdo->rollBack();
        }
    }
}
