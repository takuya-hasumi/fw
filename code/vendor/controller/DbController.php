<?php
// 抽象クラスの定義
class DbController extends BaseController
{
    protected $pdo;
    protected $env;

    // DBに接続するコンストラクタ
    public function __construct()
    {
        // Database.phpを読み込むやり方
        require("./vendor/model/Database.php");
        $database = new Database();
        $this->pdo = $database->pdo;

        // Modelを使う
        require("./vendor/model/Model.php");
        Model::setDbConnection($database);
        Model::loadModels();
    }

    // 処理終了時にPDO接続を閉じる
    public function __destruct()
    {
        $this->pdo = null;
    }

    public function action() {
        $this->execAction();
    }

    /**
    * コントローラで実行する
    */
    public function execAction()
    {
        try {
            // 例外が発生しなければコミット
            $this->pdo->beginTransaction();
            $this->action();
            $this->pdo->commit();

        } catch (PDOException $e) {
            echo "コミットできませんでした" . $e->getMessage();
            $this->pdo->rollBack();
        } catch (Exception $e) {
            echo "例外が発生しました" . $e->getMessage();
            $this->pdo->rollBack();
        }

    }

}
