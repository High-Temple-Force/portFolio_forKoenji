<?php
// セッション開始
session_save_path('/tmp/koenji');
session_start();
// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["userid"])) {  // emptyは値が空のとき
        $errorMessage = 'ユーザIDが未入力です。';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    }
 
    if (!empty($_POST["userid"]) && !empty($_POST["password"])) {
        $userid = $_POST["userid"];
        $password = $_POST["password"];

        try {
            $pdo = new PDO ( 'mysql:dbname=koenji; host=localhost;port=3306; charset=utf8', 'root', 'Zaq12wsx!' );
            $cmd = 'SELECT * FROM t_master WHERE id ="' .$userid .'";';
            foreach($pdo->query($cmd) as $row){
                $dbuserid = $row['id'];
                $dbpassword = $row['password'];
            }
            if ($password==$dbpassword) {
                session_regenerate_id(true);
                $_SESSION["NAME"] = $userid; 
                $_SESSION['state'] = 'add';
                if ($_SESSION["NAME"] == "takuto") { 
                    $_SESSION["table"] = "t_a_product" ;
                //hayato
                } elseif ($_SESSION["NAME"] == "hayato") {
                    $_SESSION["table"] = "t_m_product" ;
                //daiki
                } elseif ($_SESSION["NAME"] == "daiki") {
                    $_SESSION["table"] = "t_y_product" ;
                //三人以外はエラー返す
                }
                header("Location: master.php");  // メイン画面へ遷移
                exit();  // 処理終了
            } else {
                // 認証失敗
                $errorMessage = 'ユーザIDあるいはパスワードに誤りがあります。';
            }
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
        }
    }
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Koenjineer Portfolio</title>
        <link rel="stylesheet" href="main.css">
  ​
    </head>
    
    <body>
        <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:300|Amatic+SC:700|Anton|Bangers|Caveat|Cherry+Swash:700|Corben:700|Creepster|Economica:700|Homemade+Apple|IM+Fell+DW+Pica+SC|Kaushan+Script|Londrina+Shadow|Montserrat+Subrayada|Oswald:700|Permanent+Marker|Quicksand|Roboto+Condensed:700|Teko|Vollkorn" rel="stylesheet">

        <header class="header">
            <h1>Koenjineer Portfolio login</h1>
            <ul>
                <li><a class="active" href="../index.php">Home</a></li>
            </ul>
        </header>
        <div class="tabs">
            <div class="login">
                <form id="loginForm" name="loginForm" action="" method="POST">
                    
                        
                        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                        <label for="userid">ユーザーID</label><input type="text" id="userid" name="userid" placeholder="ユーザーIDを入力" value="<?php if (!empty($_POST["userid"])) {echo htmlspecialchars($_POST["userid"], ENT_QUOTES);} ?>">
                        <br>
                        <label for="password">パスワード</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                        <br>
                        <input type="submit" id="login" name="login" value="ログイン">
                    
                </form>
                <br>
            </div> 
        </div>
    </body>
</html>