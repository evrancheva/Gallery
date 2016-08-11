<?php
setcookie("LoggedPerson", "", time()-3600);
setcookie("UserLoggedPerson", "", time()-3600);
header("Location: loginPictures.php");

?>