<?php
   
   if (isset($_POST["submit"]))
   {
      include("./connect_db.php");
      include("./functions.php");

      $firstname = sanitize($_POST["firstname"]);
      $infix = sanitize($_POST["infix"]);
      $lastname = sanitize($_POST["lastname"]);
      $email = sanitize($_POST["email"]);
      
      $sql = "INSERT INTO `users` (`id`,
                                   `firstname`,
                                   `infix`,
                                   `lastname`,
                                   `email`)
              VALUES             (NULL,
                                  '".$firstname."',
                                  '".$infix."',
                                  '".$lastname."',
                                  '".$email."')";
      
      echo $sql; exit();


   }
?>


<h3>Registratie</h3>

<form action="./index.php?content=register_form" method="post">
   <table>
      <tr>
         <td>voornaam:</td>
         <td><input type="text" name="firstname" placeholder="voornaam"></td>
      </tr>
      <tr>
         <td>tussenvoegsel:</td>
         <td><input type="text" name="infix" placeholder="tussenvoegsel"></td>
      </tr>
      <tr>
         <td>achternaam:</td>
         <td><input type="text" name="lastname" placeholder="achternaam"></td>
      </tr>
      <tr>
         <td>e-mail:</td>
         <td><input type="email" name="email" placeholder="e-mailadres"></td>
      </tr>
      <tr>
         <td></td>
         <td><input type="submit" name="submit" value="registreer!"></td>
      </tr>
   </table>
</form>