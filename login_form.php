<?php
   if (isset($_GET["email"]))
   {
      $email = $_GET["email"];
   }
   else
   {
      $email = "";
   }

?>


<h3>Voer uw gebruikersnaam (emailadres) en wachtwoord in:</h3>
<form>
   <table>
      <tr>
         <td>emailadres: </td>
          <td><input type="text" name="email" required value="<?php echo $email; ?>"></td>
      </tr>
      <tr>
         <td>wachtwoord</td>
          <td><input type="password" name="password" required></td>
      </tr>
      <tr>
         <td></td>
          <td><input type="submit" name="submit" value="Log in!"></td>
      </tr>
   </table>
</form>