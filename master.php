<?php
session_start();
// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: logout.php");
    exit;
}
$errorMessage = "";

if (isset($_POST["submit"])) {
    if (empty($_POST["name"])) {  // emptyは値が空のとき
        $errorMessage = 'タイトルが未入力です。';
    } else if (empty($_POST["text"])) {
        $errorMessage = '説明文が未入力です。';
    } else if (empty($_POST["link"])) {
        $errorMessage = 'リンクが未入力です。';
    }
    if (!empty($_POST["name"]) && !empty($_POST["text"]) && !empty($_POST["link"])) {
        $title = $_POST["name"];
        $text = $_POST["text"];
        $link = $_POST["link"];
        try {
            $pdo = new PDO ( 'mysql:dbname=koenji; host=localhost;port=3306; charset=utf8', 'root', 'Zaq12wsx!' );
            $cmd = 'INSERT INTO koenji.t_a_product (p_title,p_text,p_url) values (' .$title .',' .$text .',' .$link .');';
            $pdo->query($cmd);
            print $cmd;
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Portfolio form</title>
        <link rel="stylesheet" href="form.css">
    </head>


    <body>
        <div class="title">
            <h2>
                    Portfolio 入力Form　<br />
            </h2>
        </div>
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
        <div class="form">
            <!--ここに、アクションのタイプ記入-->
            <form action="" method="POST">
                <div class="name">
                    <h3><br />Product Name : </h3>
                    <p>
                        プロダクトのタイトルを入力してください。<br />  
                            <textarea name="name" rows="1" cols="55" ></textarea><br /><br />
                    </p>
                </div>

                <div class="text">
                    <h3>Description : </h3>
                     <p>
                        プロダクトの説明文を入力してください。<br />
                         <textarea name="text" rows="6" cols="55"></textarea><br /><br />
        
                    </p>
                </div>

                <div class="link">
                    <h3>Link : </h3>

                    <p>
                        プロダクトのURLを入力してください。 <br />
                        <textarea name="link" rows="1" cols="55"></textarea><br /><br />
                    </p>
                </div>
                
                <div class="submit">
                    <p>
                        <input type="submit" name="submit" value="送信">
                    </p>
                </div>  
            </form>    

        </div>
        
    </body>



</html>