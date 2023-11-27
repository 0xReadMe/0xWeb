<?php 
if(isset($_SESSION['noti'])) {
  if($_SESSION['noti_status'] == "success") {
    echo "<script>setTimeout(function(){ noti('success', '".$_SESSION['noti']."') }, 1000);</script>";
    unset($_SESSION['noti']);
    unset($_SESSION['noti_status']);
  } else if($_SESSION['noti_status'] == "error") {
    echo "<script>setTimeout(function(){ noti('error', '".$_SESSION['noti']."') }, 1000);</script>";
    unset($_SESSION['noti']);
    unset($_SESSION['noti_status']);
  }
}
?>
<div class="inputs">
  <div class="inputs_info inputs_green alert-success" style="display:none;">
    <div class="close"></div>
    <em></em>
  </div>
  <div class="inputs_info inputs_red alert-error" style="display: none;">
    <div class="close"></div>
    <em></em>
  </div>
</div>