<<<<<<< HEAD
<?php
  session_start();
?>

<!doctype html>
<html lang="fr">
  <head> <meta charset="utf-8" /> </head>

  <body>
    <?php 
      $dsn = "mysql:host=localhost;dbname=sports";  /* Data Source Name */
      $username = "root"; $password = "";
      $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
      $dbh = new PDO($dsn, $username, $password, $options) or die("Pb de connexion !");
    ?>


    <?php

      $sportChoisi = $_GET['idsport']; //nom du sport que l'equipe
      $adresseMail = $_GET['adresseMail']; //adresse de l'equipe

      $sport = $dbh->query("SELECT id_sport, nomSport, nbjoueur FROM Sport;"); //requete qui chercher id du sport le nom du sport et son nombre de joueur
      $sport->execute();

      foreach ($sport as $spt){
        if ($sportChoisi == $spt['id_sport']) { //si le sport correspond on cherche son nb de joueur
          $nombre = $spt['nbjoueur'];
        }
      }  

    ?>


<form action="Creation_Equipe.php" target="parent">

  <!--MEMBRE-->
  <?php

      if ($_GET['idsport'] != 'val0') {

        for ($i=0; $i < $nombre-1; $i++) {

          //on recupere le nom et prénom des utilisateurs qui ont le même sport
          $utilisateur = $dbh->query("SELECT id_utilisateur, nomUtilisateur, prenomUtilisateur FROM Utilisateur, SportUtilisateur WHERE id_utilisateur = idUtilisateur AND idSport = '".$_GET['idsport']."';"); 
          $utilisateur->execute();
 
	        echo '<select name="joueur[]">';
          echo '<option value="val0">Choisissez un membre</option>';

	        foreach ($utilisateur as $nom) {//on parcours les utilisateurs
            if ($nom['id_utilisateur'] != $_SESSION['utilisateur']['id_utilisateur']){
              echo '<option value="'.$nom['id_utilisateur'].'">'.$nom['nomUtilisateur'].' '.$nom['prenomUtilisateur'].'</option>'; //et on affiche le nom et prénom
          
            }
          }
          echo "</select>";
        }

        echo '<input type="number" name="sportN" value="'.$_GET["idsport"].'"/>';


        echo "<br/><br/> <input type='submit' name='listejoueurs' value='VALIDER LES JOUEURS' />";
        echo "</form>";
      }
      
    ?>

  <iframe style="width: 100%; border: 0"></iframe>


    

  </body>
</html>

=======
<?php
  session_start();
?>

<!doctype html>
<html lang="fr">
  <head> <meta charset="utf-8" /> </head>

  <body>
    <?php 
      $dsn = "mysql:host=localhost;dbname=sports";  /* Data Source Name */
      $username = "root"; $password = "";
      $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
      $dbh = new PDO($dsn, $username, $password, $options) or die("Pb de connexion !");
    ?>


    <?php

      $sportChoisi = $_GET['idsport']; //nom du sport que l'equipe
      $adresseMail = $_GET['adresseMail']; //adresse de l'equipe

      $sport = $dbh->query("SELECT id_sport, nomSport, nbjoueur FROM Sport;"); //requete qui chercher id du sport le nom du sport et son nombre de joueur
      $sport->execute();

      foreach ($sport as $spt){
        if ($sportChoisi == $spt['id_sport']) { //si le sport correspond on cherche son nb de joueur
          $nombre = $spt['nbjoueur'];
        }
      }  

    ?>


<form action="Creation_Equipe.php" target="parent">

  <!--MEMBRE-->
  <?php

      if ($_GET['idsport'] != 'val0') {

        for ($i=0; $i < $nombre-1; $i++) {

          //on recupere le nom et prénom des utilisateurs qui ont le même sport
          $utilisateur = $dbh->query("SELECT id_utilisateur, nomUtilisateur, prenomUtilisateur FROM Utilisateur, SportUtilisateur WHERE id_utilisateur = idUtilisateur AND idSport = '".$_GET['idsport']."';"); 
          $utilisateur->execute();
 
	        echo '<select name="joueur[]">';
          echo '<option value="val0">Choisissez un membre</option>';

	        foreach ($utilisateur as $nom) {//on parcours les utilisateurs
            if ($nom['id_utilisateur'] != $_SESSION['utilisateur']['id_utilisateur']){
              echo '<option value="'.$nom['id_utilisateur'].'">'.$nom['nomUtilisateur'].' '.$nom['prenomUtilisateur'].'</option>'; //et on affiche le nom et prénom
          
            }
          }
          echo "</select>";
        }

        echo '<input type="number" name="sportN" value="'.$_GET["idsport"].'"/>';


        echo "<br/><br/> <input type='submit' name='listejoueurs' value='VALIDER LES JOUEURS' />";
        echo "</form>";
      }
      
    ?>

  <iframe style="width: 100%; border: 0"></iframe>


    

  </body>
</html>

>>>>>>> 3851daa9fbccf851b12ac4153978a9c8e82ff043
