<?php
session_start();
// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: logout.php");
    exit;
}
//セッション管理処理
<<<<<<< HEAD
$Message = ""; 
$name = $_SESSION["NAME"];
$product = Array();
$pdo = new PDO ( 'mysql:dbname=koenji; host=localhost;port=3306; charset=utf8', 'root', 'Zaq12wsx!' );
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

=======
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
>>>>>>> 7b544f1c3c1b3c7d2fd50afa17b7e367f947e0e9

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
<<<<<<< HEAD
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
=======
            $pdo = new PDO ( 'mysql:dbname=koenji; host=localhost;port=3306; charset=utf8', 'root', 'Zaq12wsx!' );  
            $cmd = 'INSERT INTO koenji.' .$_SESSION['table'] .' (p_title,p_text,p_url) 
                VALUES ("' .$title .'","' .$text .'","' .$link .'");';
>>>>>>> 7b544f1c3c1b3c7d2fd50afa17b7e367f947e0e9
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

<<<<<<< HEAD
// 削除ボタンが押された場合の処理
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
        return;
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
    return $page_flag;
    return $Message;
}

=======
//編集処理
//編集ボタン押下時確認処理
if (isset($_POST["btn_edit"])) {
    $page_flag_change = 2;
    $name = $_POST['c_name'];
    $text = $_POST['c_text'];
    $link = $_POST['c_link'];
    $_SESSION['state'] = 'change';
    $page_flag_change = 2;
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
    } else if (empty($_POST["userdef"])) {
        $Message = 'ユーザーが指定されていません。';
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
        //入力値DB登録処理
        try {
            $pdo = new PDO ( 'mysql:dbname=koenji; host=localhost;port=3306; charset=utf8', 'root', 'Zaq12wsx!' );  
            $cmd = 'UPDATE koenji.'.$_SESSION['table'].' SET 
            p_title = '.$title.', p_text = '.$text.', p_url = '.$link.' where p_number = '.$_POST['btn_edit'].';';
            $pdo->query($cmd);
            $Message = '登録が完了しました。';
            $_SESSION['state'] = 'add';
            header("Location: master.php");
        } catch (PDOException $e) {
            $Message = 'データベースエラー';
            $_SESSION['state'] = 'add';
            header("Location: master.php");
        }
    }
}
>>>>>>> 7b544f1c3c1b3c7d2fd50afa17b7e367f947e0e9
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
<<<<<<< HEAD
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
                    <p><?php echo $_POST["text"];?> <br/></p>
                </div>
                <div class="form">
                    <h3>Link : <br /></h3>
                    <p><?php echo $_POST["link"];?> <br/></p>
                </div>

                <input type="submit" name="btn_back" value="戻る">
                <input type="submit" name="btn_submit" value="送信">
                <input type="hidden" name="name" value="<?php echo $_POST["name"]; ?>">
                <input type="hidden" name="text" value="<?php echo $_POST["text"]; ?>">
                <input type="hidden" name="link" value="<?php echo $_POST["link"]; ?>">
            </form>


    <!--追加内容送信後ページ、page_flag = 2-->
        <?php elseif ( $page_flag === 2 ): ?>
            <div class="tabs">
            <input id="add" type="radio" name="tab_item" checked>
            <label class="tab_item" for="add">新規追加</label>
            <input id="change" type="radio" name="tab_item" >
            <label class="tab_item" for="change">内容変更</label>
            <div class="tab_content" id="add_content">
                <div class="tab_content_description">
                <div><font color="#ff0000"><?php echo htmlspecialchars($Message, $ENT_QUOTES) ;?></font></div>
=======
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
>>>>>>> 7b544f1c3c1b3c7d2fd50afa17b7e367f947e0e9
                    <div class="form">
                    <!--ここに、アクションのタイプ記入-->
                        <form action="" method="POST">                            
                            <div class="name">
                                <h3><br />Product Name : </h3>
                                <p>プロダクトのタイトルを入力してください。<br />  
<<<<<<< HEAD
                                        <textarea name="name" rows="1" cols="55" ></textarea><br /><br />
=======
                                    <textarea name="name" rows="1" cols="55" ></textarea><br /><br />
>>>>>>> 7b544f1c3c1b3c7d2fd50afa17b7e367f947e0e9
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
<<<<<<< HEAD
                                <p>  <input type="submit" name="confirm" value="内容を確認する"></p>
=======
                                <p><input type="submit" name="confirm" value="内容を確認する"></p>
>>>>>>> 7b544f1c3c1b3c7d2fd50afa17b7e367f947e0e9
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
                    <div><font color="#ff0000"><?php echo htmlspecialchars($Message2, ENT_QUOTES); ?></font></div>
                    <div class="flex">
                        <?php
                            foreach($product as $p) {
                                print '<div class="col">';
<<<<<<< HEAD
                                print '<h5 class="his-content">' .$p[0] .'<br>';
                                print '<p class="content-text">' .$p[1] .'</p>';
                                print '<a href="' .$p[2] .'" class="his-link">link</a>';
                                print '<p hidden class="p_number">'.$p[3] .'</p>';
                                print '<div class="form">';
                                print '<form action="" method="POST">';
                                print '<input type="submit" name="btn_edit" value="編集">';
                                print '<input type="submit" name="btn_delete" value="削除">';
                                print '</form>';
=======
                                print '<form action="#" method="POST">';
                                print '<h5 class="his-content" name="c_name">' .$p[0] .'<br>';
                                print '<p class="content-text" name="c_text">' .$p[1] .'</p>';
                                print '<a name="c_link" value="' .$p[2] .'" href="' .$p[2] .'" class="his-link">link</a>';
                                print '<div class="btn">';
                                print '<button type="submit" class="btn" name="btn_edit" value="' .$p[3] .'">編集</button>';
                                print '<button type="submit" class="btn" name="btn_delete" value="' .$p[3] .'">削除</button>';
>>>>>>> 7b544f1c3c1b3c7d2fd50afa17b7e367f947e0e9
                                print '</div>';
                                print '</h5>';
                                print '</form>';
                                print '</div>';
                                if (isset($_POST["btn_delete"])) {
                                    del_btn($p[3]);
                                }
                            }
                            //unset($p);
                        ?>
                    </div>
<<<<<<< HEAD
                </div>
            </div>
            <script type="text/javascript" src="../onmouse-1.js" charset="utf-8"></script>
        </div>

    <!--初期状態ページ、page_flag = 1-->
        <?php else: ?>　
            <div class="tabs">
            <input id="add" type="radio" name="tab_item" checked>
            <label class="tab_item" for="add">新規追加</label>
            <input id="change" type="radio" name="tab_item" >
            <label class="tab_item" for="change">内容変更</label>

            <div class="tab_content" id="add_content">
                <div class="tab_content_description">
=======
                <!--編集内容入力画面-->
                <?php elseif ( $page_flag_change === 2 ): ?>
>>>>>>> 7b544f1c3c1b3c7d2fd50afa17b7e367f947e0e9
                    <div class="form">
                        <!--ここに、アクションのタイプ記入-->
                        <form action="" method="POST">                            
                            <div class="name">
                                <h3><br />Product Name : </h3>
                                <p>プロダクトのタイトルを入力してください。<br />  
                                    <textarea name="name" rows="1" cols="55">
                                        <?php echo $name; ?>
                                    </textarea><br /><br />
                                </p>
                            </div>
                            <div class="text">
                                <h3>Description : </h3>
                                <p>プロダクトの説明文を入力してください。<br />
                                    <textarea name="text" rows="6" cols="55">
                                        <?php echo $text; ?>
                                    </textarea><br /><br />
                                </p>
                            </div>
                            <div class="link">
                                <h3>Link : </h3>
                                <p>プロダクトのURLを入力してください。 <br />
                                    <textarea name="link" rows="1" cols="55">
                                        <?php echo $link; ?>
                                    </textarea><br /><br />
                                </p>
                            </div>
                            <div class="submit">
                                <p><input type="submit" name="confirm_edit" value="内容を確認する"></p>
                            </div>  
                        </form>    
                    </div>
<<<<<<< HEAD
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
                                print '<p hidden class="p_number">'.$p[3] .' </p>';
                                print '<div class="form">';
                                print '<form method="POST">';
                                print '<input type="submit" name="btn_edit" value="編集">';
                                print '<input type="submit" name="btn_delete" value="削除">';
                                print '</form>';
                                print '</div>';
                                print '</h5>';
                                print '</div>';
                                if (isset($_POST["btn_delete"])) {
                                    del_btn($p[3]);

                                }
                            }
                            //unset($p);
                        ?>

                    </div>
                </div>
=======

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
                    </form>
                <?php endif; ?>
>>>>>>> 7b544f1c3c1b3c7d2fd50afa17b7e367f947e0e9
            </div>
        </div>
    </div>
</body>
</html>