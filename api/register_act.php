<?php
// 最初にSESSIONを開始！！
session_start();
// 外部ファイル読み込み
include('functions.php');
// DB接続します
$pdo = connectToDb();
$user_id = $_POST['user_id'];
$password = $_POST['password'];

// データ登録SQL作成
$sql = 'INSERT INTO users_table (id, user_id, password, is_admin, is_deleted, created_at, updated_at)VALUES(NULL, :user_id, :password, 0, 0, sysdate(), sysdate())';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$status = $stmt->execute();

// SQL実行時にエラーがある場合
if ($status == false) {
  showSqlErrorMsg($stmt);
} else {
  $_SESSION = array();  // 配列の初期化
  $_SESSION['session_id']  = session_id();
  $_SESSION['is_admin'] = false;
  $_SESSION['user_id'] = $user_id;
  echo json_encode(['result' => true, 'user_id' => $_SESSION['user_id']]);
  exit();
}
