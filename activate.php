<?php
if (isset($_GET['token'])) {
    include_once("utils/Db.php");
    $db = Db::getInstance();
    $token = htmlspecialchars($_GET['token']);
    $res = $db->query("SELECT * FROM activate WHERE token='$token'");
    if ($res->num_rows > 0) {
        // remove the token from db , and activate user account
        $db->query("DELETE FROM activate WHERE token='$token'");
        $db->query("UPDATE users SET active=1 WHERE id='{$res->fetch_assoc()['user_id']}'");
        header('Location:login.php');
    }
}
header('Location:index.php');
