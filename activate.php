<?php
   // Maak een verbinding met de mysql-server
   include("./connect_db.php");

   if ( isset($_POST["submit"]))
   {
      var_dump($_POST);

      if (!strcmp($_POST["password"], $_POST["controle_password"]))
      {
         $sql = "UPDATE `users` 
                 SET    `password` = '".sha1($_POST["password"])."'
                 WHERE  `id` = ".$_POST["id"];

         mysqli_query($conn, $sql);
         header("location: index.php?content=home");
      }
      else
      {
         echo "De door U ingevoerde wachtwoorden komen niet overeen. Probeer het nogmaals";
         header("refresh: 3; url=./index.php?content=activate&id=".$_POST["id"]."&pw=".$_POST["pw"]);
      }


   }
   else
   {
   
   /* Maak de select-query die het mogelijk maakt om het record met 
    * het meegestuurde $_GET["id"] op te vragen */
   $sql = "SELECT * FROM `users` WHERE `id` = ".$_GET["id"];

   // Vuur de query af op de database
   $result = mysqli_query($conn, $sql);

   $record = mysqli_fetch_array($result, MYSQLI_ASSOC);

   var_dump($record);

   if ( !strcmp($record["password"], $_GET["pw"]))
   {
      echo "De password strings zijn gelijk";

      // Maak een form met twee input tags van het type password en stop die in variabele $form;
      $form = "";

      $form .= "<form action='./index.php?content=activate' method='post'>
                     <table>
                        <tr>
                           <td>nieuw wachtwoord</td>
                           <td>
                              <input type='password' name='password'>
                           </td>
                        </tr>
                        <tr>
                           <td>nogmaals wachtwoord</td>
                           <td>
                              <input type='password' name='controle_password'>
                           </td>
                        </tr>
                        <tr>
                           <td></td>
                           <td>
                              <input type='submit' name='submit'>
                           </td>
                        </tr>
                      </table> 
                      <input type='hidden' value='".$_GET["id"]."' name='id'>    
                      <input type='hidden' value='".$_GET["pw"]."' name='pw'>     
               </form>";

   }
   else
   {
      echo "De password strings zijn niet gelijk";
   }







?>

<h2>Kies een nieuw wachtwoord</h2>
<?php
   echo $form;

   }
?>