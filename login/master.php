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
//ページフラッグ変数定義
$page_flag = 2; //プロダクト追加用ページフラッグ
$page_flag_change = 1; //プロダクト内容編集・削除用ページフラッグ

//追加処理
//追加内容確認処理
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
//追加内容入力処理
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
                VALUES ("' .$title .'","' .$text .'","' .$link .'");';
            $pdo->query($cmd);
            $Message = '登録が完了しました。';
            $_SESSION['state'] = 'add';
            header("Location: master.php");
        } catch (PDOException $e) {
            $Message = 'データベースエラー';
            
        }
    }
}

//削除処理
if (isset($_POST["btn_delete"])) {
    try {
        $pdo = new PDO ( 'mysql:dbname=koenji; host=localhost;port=3306; charset=utf8', 'root', 'Zaq12wsx!' );  
        $cmd = 'DELETE from koenji.' .$_SESSION['table'] .' where p_number = ' .$_POST['btn_delete'] .';';
        $pdo->query($cmd);
        $Message2 = '削除が完了しました。';
        $_SESSION['state'] = 'change';
        header("Location: master.php");
    } catch (PDOException $e) {
        $Message2 = 'データベースエラー';
    }
}

//編集処理
//編集ボタン押下時確認処理
if (isset($_POST["btn_edit"])) {
    $page_flag_change = 2;
    $name = $_POST['e_name'];
    $text = $_POST['e_text'];
    $link = $_POST['e_link'];
    $p_num = $_POST['e_num'];
    $_SESSION['state'] = 'change';
}
//編集内容確認処理
if (isset($_POST["confirm_edit"])) {
    $page_flag = 2;
    if (empty($_POST["name"])) {  // emptyは値が空のとき
        $Message = 'タイトルが未入力です。';
    } else if (empty($_POST["text"])) {
        $Message = '説明文が未入力です。';
    } else if (empty($_POST["link"])) {
        $Message = 'リンクが未入力です。';
    } else {
        $page_flag_change = 3;
    }
} 
//編集内容追加処理
if (isset($_POST["btn_edit_submit"])) {
    if (!empty($_POST["name"]) && !empty($_POST["text"]) && !empty($_POST["link"])) {
        $title = $_POST["name"];
        $text = $_POST["text"];
        $link = $_POST["link"];
        $p_num = $_POST["p_num"];
        //入力値DB登録処理
        try {
            $pdo = new PDO ( 'mysql:dbname=koenji; host=localhost;port=3306; charset=utf8', 'root', 'Zaq12wsx!' );  
            $cmd = 'UPDATE koenji.'.$_SESSION['table'].' SET 
            p_title = "'.$title.'", p_text = "'.$text.'", p_url = "'.$link.'" where p_number = '.$p_num.';';
            $pdo->query($cmd);
            $Message = '登録が完了しました。';
            $_SESSION['state'] = 'change';
            header("Location: master.php");
        } catch (PDOException $e) {
            $Message = 'データベースエラー';
            $_SESSION['state'] = 'add';
            header("Location: master.php");
        }
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
    <script type="text/javascript"
        src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js">
    </script>
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
        <input id="add" type="radio" name="tab_item" value="add" 
            <?php if($_SESSION['state']!='change') {print 'checked';} ?>>
        <label class="tab_item" for="add">新規追加</label>
        <input id="change" type="radio" name="tab_item" value="change" 
            <?php if($_SESSION['state']=='change') {print 'checked';} ?>>
        <label class="tab_item" for="change">内容変更</label>
        <!--新規追加側タブ内容-->
        <div class="tab_content" id="add_content">
            <div class="tab_content_description">
                <!--入力内容確認画面-->
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
                <!--初期画面、追加画面-->
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
        <!--内容変更側タブ内容-->
        <div class="tab_content" id="change_content">
            <div class="tab_content_description">
                <!--テーブル内容表示画面-->
                <?php if ($page_flag_change === 1): ?>
                    <div><font color="#ff0000"><?php echo htmlspecialchars($Message2, $ENT_QUOTES); ?></font></div>
                    <div class="flex">
                        <?php
                            foreach($product as $p) {
                                print '<div class="col">';
                                print '<form action="#" method="POST">';
                                print '<h5 class="his-content" name="c_name">' .$p[0] .'<br>';
                                print '<p class="content-text" name="c_text">' .$p[1] .'</p>';
                                print '<a name="c_link" href="' .$p[2] .'" class="his-link">link</a>';
                                print '<div class="btn">';
                                print '<button type="submit" class="btn" name="btn_edit" value="' .$p[3] .'">編集</button>';
                                print '<button type="submit" class="btn" name="btn_delete" value="' .$p[3] .'">削除</button>';
                                print '<input type="hidden" name="e_name" value="'.$p[0].'">';
                                print '<input type="hidden" name="e_text" value="'.$p[1].'">';
                                print '<input type="hidden" name="e_link" value="'.$p[2].'">';
                                print '<input type="hidden" name="e_num" value="'.$p[3].'">';
                                print '</div>';
                                print '</h5>';
                                print '</form>';
                                print '</div>';
                            }
                            //unset($p);
                        ?>
                    </div>
                <!--編集内容入力画面-->
                <?php elseif ( $page_flag_change === 2 ): ?>
                    <div class="form">
                        <!--ここに、アクションのタイプ記入-->
                        <form action="" method="POST">                            
                            <div class="name">
                                <h3><br />Product Name : </h3>
                                <p>プロダクトのタイトルを入力してください。<br /></p>
                                    <textarea name="name" rows="1" cols="55"><?php echo $name; ?></textarea><br /><br />
                            </div>
                            <div class="text">
                                <h3>Description : </h3>
                                <p>プロダクトの説明文を入力してください。<br /></p>
                                    <textarea name="text" rows="6" cols="55"><?php echo $text; ?></textarea><br /><br />
                            </div>
                            <div class="link">
                                <h3>Link : </h3>
                                <p>プロダクトのURLを入力してください。 <br /></p>
                                    <textarea name="link" rows="1" cols="55"><?php echo $link; ?></textarea><br /><br />
                            </div>
                            <div class="p_num">
                                <input type="hidden" name="p_num" value="<?php echo $p_num; ?>">
                            </div>
                            <div class="submit">
                                <p><input type="submit" name="confirm_edit" value="内容を確認する"></p>
                            </div>  
                        </form>    
                    </div>

                <!--編集内容確認画面-->
                <?php elseif ($page_flag_change === 3): ?>

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
                        <input type="submit" name="btn_edit_submit" value="送信">
                        <input type="hidden" name="name" value="<?php echo $_POST["name"]; ?>">
                        <input type="hidden" name="text" value="<?php echo $_POST["text"]; ?>">
                        <input type="hidden" name="link" value="<?php echo $_POST["link"]; ?>">
                        <input type="hidden" name="p_num" value="<?php echo $_POST["p_num"]; ?>">
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>