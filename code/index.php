<?php
// ルーティング処理
require("./configs/route.php");
$route = new UserRoute();
$reqParams = $route->getRoute();

// module, queryの取得
$module = $reqParams['module'];
$query  = $reqParams['query'];

// BaseController, BaseModelの呼び出し
require("./vendor/controller/BaseController.php");

// 任意のコントローラを選択
$class_name = $route->selectController($module);

// コントローラをもとに実行
$exec = new $class_name();
try {
    // 例外が発生しなければコミット
    $exec->Action();
    $stmt = $pdo->prepare("INSERT INTO commit_table (user_name) VALUES (:user_name)");
    $stmt->bindParam(':user_name', $env['DB_USERNAME'], PDO::PARAM_STR);
    // if (!$stmt->execute()) {
    //     throw new Exception('テーブルの書き込みに失敗したZ');
    // }
    $pdo->commit();

} catch (PDOException $e) {
    echo "コミットできませんでした" . $e->getMessage();
    $pdo->rollBack();
}
