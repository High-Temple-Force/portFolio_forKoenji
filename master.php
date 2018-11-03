<?php
session_start();
// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: logout.php");
    exit;
}
$title = Array();
$text = Array();
$url = Array();
       try {
        $pdo = new PDO ( 'mysql:dbname=koenji; host=localhost;port=3306; charset=utf8', 'root', 'Zaq12wsx!' );
        $cmd = 'SELECT p_title, p_text, p_url FROM t_a_product;';
        foreach($pdo->query($cmd) as $row){
            $title[] = $row[0];
            $text[] = $row[1];
            $url[] = $row[2];
        }
    }   catch (PDOException $e) {
        $errorMessage = 'データベースエラー';
    }
?>

<!DOCTYPE html>
<html>
    <head>

    </head>


    <body>
        <?php
            for ($i=0; $i<count($title); $i++){
                echo $title[i];
                echo $text[i];
                echo $row[i];
            }
        ?>

    </body>

</html>