<?php
   if (isset($_GET["email"]))
   {
      $email = $_GET["email"];
   }
   else
   {
      $email = "";
   }

   if (isset($_POST["submit"]))
   {
      //echo "Er is op de submitknop gedrukt";
      //var_dump($_POST);
      // Eerst contact maken met de mysql-server
      include("./connect_db.php");

      // select query opbouwen
      $sql = "SELECT * FROM `users` 
              WHERE `email` = '".$_POST["email"]."'
              AND   `password`    = '".sha1($_POST["password"])."'";

      //echo $sql;exit();
      
      // Stuur de query naar de database...
      $result = mysqli_query($conn, $sql);
      
      
      // Tel hoeveel records er zijn gevonden
      if ( mysqli_num_rows($result) > 0 )
      {

         // Maak van de resource $result een array (associatief)
         $record = mysqli_fetch_array($result, MYSQLI_ASSOC);
         //var_dump($record);

         $_SESSION["id"] = $record["id"];
         $_SESSION["userrole"] = $record["userrole"];

         switch($record["userrole"])
         {
             case "customer":
                // stuur door naar customer_home.php
                header("location: index.php?content=customer_home");
                break;
             case "root":
                // stuur door naar de root_home.php 
                header("location: index.php?content=root_home");             
                break;
             case "admin":
                // stuur door naar de admin_home.php
                header("location: index.php?content=admin_home");                
                break;  
             default:
                // stuur door naar de generale homepage home.php
                header("location: index.php?content=home");                
                break;
         }         
      }
      else
      {
          echo "De door u gebruikte combinatie van gebruikersnaam en wachtwoord is niet bekend in de database";
          header("Refresh: 4; url=index.php?content=login_form");
      }
   }
   else
   {
?>


<h3>Voer uw gebruikersnaam (emailadres) en wachtwoord in:</h3>
<form action="./index.php?content=login_form" method="post">
   <table>
      <tr>
         <td>emailadres: </td>
          <td><input type="email" name="email" required value="<?php echo $email; ?>"></td>
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

<?php
   }
?>