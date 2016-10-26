<?php
   // Maak een verbinding met de mysql-server
   include("./connect_db.php");

   // Controleer of er op de submit-knop is gedrukt..
   if ( isset($_POST["submit"]))
   {
      // Controleer met strcmp() of de ingvoerde wachtwoorden gelijk zijn...
      if (!strcmp($_POST["password"], $_POST["controle_password"]))
      {
         // De wachtwoorden zijn gelijk dus kunnen we de uodate query voor het nieuwe wachtwoord maken
         $sql = "UPDATE `users` 
                 SET    `password` = '".sha1($_POST["password"])."',
                        `activate` = 'true'
                 WHERE  `id` = ".$_POST["id"];

         // Vuur de query af op de database
         mysqli_query($conn, $sql);

         // Stuur de gebruiker door naar de homepage
         header("location: index.php?content=login_form&email=".$_POST["email"]);
      }
      else
      {
         // De wachtwoorden zijn niet hetzelfde... We vragen de gebruiker nogmaals de wachtwoorden in te voeren
         echo "De door U ingevoerde wachtwoorden komen niet overeen. Probeer het nogmaals";
         
         // We sturen de gebruiker door naar een aantal seconden naar de activate-pagina
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

      // Zet de resource om naar een associatief array//
      $record = mysqli_fetch_array($result, MYSQLI_ASSOC);

      //echo $record["activate"];

      if ( $record["activate"] == "false")
      {
            // Check of het wachtwoord in de database gelijk is aan het wachtwoord dat is meegegeven in de URL
            if ( !strcmp($record["password"], $_GET["pw"]))
            {
            // Maak een lege variabele $form;
            $form = "";

            // Stop in deze string variabele een formulier met...
            // 2 input tags van type password 
            // 2 input tags van type hidden (id en pw)
            // 1 input tag type submit
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
                              <input type='hidden' value='".$record["email"]."' name='email'>     
                        </form>";
            }
            else
            {                  
                  echo "U heeft geen rechten op deze pagina. U wordt doorgestuurd naar de homepage";
                  header("refresh: 4; url=index.php?content=home");
                  exit();
            }
?>

<h2>Kies een nieuw wachtwoord</h2>
<?php
      echo $form;
      }
      else
      {
            echo "Uw account is al geactiveerd. U kunt nu inloggen";
            header("refresh: 2; url=index.php?content=login_form&");
      }
}
?>