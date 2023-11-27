<?php 
function noti($status, $message) {
  $_SESSION['noti_status'] = $status; 
  $_SESSION['noti'] = $message; 
}
?>