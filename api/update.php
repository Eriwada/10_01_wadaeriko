<?php
session_start();
// 関数ファイル読み込み
include('functions.php');

// var_dump($_POST);
// var_dump($_GET);
// exit();

if (
  !isset($_POST['year']) || $_POST['year'] == '' ||
  !isset($_POST['purchase']) || $_POST['purchase'] == '' ||
  !isset($_POST['sale']) || $_POST['sale'] == '' ||
  !isset($_POST['profit']) || $_POST['profit'] == '' 
) {
  echo json_encode('param error');
  http_response_code(500);
  exit();
}


$year = $_POST['year'];
$purchase = $_POST['purchase'];
$sale = $_POST['sale'];
$profit = $_POST['profit'];
$id = $_GET['id'];
$user_id = $_POST['updatedby'];

//DB接続
$pdo = connectToDb();

// データ更新SQL作成
$sql = 'UPDATE account SET year=:year, purchase=:purchase, sale=:sale, profit=:profit ,updatedby=:updatedby WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':year', $year, PDO::PARAM_STR);
$stmt->bindValue(':purchase', $purchase, PDO::PARAM_STR);
$stmt->bindValue(':sale', $sale, PDO::PARAM_STR);
$stmt->bindValue(':profit', $profit, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':updatedby', $updatedby, PDO::PARAM_STR);
$status = $stmt->execute();

// データ更新処理後
if ($status == false) {
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  showSqlErrorMsg($stmt);
} else {
  echo json_encode(['msg' => 'Update successful!']);
  exit();
}
