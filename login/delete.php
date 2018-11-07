<?php
// セッション開始
session_start();
// エラーメッセージの初期化
$errorMessage = "";


// 削除ボタンが押された場合
if (isset($_POST["btn_delete"])) {
    $Message = "";
    $name = $_SESSION["NAME"];
    $product = Array();
    $pdo = new PDO ( 'mysql:dbname=koenji; host=localhost;port=3306; charset=utf8', 'root', 'Zaq12wsx!' );
    //takuto
    if ($name == "takuto") { 
        $cmd = 'DELETE p_title,p_text,p_url from t_a_product;';
        foreach($pdo->query($cmd) as $row){
            $product[] = $row;
        }
    //hayato
    } elseif ($name == "hayato") {
        $cmd = 'DELETE p_title,p_text,p_url from t_m_product;';
        foreach($pdo->query($cmd) as $row){
            $product[] = $row;
        }
    //daiki
    } elseif ($name == "daiki") {
        $cmd = 'DELETE p_title,p_text,p_url from t_y_product;';
        foreach($pdo->query($cmd) as $row){
            $product[] = $row;
        }
    } 


}




?>