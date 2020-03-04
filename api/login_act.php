<?php

session_start(); 

// 外部ファイル読み込み
include('functions.php');

// DB接続します
$pdo = connectToDb();

$user_id = $_POST['user_id'];
$password = $_POST['password'];

// データ取得SQL作成&実行
$sql = 'SELECT * FROM users_table WHERE user_id=:user_id AND password=:password AND is_deleted = 0';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$status = $stmt->execute();


// SQL実行時にエラーがある場合
// 失敗時の処理
if ($status == false) {
    showSqlErrorMsg($stmt);
}
// うまくいったらデータ（1レコード）を取得
$val = $stmt->fetch();

// 抽出データ数を取得
if ($val['id'] != '') {
     $_SESSION = array();
     $_SESSION['session_id']  = session_id();
     $_SESSION['is_admin'] = $val['is_admin'];
     $_SESSION['user_id'] = $val['user_id'];
     echo json_encode(['result' => true, 'user_id' => $_SESSION['user_id']]);
     exit();
    } else {
        // 失敗時はfalseを返す
        echo json_encode(['result' => false]);
        exit();
    }

// 該当レコードがあればSESSIONに値を代入