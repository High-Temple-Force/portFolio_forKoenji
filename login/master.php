<?php
session_start();
// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: logout.php");
    exit;
}


//セッション管理処理
$Message = "";
$Message2 = '';
$product = Array();
$pdo = new PDO ( 'mysql:dbname=koenji; host=localhost;port=3306; charset=utf8', 'root', 'Zaq12wsx!' );
$cmd = 'SELECT p_title,p_text,p_url,p_number from ' .$_SESSION['table'] .';';
foreach($pdo->query($cmd) as $row){
    $product[] = $row;
}



//入力値確認処理
$page_flag = 2;
if (isset($_POST["confirm"])) {
    $page_flag = 2;
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
        $page_flag = 1; //追加内容確認Page
    }
} 
if (isset($_POST["btn_submit"])) {
    $page_flag = 2; //追加送信後Page
    if (!empty($_POST["name"]) && !empty($_POST["text"]) && !empty($_POST["link"])) {
        $title = $_POST["name"];
        $text = $_POST["text"];
        $link = $_POST["link"];
        //入力値DB登録処理
        try {
            $pdo = new PDO ( 'mysql:dbname=koenji; host=localhost;port=3306; charset=utf8', 'root', 'Zaq12wsx!' );  
            $cmd = 'INSERT INTO koenji.' .$_SESSION['table'] .' (p_title,p_text,p_url) 
                values ("' .$title .'","' .$text .'","' .$link .'");';
            $pdo->query($cmd);
            $Message = '登録が完了しました。';
        } catch (PDOException $e) {
            $Message = 'データベースエラー';
        }
    }
}
if (isset($_POST["btn_delete"])) {
    try {
        $pdo = new PDO ( 'mysql:dbname=koenji; host=localhost;port=3306; charset=utf8', 'root', 'Zaq12wsx!' );  
        $cmd = 'delete from koenji.' .$_SESSION['table'] .' where p_number = ' .$_POST['btn_delete'] .';';
        $pdo->query($cmd);
        $Message2 = '削除が完了しました。';
    } catch (PDOException $e) {
        $Message2 = 'データベースエラー';
    }
}
?>

<!--ここからHTML-->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Koenjineer Portfolio</title>
        <link rel="stylesheet" href="main.css">
    </head>


    <body>
        <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:300|Amatic+SC:700|Anton|Bangers|Caveat|Cherry+Swash:700|Corben:700|Creepster|Economica:700|Homemade+Apple|IM+Fell+DW+Pica+SC|Kaushan+Script|Londrina+Shadow|Montserrat+Subrayada|Oswald:700|Permanent+Marker|Quicksand|Roboto+Condensed:700|Teko|Vollkorn" rel="stylesheet">
        <header class="header">
            <h1>Koenjineer Portfolio edit logined by <?php print $_SESSION['NAME']; ?></h1>
            <ul>
                <li><a class="active" href="../index.php">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </header>
        <div class="tabs">
            <input id="add" type="radio" name="tab_item" checked>
            <label class="tab_item" for="add">新規追加</label>
            <input id="change" type="radio" name="tab_item" >
            <label class="tab_item" for="change">内容変更</label>
            
            <div class="tab_content" id="add_content">
                <div class="tab_content_description">
                <?php if ($page_flag === 1): ?>
                    <form action="" method="POST">
                        <div class="confirm">
                            <h2>以下の入力内容でよろしいですか？ <br/></h2>
                        </div>
                        <div class="form">
                            <h3>Product Name : <br /></h3>
                            <p><?php echo $_POST["name"];?> <br/></p>
                        </div>
                        <div class="form">
                            <h3>Description : <br /></h3>
                            <p><?php echo $_POST["text"]?> <br/></p>
                        </div>
                        <div class="form">
                            <h3>Link : <br /></h3>
                            <p><?php echo $_POST["link"]?> <br/></p>
                        </div>

                        <input type="submit" name="btn_back" value="戻る">
                        <input type="submit" name="btn_submit" value="送信">
                        <input type="hidden" name="name" value="<?php echo $_POST["name"]; ?>">
                        <input type="hidden" name="text" value="<?php echo $_POST["text"]; ?>">
                        <input type="hidden" name="link" value="<?php echo $_POST["link"]; ?>">
                    </form>
                <?php elseif ( $page_flag === 2 ): ?>
                    <div><font color="#ff0000"><?php echo htmlspecialchars($Message, ENT_QUOTES); ?></font></div>

                    <div class="form">
                    <!--ここに、アクションのタイプ記入-->
                        <form action="" method="POST">                            
                            <div class="name">
                                <h3><br />Product Name : </h3>
                                <p>プロダクトのタイトルを入力してください。<br />  
                                    <textarea name="name" rows="1" cols="55" ></textarea><br /><br />
                                </p>
                            </div>
                            <div class="text">
                                <h3>Description : </h3>
                                <p>プロダクトの説明文を入力してください。<br />
                                    <textarea name="text" rows="6" cols="55"></textarea><br /><br />
                                </p>
                            </div>
                            <div class="link">
                                <h3>Link : </h3>
                                <p>プロダクトのURLを入力してください。 <br />
                                    <textarea name="link" rows="1" cols="55"></textarea><br /><br />
                                </p>
                            </div>
                            <div class="submit">
                                <p><input type="submit" name="confirm" value="内容を確認する"></p>
                            </div>  
                        </form>    
                    </div>
                <?php endif; ?>
                </div>
            </div>
            <div class="tab_content" id="change_content">
                <div class="tab_content_description">
                    <div class="flex">
                    <div><font color="#ff0000"><?php echo htmlspecialchars($Message2, ENT_QUOTES); ?></font></div>
                        <?php
                            foreach($product as $p){
                                print '<div class="col">';
                                print '<h5 class="his-content">' .$p[0] .'<br>';
                                print '<p class="content-text">' .$p[1] .'</p>';
                                print '<a href="' .$p[2] .'" class="his-link">link</a>';
                                print '<div class="btn">';
                                print '<form action="#" method="POST">';
                                print '<button type="button" name="btn_edit" value="' .$p[3] .'">編集</button>';
                                print '<button type="button" name="btn_delete" value="' .$p[3] .'">削除</button>';
                                print '</form>';
                                print '</div>';
                                print '</h5>';
                                print '</div>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="../onmouse-1.js" charset="utf-8"></script>
    </body>
</html>