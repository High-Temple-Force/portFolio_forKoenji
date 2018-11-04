<?php
session_start();
// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: logout.php");
    exit;
}
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




if (isset($_POST["submit"])) {
    if (empty($_POST["name"])) {  // emptyは値が空のとき
        $Message = 'タイトルが未入力です。';
    } else if (empty($_POST["text"])) {
        $Message = '説明文が未入力です。';
    } else if (empty($_POST["link"])) {
        $Message = 'リンクが未入力です。';
    } else if (empty($_POST["userdef"])) {
        $Message = 'ユーザーが指定されていません。';
    }
    if (!empty($_POST["name"]) && !empty($_POST["text"]) && !empty($_POST["link"])) {
        $title = $_POST["name"];
        $text = $_POST["text"];
        $link = $_POST["link"];
        //ユーザー選択変数
        //$username = $_POST["userdef"];
        try {
            $pdo = new PDO ( 'mysql:dbname=koenji; host=localhost;port=3306; charset=utf8', 'root', 'Zaq12wsx!' );
            if ($name == "takuto") {  
                $cmd = 'INSERT INTO koenji.t_a_product (p_title,p_text,p_url) values 
                    ("' .$title .'","' .$text .'","' .$link .'");';
            } elseif ($name == "hayato") {
                $cmd = 'INSERT INTO koenji.t_m_product (p_title,p_text,p_url) values 
                    ("' .$title .'","' .$text .'","' .$link .'");';
            } elseif ($name == "daiki") {
                $cmd = 'INSERT INTO koenji.t_y_product (p_title,p_text,p_url) values 
                    ("' .$title .'","' .$text .'","' .$link .'");';
            } 

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
        <title>Koenjineer Portfolio</title>
        <link rel="stylesheet" href="main.css">

        ​
    </head>

    <body>
        <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:300|Amatic+SC:700|Anton|Bangers|Caveat|Cherry+Swash:700|Corben:700|Creepster|Economica:700|Homemade+Apple|IM+Fell+DW+Pica+SC|Kaushan+Script|Londrina+Shadow|Montserrat+Subrayada|Oswald:700|Permanent+Marker|Quicksand|Roboto+Condensed:700|Teko|Vollkorn" rel="stylesheet">

        <header class="header">
            <h1>Koenjineer Portfolio edit logined by <?php print $name; ?></h1>
            <ul>
                <li><a class="active" href="../index.php">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </header>

        <div class="tabs">

            <input id="add" type="radio" name="tab_item" checked>
            <label class="tab_item" for="add">新規追加</label>
            <input id="change" type="radio" name="tab_item" >
            <label class="tab_item" for="change">プロダクト内容変更</label>
            

            <div class="tab_content" id="add_content">
                <div class="tab_content_description">
                    <div><font color="#ff0000"><?php echo htmlspecialchars($Message, ENT_QUOTES); ?></font></div>

                    
                    <div class="form">
                        <!--ここに、アクションのタイプ記入-->
                        <form action="" method="POST">
                              <!--ユーザー選択のセレクトボックス-->
                            
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
                    <div class="flex">
                        <?php
                            foreach($product as $p){
                                print '<div class="col">';
                                print '<h5 class="his-content">' .$p[0] .'<br>';
                                print '<p class="content-text">' .$p[1] .'</p>';
                                print '<a href="' .$p[2] .'" class="his-link">link</a>';
                                print '</h5>';
                                print '</div>';
                            }
                        ?>

                    </div>
                </div>
            </div>
            <script type="text/javascript" src="../onmouse-1.js" charset="utf-8"></script>
        </div>
    </body>
</html>