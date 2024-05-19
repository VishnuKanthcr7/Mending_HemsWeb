<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location:/mending-hems/index.php');
}
if (!isset($_GET['pid'])) {
    header('Location:/mending-hems/index.php');
}
require_once("utils/Db.php");
$db = Db::getInstance();
$pid = $_GET['pid'];
$product = $db->query("DELETE FROM products WHERE id=$pid AND publisher={$_SESSION['uid']}");
header('Location:tailor-dashboard.php');
