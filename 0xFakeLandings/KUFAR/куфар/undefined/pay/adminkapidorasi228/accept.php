<?php
include '../system/main.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['id'])) {
    die();
}

$query = "UPDATE invoices SET status = 2 WHERE id  = '". (int)$_POST['id'] ."'";
$connection->query($query);

header('Location: adminpidoras228.php');

?>