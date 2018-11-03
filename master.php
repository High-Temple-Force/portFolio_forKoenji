<?php
session_start();
// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: logout.php");
    exit;
}
?>

<!doctype html>
<html>
    <h1>作成中</h1>
        <ul>
            <li><a href="logout.php">ログアウト</a></li>
        </ul>
    </body>
</html>