<?php
//セッション管理処理
session_start();
// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: logout.php");
    exit;
}

//各変数定義
$Message = ""; 
$name = $_SESSION["NAME"];
global $name;
$product = Array();
$pdo = new PDO ( 'mysql:dbname=koenji; host=localhost;port=3306; charset=utf8', 'root', 'Zaq12wsx!' );
$page_flag = 0;

//DBの表示、product配列に格納
if ($name == "takuto") {  
    $cmd = 'SELECT p_title,p_text,p_url,p_number from t_a_product;';
    foreach($pdo->query($cmd) as $row){
        $product[] = $row;
    }
} elseif ($name == "hayato") {
    $cmd = 'SELECT p_title,p_text,p_url,p_number from t_m_product;';
    foreach($pdo->query($cmd) as $row){
        $product[] = $row;
    }
} elseif ($name == "daiki") {
    $cmd = 'SELECT p_title,p_text,p_url,p_number from t_y_product;';
    foreach($pdo->query($cmd) as $row){
        $product[] = $row;
    }
} 

//入力値確認処理、「内容を確認する」ボタンが押されたら
if (isset($_POST["confirm"])) {
    $page_flag = 2;
    if (empty($_POST["name"])) {  // emptyは値が空のとき
        $Message = 'タイトルが未入力です。';
    } elseif (empty($_POST["text"])) {
        $Message = '説明文が未入力です。';
    } elseif (empty($_POST["link"])) {
        $Message = 'リンクが未入力です。';
    } else {
        $page_flag = 1; //追加内容確認Page
    }
} 

//確認Page後、登録処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["btn_submit"])) {
        if (!empty($_POST["name"]) && !empty($_POST["text"]) && !empty($_POST["link"])) {
            $title = $_POST["name"];
            $text = $_POST["text"];
            $link = $_POST["link"];
            //入力値DB登録処理
            try {
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
                header('Location: master.php'); 
                $Message = '登録が完了しました。';
                $page_flag = 2; //追加送信後Page
            } catch (PDOException $e) {
                header('Location: master.php'); 
                $Message = 'データベースエラー'; 
                $page_flag = 2; //追加送信後Page
            }
        }
    }
} else {//リロードした場合
    $page_flag = 0;
}

// 削除ボタンが押された場合の処理関数
function del_btn($arrayvalue) {
        global $Message;
        $Message = "";
        $name = $_SESSION["NAME"];
        $pdo = new PDO ( 'mysql:dbname=koenji; host=localhost;port=3306; charset=utf8', 'root', 'Zaq12wsx!' );
        //takuto
        if ($name == "takuto") { 
            $tablex = "a" ;
        //hayato
        } elseif ($name == "hayato") {
            $tablex = "m" ;
        //daiki
        } elseif ($name == "daiki") {
            $tablex = "y" ;
        //三人以外はエラー返す
        } else {
            $Message = "セッションエラー" ;
            $page_flag = 2;
            return $page_flag;
        }
        try {
            //引数は、配列の場所示す
            //DB項目削除後に、もう一度autoincreを振りなおしている
            $cmd = 'DELETE from t_'.$tablex.'_product where p_number='.$arrayvalue.';';
            $cmd_drop = 'alter table t_'.$tablex.'_product drop column p_number;';
            $cmd_add = 'alter table t_'.$tablex.'_product add p_number int(11) primary key not null auto_increment;';
            $cmd_auto = 'alter table t_'.$tablex.'_product auto_increment =1;';
            $pdo->query($cmd) ;
            $pdo->query($cmd_drop) ;
            $pdo->query($cmd_add) ;
            $pdo->query($cmd_auto) ;
            $Message = "削除しました。";
        } catch (PDOException $e) {
            $Message = "データベースエラー";
        }
        $page_flag = 2;
        return $Message;
        return $page_flag;
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
            <h1>Koenjineer Portfolio edit logined by <?php print $name; ?></h1>
            <ul>
                <li><a class="active" href="../index.php">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </header>

        <!--追加内容確認ページ、page_flag=１-->
        <?php if ($page_flag == 1) : ?>
            <div class="tabs">
                <input id="add" type="radio" name="tab_item" checked>
                <label class="tab_item" for="add">新規追加</label>
                <input id="change" type="radio" name="tab_item" >
                <label class="tab_item" for="change">内容変更</label>
    
                    <div class="tab_content" id="add_content">
                        <div class="tab_content_description">
                            <form action="" method="POST">
                                <div class="confirm">
                                    <h2>以下の入力内容でよろしいですか？ <br/></h2>
                                </div>
                                <div class="form">
                                    <h3>Product Name : <br /></h3>
                                    <p><?php echo $_POST["name"]; ?> <br/></p>
                                </div>
                                <div class="form">
                                    <h3>Description : <br /></h3>
                                    <p><?php echo $_POST["text"]; ?> <br/></p>
                                </div>
                                <div class="form">
                                    <h3>Link : <br /></h3>
                                    <p><?php echo $_POST["link"]; ?> <br/></p>
                                </div>
                                <input type="submit" name="btn_back" value="戻る">
                                <input type="submit" name="btn_submit" value="送信">
                                <input type="hidden" name="name" value='<?php echo $_POST["name"]; ?>'>
                                <input type="hidden" name="text" value='<?php echo $_POST["text"]; ?>'>
                                <input type="hidden" name="link" value='<?php echo $_POST["link"]; ?>'>
                            </form>
                        </div>
                    </div>
            </div>

        <!--基本ページ、page_flag=0 or none-->
        <!--メッセージ表示、page_flag ===2 -->
        <?php else: ?> 
            <div class="tabs">
                <input id="add" type="radio" name="tab_item" checked>
                <label class="tab_item" for="add">新規追加</label>
                <input id="change" type="radio" name="tab_item" >
                <label class="tab_item" for="change">内容変更</label>
                <div class="tab_content" id="add_content">
                    <div class="tab_content_description">
                        <?php if ($page_flag == 2) {
                            $redtext = "<span style='color:red'> $Message </span>";
                            echo $redtext;
                            } ?>    
                        <div class="form">
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
                                    <p>  <input type="submit" name="confirm" value="内容を確認する"></p>
                                </div>  
                            </form>    
                        </div>
                    </div>
                </div>
                <div class="tab_content" id="change_content">
                    <div class="tab_content_description">
                        <div class="flex">
                            <?php
                                foreach($product as $p) {
                                    print '<div class="col">';
                                    print '<h5 class="his-content">' .$p[0] .'<br>';
                                    print '<p class="content-text">' .$p[1] .'</p>';
                                    print '<a href="' .$p[2] .'" class="his-link">link</a>';
                                    print '<input type="hidden" class="p_number" value="'.$p[3] .'">';
                                    print '<form action="" method="POST">';
                                    print '<input type="submit" name="btn_edit" value="編集">';
                                    print '<input type="submit" name="btn_delete" value="削除">';
                                    print '</form>';
                                    print '</h5>';
                                    print '</div>';
                                    if (isset($_POST["btn_delete"])) {
                                        del_btn($p[3]);
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript" src="../onmouse-1.js" charset="utf-8"></script>
        <?php endif; ?>
    </body>
</html>