<?php
include '../system/main.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    die();
}
$id = (int)$_POST['id'];
$query = mysqli_query($connection , "SELECT `status`, `reason` FROM `invoices` WHERE `id` = '$id'");
if(!$query)
{
    printf("Error: %s\n", mysqli_error($connection));
} else {
    $row = mysqli_fetch_array($query, MYSQLI_BOTH);
    if($row[0] != 3) {
        echo $row[0];
    } else {
        echo $row[0].'|'.$row[1];
    }
}