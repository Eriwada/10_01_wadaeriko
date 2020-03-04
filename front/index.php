<?php
// メインページ読み込み時にログインチェック
session_start();
include('../api/functions.php');
check_session_id();
echo '<span><a href="../api/logout.php">ログアウト</a></span>';
echo "<span>ユーザー名: {$_SESSION['user_id']}</span>";
// morris
$conect = mysqli_connect("localhost", "root", "", "gsacfd05_01");
$query = "SELECT * FROM account";
$result = mysqli_query($conect, $query);
$chart_data = '';
while ($row = mysqli_fetch_array($result)) {
    $chart_data .= "{ year:'" . $row["year"] . "', profit:" . $row["profit"] . ", purchase:" . $row["purchase"] . ", sale:" . $row["sale"] . "}, ";
}
$chart_data = substr($chart_data, 0, -2) ?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>php_db_api</title>
    <link rel="stylesheet" href="css/main.css">

    <!-- morris -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
</head>

<body>
    <h1>売上推移</h1>
    <fieldset>
        <legend>入力フォーム</legend>
        <form>
            <div>
                <label for="year">年 | year</label>
                <input type="text" id="year">
            </div>
            <div>
                <label for="purchase">仕入 | purchase</label>
                <input type="text" id="purchase">
            </div>
            <div>
                <label for="sale">売上 | sale</label>
                <input type="text" id="sale"></input>
            </div>
            <div>
                <label for="profit">利益 | profit</label>
                <input type="text" id="profit"></input>
            </div>
            <div>
                <label for="image">image</label>
                <input type="file" id="image" accept="image/*">
            </div>
            <button type="button" id="send">send</button>
        </form>
    </fieldset>


    <fieldset>
        <legend>一覧表</legend>
        <table>
            <thead>
                <tr>
                    <th style="width:110px;">edit<u></th>
                    <th style="width:20px;"><u>id</u></th>
                    <th><u>year</u></th>
                    <th><u>purchase</u></th>
                    <th><u>sale</u></th>
                    <th><u>profit</u></th>
                    <th style="width:100px;">カタログ</th>
                    <th>最終更新者</th>
                </tr>
            </thead>
            <tbody id="echo"></tbody>
        </table>
    </fieldset>

    <div id="modal" class="modal">
        <div class="modal-content">
            <fieldset>
                <legend>編集</legend>
                <form>
                    <div>
                        <label for="yearEdit">年</label>
                        <input type="text" id="yearEdit">
                    </div>
                    <div>
                        <label for="purchaseEdit">仕入</label>
                        <input type="text" id="purchaseEdit">
                    </div>
                    <div>
                        <label for="saleEdit">売上</label>
                        <input type="text" id="saleEdit"></textarea>
                    </div>
                    <div>
                        <label for="profitEdit">利益</label>
                        <input type="text" id="profitEdit"></textarea>
                    </div>
                    <input type="hidden" name="" id="hiddenId">
                    <input type="hidden" name="" id="updatedby">
                    <button type="button" id="updateButton">update</button>
                </form>
            </fieldset>
        </div>
    </div>
    <!-- morris -->
    <fieldset>
        <legend>グラフ</legend>
        <div id="chart" class="chart"></div>
    </fieldset>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>
        // モーダルの黒い部分クリックで閉じる処理
        document.getElementById('modal').addEventListener('click', e => {
            // モーダルのフォームクリック時には閉じないように条件を分ける
            if (e.target == document.getElementById('modal')) {
                document.getElementById('modal').style.display = 'none';
            }
        });

        const createUrl = '../api/create.php';
        const readUrl = '../api/read.php';

        // 配列をタグに入れていい感じの形にする関数
        // // 画像の表示を追加しよう
        const convertArraytoListTag = array => {
            return array.map(x => {
                return `<tr>
                  <td>
                    <button type="button" class="editButton" value=${x.id}>edit</button>
                    <button type="button" class="deleteButton" value=${x.id}>delete</button>
                  </td>
                  <td>${x.id}</td>
                  <td>${x.year}</td>
                  <td>${x.purchase}</td>
                  <td>${x.sale}</td>
                  <td>${x.profit}</td>
                  <td><a href="../api/${x.image}" target="_blank">
        <img src="../api/${x.image}" height="50px" onerror='this.style.display="none"'></a>
                    </td>
                   <td>${x.updatedby}</td>
                </tr>`;
            }).join('');
        }

        // readの処理をする関数を定義
        // 読み込み時とデータ登録時の両方で実行したいため
        const readData = url => {
            axios.get(url)
                .then(response => {
                    // 成功した時
                    console.log(response);
                    // テーブルタグの中身を生成して表示
                    document.getElementById('echo').innerHTML = convertArraytoListTag(response.data);
                    // 更新ボタンクリック時の処理
                    // 該当するidのデータを取得してフォームのvalueに設定する
                    // データ取得後（DOM生成後）でないとクリックイベントを追加できない
                    document.querySelectorAll('.editButton').forEach(x => {
                        x.addEventListener('click', e => {
                            const id = e.target.value;
                            const requestUrl = `../api/edit.php?id=${id}`;
                            axios.get(requestUrl)
                                .then(response => {
                                    console.log(response.data);
                                    // updateフォームに値を設定
                                    document.getElementById('yearEdit').value = response.data.year;
                                    document.getElementById('purchaseEdit').value = response.data.purchase;
                                    document.getElementById('saleEdit').value = response.data.sale;
                                    document.getElementById('profitEdit').value = response.data.profit;
                                    document.getElementById('hiddenId').value = response.data.id;
                                })
                                .catch(error => {
                                    // 失敗した時
                                    console.log(error);
                                    alert(error);
                                })
                                .finally(() => {
                                    // 成功失敗どちらでも実行
                                });;
                            // モーダルの表示
                            document.getElementById('modal').style.display = 'block';
                        });
                    });
                    // 削除ボタンクリック時の処理
                    // phpにデータを送信してdbのデータを削除してもらう
                    document.querySelectorAll('.deleteButton').forEach(x => {
                        x.addEventListener('click', e => {
                            if (window.confirm('Are you sure?')) {
                                const id = e.target.value;
                                const requestUrl = `../api/delete.php?id=${id}`;
                                axios.delete(requestUrl)
                                    .then(response => {
                                        console.log(response.data);
                                        alert('deleted!');
                                        // 最新のデータを取得
                                        readData(readUrl);
                                    })
                                    .catch(error => {
                                        // 失敗した時
                                        console.log(error);
                                        alert(error);
                                    })
                                    .finally(() => {
                                        // 成功失敗どちらでも実行
                                    });;
                            }
                        });
                    });
                    return response;
                })
                .catch(error => {
                    // 失敗した時
                    console.log(error);
                    alert(error);
                })
                .finally(() => {
                    // 成功失敗どちらでも実行
                });
        }


        // 送信ボタンクリック時の処理
        document.getElementById('send').addEventListener('click', () => {
            // createの処理
            // formのキーとバリューを入れる容器を準備する
            const postData = new FormData();
            // postDataに必要なパラメータを追加する
            postData.append('year', document.getElementById('year').value);
            postData.append('purchase', document.getElementById('purchase').value);
            postData.append('sale', document.getElementById('sale').value);
            postData.append('profit', document.getElementById('profit').value);
            postData.append('upfile', document.getElementById('image').files[0]);



            // ファイルの内容をpostDataに追加しよう！

            console.log(...postData.entries());
            // 送信先urlの指定
            const fileUpLoadUrl = '../api/upload.php';
            // 送信の処理
            axios.post(fileUpLoadUrl, postData)
                .then(response => {
                    // 成功した時
                    console.log(response);
                    readData(readUrl);
                    // 入力欄を空にする処理
                    document.getElementById('year').value = '';
                    document.getElementById('purchase').value = '';
                    document.getElementById('sale').value = '';
                    document.getElementById('profit').value = '';;
                    // input type=fileも空にする
                })
                .catch(error => {
                    // 失敗した時
                    console.log(error);
                    alert(error);
                })
                .finally(() => {
                    // 成功失敗どちらでも実行
                });
        });

        // アップデートフォームのupdateボタンクリック時の処理
        // phpにデータを送信してdbのデータを更新してもらう
        document.getElementById('updateButton').addEventListener('click', e => {
            // 更新したいレコードのidを取得
            const updateId = document.getElementById('hiddenId').value;
            // formのキーとバリューを入れる容器を準備する
            const updateData = new FormData();
            // dataに必要なパラメータを追加する
            updateData.append('year', document.getElementById('yearEdit').value);
            updateData.append('purchase', document.getElementById('purchaseEdit').value);
            updateData.append('sale', document.getElementById('saleEdit').value);
            updateData.append('profit', document.getElementById('profitEdit').value);
            updateData.append('updatedby', document.getElementById('updatedby').value);

            console.log(...updateData.entries());
            // PUTメソッドの設定
            const config = {
                headers: {
                    'X-HTTP-Method-Override': 'PUT',
                }
            }
            // 送信先の指定
            const requestUrl = `../api/update.php?id=${updateId}`;
            // 送信の処理
            axios.post(requestUrl, updateData, config)
                .then(response => {
                    alert('updated!');
                    // モーダルを閉じる
                    document.getElementById('modal').style.display = 'none';
                    // 最新のデータを取得
                    readData(readUrl);
                })
                .catch(error => {
                    // 失敗した時
                    console.log(error);
                    alert(error);
                })
                .finally(() => {
                    // 成功失敗どちらでも実行
                });
        });

        // 
        // カラム名クリック時の並び替え処理
        // thタグ全てにクリックイベントを設定
        document.querySelectorAll('th').forEach(x => {
            x.addEventListener('click', e => {
                // thタグのテキストを取得
                const columnName = e.target.innerText;
                // urlに入れて送信
                const requestUrl = `../api/sort.php?columnName=${columnName}`;
                readData(requestUrl);
            });
        });

        // 読み込み時のデータ取得処理
        window.onload = () => {
            readData(readUrl);
        };
    </script>
    <script>
        Morris.Line({
            element: 'chart',
            data: [<?php echo $chart_data; ?>],
            xkey: 'year',
            ykeys: ['profit', 'purchase', 'sale'],
            labels: ['利益', '仕入', '売上'],
            hideHover: 'auto',
            stacked: true
        });
    </script>
</body>

</html>