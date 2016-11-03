<?php
   // Maak op deze pagina een tabel waarin wordt weergegeven:
   // voornaam, tussenvoegsel, achternaam, gebruikersrol, potlood
   // Zorg dat voor ieder record de gebruikersrol kan worden gewijzigd. 
   // De administrator is de enige die op deze pagina kan komen. Regel de beveiliging

   // Beveiliging van deze pagina alleen toegankelijk voor de administrator
   $userrole = array("admin", "customer", "root");
   include("security.php");

   // Contact maken met de mysql-server 
   include("connect_db.php"); 

   if ( isset($_POST["submit"]))
   {
      $sql = "SELECT * FROM `users` WHERE `id` = ".$_POST["id"];

      $result = mysqli_query($conn, $sql);

      $record = mysqli_fetch_array($result, MYSQLI_ASSOC);

      if ( $_SESSION["userrole"] == 'admin')
      {
         $old_password = $record["password"];
      }
      else
      {
         $old_password = sha1($_POST["old_password"]);
      }

      if ( strcmp($record["password"], $old_password) == 0)
      {
         $sql = "UPDATE `users` 
                 SET `password` = '".sha1($_POST["password"])."'
                 WHERE `id` = ".$_POST["id"];

         $result = mysqli_query($conn, $sql);
 
         if ($result)
         {
            echo "Uw password is succesvol gewijzigd";
            header("Refresh: 3; url=index.php?content=login_form");
         }
         else
         {
            echo "Er is iets mis gegaan. Probeer opnieuw";
            header("Refresh: 3; url=index.php?content=change_password");
         }
      }
      else
      {
         echo "Uw oude password klopt niet. Probeer het opnieuw";
         header("Refresh: 4; url=index.php?content=change_password&id=".$_POST["id"]);
      }

   }

   if ( isset($_GET["id"]))
   {
      // Selecteer het record op basis van een id 
      $sql = "SELECT * FROM `users` WHERE `id` = ".$_GET["id"];

      // Vuur de query af op de database
      $result = mysqli_query($conn, $sql);

      $record = mysqli_fetch_array($result, MYSQLI_ASSOC);

      var_dump($record);
      $formtekst = "";
      $formtekst .=  "<form action='index.php?content=change_password' method='post'>
                        <table>
                           <tr>
                              <td>oude wachtwoord: </td>
                              <td><input type='password' name='old_password' ";
                           
                               if ($_SESSION['userrole'] == 'admin') 
                               { 
                                  $formtekst .= "placeholder='Als admin niet invullen' ";
                                  $formtekst .= "readonly";

                               } 
                           
      $formtekst .= "></td>
                  </tr>
                  <tr>
                     <td>wachtwoord: </td>
                     <td><input type='password' name='password'></td>
                  </tr>
                  <tr>
                     <td>type nogmaals wachtwoord: </td>
                     <td><input type='password' name='controle_password'> </td>
                  </tr>
                  <tr>
                     <td></td>
                     <td><input type='submit' name='submit' value='wijzig wachtwoord!'></td>
                  </tr>
               </table>
               <input type='hidden' name='id' value='".$_GET["id"]."'>
           </form>";

      echo $formtekst;

      exit();
   }

   // een sql-query die alle users selecteerd
   // Code...
   $sql = "SELECT * FROM `users`";
   if ( !($_SESSION["userrole"] == 'admin'))
   {
      $sql .= " WHERE `id` = ".$_SESSION["id"];
   }

   // Vuur de query af op de database
   // code...
   $result = mysqli_query($conn, $sql);

   $innerTable = "";
   while ( $record = mysqli_fetch_array($result, MYSQLI_ASSOC))
   {
      $innerTable .= "<tr>
                        <td>".$record["id"]."</td>
                        <td>".$record["firstname"]."</td>
                        <td>".$record["infix"]."</td>
                        <td>".$record["lastname"]."</td>
                        <td><a href='index.php?content=change_password&id=".$record["id"]."'><img src='./images/b_edit.png' alt='potlood'></a></td>";
   }
?>



<table>
   <tr>
      <th>id</th>
      <th>Voornaam</th>
      <th>tussenvoegsel</th>
      <th>Achternaam</th>
      <th></th>
   </tr>
   <?php echo $innerTable; ?>
</table>

