<?php
session_start(); 
// 関数ファイル読み込み
include('functions.php');

// 必須項目のチェック
if (
  !isset($_POST['year']) || $_POST['year'] == '' ||
  !isset($_POST['purchase']) || $_POST['purchase'] == ''
  ) {
  echo json_encode('param error!');
  http_response_code(500);
  exit();
}

$year = $_POST['year'];
$purchase = $_POST['purchase'];
$sale = $_POST['sale'];
$profit = $_POST['profit'];

//DB接続
$pdo = connectToDb();

//データ登録SQL作成
$sql = 'INSERT INTO account(id, year, purchase, sale, profit,user_id) VALUES(NULL, :year, :purchase, :sale, :profit)';

// SQL実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':year', $year, PDO::PARAM_STR);
$stmt->bindValue(':purchase', $purchase, PDO::PARAM_STR);
$stmt->bindValue(':sale', $profit, PDO::PARAM_STR);
$stmt->bindValue(':profit', $profit, PDO::PARAM_STR);
$status = $stmt->execute();

//データ登録処理後
if ($status == false) {
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  showSqlErrorMsg($stmt);
} else {
  echo json_encode(['msg' => 'Create successful!']);
  exit();
}
