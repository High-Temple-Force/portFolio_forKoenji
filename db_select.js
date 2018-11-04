//テスト用にDBを操作するためのスクリプトです
//別途MySQLでDBを用意する必要があります


//変数設定まとめ
var usr_name = "root";  //mysqlユーザーネーム
var usr_pass = "kourakU";   //ユーザーパスワード
var db_name = "testdatabase";   //DB名前
var table_name = "userdata";    //扱うテーブルネーム
    
//require
var mysql = require('mysql');

//MySQLとのコネクションの作成
var connection = mysql.createConnection({
    host : "localhost",
    user : usr_name,
    password : usr_pass,
    database : db_name
});

//接続
connection.connect();

//userdataの取得
connection.query("SELECT * from " + table_name + ";", function (err, rows, fields) {
    if (err) {console.log("err:" + err)
    } else {console.log("Successfully Connected")};

    console.log("name: " + rows[0].name);
    console.log("id: " + rows[0].id);
});

//切断
connection.end();