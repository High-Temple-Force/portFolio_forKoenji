<?php
// セッション開始
session_start();
// エラーメッセージの初期化
$errorMessage = "";


// 編集ボタンが押された場合
if (isset($_POST["btn_edit"])) {
    $Message = "";
    $name = $_SESSION["NAME"];
    $product = Array();
    $pdo = new PDO ( 'mysql:dbname=koenji; host=localhost;port=3306; charset=utf8', 'root', 'Zaq12wsx!' );
    if ($name == "takuto") { 
        $cmd = 'SELECT p_title,p_text,p_url from t_a_product;';
        foreach($pdo->query($cmd) as $row){
            $product[] = $row;
        }
    } elseif ($name == "hayato") {
        $cmd = 'SELECT p_title,p_text,p_url from t_m_product;';
        foreach($pdo->query($cmd) as $row){
            $product[] = $row;
        }
    } elseif ($name == "daiki") {
        $cmd = 'SELECT p_title,p_text,p_url from t_y_product;';
        foreach($pdo->query($cmd) as $row){
            $product[] = $row;
        }
    } 


}




?>