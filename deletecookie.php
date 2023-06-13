<?php
setcookie("name", $username, time()-3600,'/');

header('Location: http://3-is1/freelance/autorization.php');