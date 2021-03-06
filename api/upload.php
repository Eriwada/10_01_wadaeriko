<?php
// 関数ファイル読み込み
include('functions.php');
// ドメインが異なるときにも処理を実行するための記述
header('Access-Control-Allow-Origin: *');

// var_dump($_POST);
// var_dump($_FILES);
// exit();

// Fileアップロードチェック

if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {
    $uploadedFileName = $_FILES['upfile']['name']; //ファイル名の取得
    $tempPathName = $_FILES['upfile']['tmp_name']; //tmpフォルダの場所
    $fileDirectoryPath = 'upload/'; //アップロード先フォルダ
    
    // ファイルの拡張子の種類を取得．
    // ファイルごとにユニークな名前を作成．（最後に拡張子を追加）
    // ファイルの保存場所をファイル名に追加．
    $extension = pathinfo($uploadedFileName,PATHINFO_EXTENSION);
    $uniqueName = date('YmdHis').md5(session_id()). ".". $extension;
    $fileNameToSave = $fileDirectoryPath.$uniqueName;
    
    //サーバ保存領域に移動→表示
    if (is_uploaded_file($tempPathName)) {
        if (move_uploaded_file($tempPathName, $fileNameToSave)) {
        chmod($fileNameToSave, 0644);// 権限の変更
        $savedFileName = $fileNameToSave;
        } 
        else{ // アップロードに失敗
            echo json_encode(['error' => 'アップロードできませんでした']);
            http_response_code(500);
            exit;
        }
    }else{ // tmpフォルダに画像が保存されていない
        echo json_encode(['error' => 'ファイルがありません']);
        http_response_code(500);
        exit;  
    }

}else{
    // echo json_encode(['error' => 'ファイルが送られていません']);
    // http_response_code(500);
    // exit;
    $savedFileName = "";
}



// ここからDBへの登録などの処理（create.phpとほぼ同じ）

// 必須項目のチェック
if (
    !isset($_POST['year']) || $_POST['year'] == '' ||
    !isset($_POST['purchase']) || $_POST['purchase'] == '' ||
    !isset($_POST['sale']) || $_POST['sale'] == '' ||
    !isset($_POST['profit']) || $_POST['profit'] == '' 

) {
    echo json_encode('param error!');
    http_response_code(500);
    exit();
}


// データの受け取り
$year = $_POST['year'];
$purchase = $_POST['purchase'];
$sale = $_POST['sale'];
$profit = $_POST['profit'];

// DB接続
$pdo = connectToDb();


// データ登録SQL作成
$sql = 'INSERT INTO account(id, year, purchase, sale, profit,image) VALUES(NULL, :year, :purchase,:sale, :profit,:image)';


// SQL実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':year', $year, PDO::PARAM_STR);
$stmt->bindValue(':purchase', $purchase, PDO::PARAM_STR);
$stmt->bindValue(':sale', $sale, PDO::PARAM_STR);
$stmt->bindValue(':profit', $profit, PDO::PARAM_STR);
$stmt->bindValue(':image', $savedFileName, PDO::PARAM_STR); // 追加！
$status = $stmt->execute();


// データ登録処理後
if ($status == false) {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    showSqlErrorMsg($stmt);
} else {
    echo json_encode(['msg' => 'Upload successful!']);
    exit();
}
