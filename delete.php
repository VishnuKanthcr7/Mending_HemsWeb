<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location:login.php');
}
require_once("utils/Db.php");
$db = Db::getInstance();
// if got delete
if (isset($_GET['delete'])) {
    $db->query("DELETE FROM cart WHERE user_id = '{$_SESSION['uid']}' AND id = {$_GET['delete']}");
    $callback = $_GET['callback'] ?? 'index.php';
    header("Location:$callback");
    return true;
}
header('Location:index.php');
