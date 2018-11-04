<?php
session_start();
// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: logout.php");
    exit;
}
$Message = "";




if (isset($_POST["submit"])) {
    if (empty($_POST["name"])) {  // emptyは値が空のとき
        $Message = 'タイトルが未入力です。';
    } else if (empty($_POST["text"])) {
        $Message = '説明文が未入力です。';
    } else if (empty($_POST["link"])) {
        $Message = 'リンクが未入力です。';
    }
    if (!empty($_POST["name"]) && !empty($_POST["text"]) && !empty($_POST["link"])) {
        $title = $_POST["name"];
        $text = $_POST["text"];
        $link = $_POST["link"];
        try {
            $pdo = new PDO ( 'mysql:dbname=koenji; host=localhost;port=3306; charset=utf8', 'root', 'Zaq12wsx!' );
            $cmd = 'INSERT INTO koenji.t_a_product (p_title,p_text,p_url) values ("' .$title .'","' .$text .'","' .$link .'");';
            $pdo->query($cmd);
            $Message = '登録が完了しました。';
        } catch (PDOException $e) {
            $Message = 'データベースエラー';
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
        
        
    </body>



</html>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Koenjineer Portfolio</title>
    <link rel="stylesheet" href="index.css">

    ​
</head>

<body>
  <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:300|Amatic+SC:700|Anton|Bangers|Caveat|Cherry+Swash:700|Corben:700|Creepster|Economica:700|Homemade+Apple|IM+Fell+DW+Pica+SC|Kaushan+Script|Londrina+Shadow|Montserrat+Subrayada|Oswald:700|Permanent+Marker|Quicksand|Roboto+Condensed:700|Teko|Vollkorn" rel="stylesheet">

    <header class="header">
        <h1>Koenjineer Portfolio　edit</h1>
        <ul>
            <li><a class="active" href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="form.html">Login</a></li>
        </ul>
    </header>

    <div class="tabs">

        <input id="add" type="radio" name="tab_item" checked>
        <label class="tab_item" for="add">新規追加</label>
        <input id="change" type="radio" name="tab_item" >
        <label class="tab_item" for="change">プロダクト内容変更/label>
        

            <div class="tab_content" id="add_content">
                <div class="tab_content_description">
                <div><font color="#ff0000"><?php echo htmlspecialchars($Message, ENT_QUOTES); ?></font></div>
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
                </div>
            </div>


            <div class="tab_content" id="change_content">
                <div class="tab_content_description">
                    
                </div>
            </div>

            
            <script type="text/javascript" src="./onmouse-1.js" charset="utf-8"></script>
    </div>
</body>

</html>