<?php
    if ( isset($_GET["content"]))
    {
        $page = $_GET["content"].".php";
    }
    else
    {
        $page = "home.php";
    }
    include($page);
?>
