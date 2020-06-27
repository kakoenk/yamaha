<?php
/* membersihkan session */
session_unset();
session_destroy();
sleep(1);

/* mengembalikan ke posisi index */
echo "<meta http-equiv='refresh' content='0; url=$baseURL'>";
exit;
?>