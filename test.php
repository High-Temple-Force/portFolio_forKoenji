<?php
$pdo = new PDO ( 'mysql:dbname=koenji; host=localhost;port=3306; charset=utf8', 'root', 'Zaq12wsx!' );
    
//表示フラグ（disp）が１のデータのqidを取得。
$cmd = 'SELECT * FROM t_master;';
foreach($pdo->query($cmd) as $row){
    $id = $row['id'];
    $password = $row['password'];
}
print $id;
print $password;
?>