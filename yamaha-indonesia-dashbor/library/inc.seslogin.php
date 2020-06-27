<?php
if (empty($_SESSION['SES_LOGIN'])) {
	echo "<meta http-equiv='refresh' content=".$baseURL."'>";
	exit;
}
?>