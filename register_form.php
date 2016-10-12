<?php
   // Check of er op de submit knop is gedrukt, zo ja dan...   
   if (isset($_POST["submit"]))
   {
      // Maak contact met de mysql-server en database 
      include("./connect_db.php");

      // Maak de functie sanitize() beschikbaar op deze pagina
      include("./functions.php");

      // Stel de juiste tijdzone in voor het bepalen van de tijd
      date_default_timezone_set("Europe/Amsterdam");

      // Maak een random tijdelijk password en haal dit door een sha1 hash
      $first3OfFirstname = substr(sanitize($_POST["firstname"]), 0, 3);
      $last4OfLastname = substr(sanitize($_POST["lastname"]), (strlen(sanitize($_POST["lastname"])) - 4), 4);
      $date = date("d-m-Y H:i:s");
      $tempPassword = $date." ".$first3OfFirstname." ".$last4OfLastname;
      $tempPassword = sha1($tempPassword);


      // Maak de waarden van het $_POST() array schoon
      $firstname = sanitize($_POST["firstname"]);
      $infix = sanitize($_POST["infix"]);
      $lastname = sanitize($_POST["lastname"]);
      $email = sanitize($_POST["email"]);
      
      // Maak de insert query..
      $sql = "INSERT INTO `users` (`id`,
                                   `firstname`,
                                   `infix`,
                                   `lastname`,
                                   `email`,
                                   `password`,
                                   `activate`)
              VALUES             (NULL,
                                  '".$firstname."',
                                  '".$infix."',
                                  '".$lastname."',
                                  '".$email."',
                                  '".$tempPassword."',
                                  'false')";
      
      // Vuur de query af op de database via de verbinding $conn
      $result = mysqli_query($conn, $sql);
      $last_id = mysqli_insert_id($conn);

      
      // Als de query correct is ontvangen en uitgevoerd.
      if ($result)
      {
         $emailaddress = $_POST["email"];
         $subject = "Activatie account";
         $message = "Bedankt voor het registreren, klik op deze link ".
                    "http://localhost/2016-2017/am1a/inlogregistratiesysteem/index.php?content=activate&id=".
                    $last_id."&pw=".$tempPassword." om uw account te activeren";
         mail($emailaddress, $subject, $message);
         // Geef een succes melding en stuur door naar de homepage..
         echo "Uw bent geregistreerd";
         header("refresh:3; url=./index.php?content=home");
      }
      else
      {
         /* Wanneer de query niet goed is ontvangen of uitgevoerd, meldt dit 
          * dan en stuur door naar het registratieformulier */
         echo "Registreer opnieuw, er is iets misgegaan";
         header("refresh:3; url=./index.php?content=register_form");
      }
   }
   // Wanneer er nog op de submitknop is gedrukt dan wordt het registratieformulier getoond
   else
   {
?>
<h3>Registratie</h3>

<form action="./index.php?content=register_form" method="post">
   <table>
      <tr>
         <td>voornaam:</td>
         <td><input type="text" name="firstname" placeholder="voornaam" required></td>
      </tr>
      <tr>
         <td>tussenvoegsel:</td>
         <td><input type="text" name="infix" placeholder="tussenvoegsel"></td>
      </tr>
      <tr>
         <td>achternaam:</td>
         <td><input type="text" name="lastname" placeholder="achternaam" required></td>
      </tr>
      <tr>
         <td>e-mail:</td>
         <td><input type="email" name="email" placeholder="e-mailadres" required></td>
      </tr>
      <tr>
         <td></td>
         <td><input type="submit" name="submit" value="registreer!"></td>
      </tr>
   </table>
</form>

<?php
   // Sluit het else haakje af...
   }
?>