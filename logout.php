<?php
   session_unset();
   session_destroy();
   echo "U bent succesvol uitgelogd";
   header("refresh: 4; url=index.php?content=login_form");
?>