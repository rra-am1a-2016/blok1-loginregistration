<?php
   if (!isset($_SESSION["userrole"]))
   {
      // Stuur na 4 sec door naar home.php
      echo "U heeft niet de rechten om deze pagina te bekijken.";
      header("refresh:4;url=index.php?content=home");
      exit();
   }
   else if ( !(in_array($_SESSION["userrole"], $userrole)))
   {
      echo "U heeft niet de juiste gebruikersrol om deze pagina te bekijken.";
      header("refresh:4;url=index.php?content=home");
      exit();
   }
   echo "Uw gebruikersrol is: ".$_SESSION["userrole"];
?>