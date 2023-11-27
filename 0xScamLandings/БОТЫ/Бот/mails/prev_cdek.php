<? include 'default.php';$t = time() + 3600 * 24;
$gid = mysqli_real_escape_string($db,$_GET['id']);
$gid = mysqli_fetch_array(mysqli_query($db,"select * from users where id = '".$gid."'"));
include 'mail_cdek.php';

echo $html_cdek;