<?php
    $product_aoki = Array();
    $product_mori = Array();
    $product_yokoi = Array();
    try{
        $pdo = new PDO ( 'mysql:dbname=koenji; host=localhost;port=3306; charset=utf8', 'root', 'Zaq12wsx!' );
        $cmd = 'SELECT p_title,p_text,p_url from t_a_product;';
        foreach($pdo->query($cmd) as $row){
            $product_aoki[] = $row;
        }
        $cmd = 'SELECT p_title,p_text,p_url from t_m_product;';
        foreach($pdo->query($cmd) as $row){
            $product_mori[] = $row;
        }
        $cmd = 'SELECT p_title,p_text,p_url from t_y_product;';
        foreach($pdo->query($cmd) as $row){
            $product_yokoi[] = $row;
        }
    }catch (PDOException $e) {
        $Message = 'データベースエラー';
    }
?>
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
        <h1>Koenjineer Portfolio</h1>
        <ul>
            <li><a class="active" href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="login/login.php">Login</a></li>
        </ul>
    </header>

    <div class="tabs">

        <input id="takuto" type="radio" name="tab_item" checked>
        <label class="tab_item" for="takuto">Takuto</label>
        <input id="hayato" type="radio" name="tab_item" >
        <label class="tab_item" for="hayato">Hayato</label>
        <input id="daiki" type="radio" name="tab_item" >
        <label class="tab_item" for="daiki">Daiki</label>

            <div class="tab_content" id="takuto_content">
                <div class="tab_content_description">
                    <div class="flex">
                        <?php
                            foreach($product_aoki as $p){
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


            <div class="tab_content" id="hayato_content">
                <div class="tab_content_description">
                    <div class="flex">
                        <?php
                            foreach($product_mori as $p){
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

            <div class="tab_content" id="daiki_content">
                <div class="tab_content_description">
                    <div class="flex">
                        <?php
                            foreach($product_yokoi as $p){
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
            <script type="text/javascript" src="./onmouse-1.js" charset="utf-8"></script>
    </div>
</body>

</html>