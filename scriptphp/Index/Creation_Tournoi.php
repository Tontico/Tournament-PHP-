<<<<<<< HEAD
<?php
  session_start();
  $isLoggedIn = isset($_SESSION['utilisateur']);
?>

<!doctype html>
<html lang="fr">
  <head> <meta charset="utf-8" />
   <title> Création d'un Tournoi </title>
  </head>

  <body>
    <h1><FONT face="Times New Roman"><pre>                                           Création du Tournoi </FONT></pre></h1>
      <?php 
       ini_set('display_errors', 1); error_reporting(E_ALL);
       try {
          $dsn = 'mysql:host=localhost;dbname=sports;charset=UTF8';
          $login = 'root';  // à délocaliser dans un fichier
          $password = '';  // à délocaliser dans un fichier 
          $dbh = new PDO($dsn, $login, $password);
        } 
        catch (PDOException $e) {
          print "Impossible d'ouvrir la base de données : " . $e->getMessage() . "<br/>";
          die("On arrête tout !");
        }
      ?>

      <fieldset>
        <form>
          <pre>
          
            <!-----------TOURNOI------------->

            <legend><FONT face="Times New Roman"><strong>            LE TOURNOI</FONT></strong></legend>

            <!--NOM-->
            <strong><FONT face="Times New Roman">Nom du tournoi</FONT></strong><br/>              
            <input type="text" name="nomTournoi" placeholder="Mon Tournoi" required/>

            <!--TYPE-->
            <strong><FONT face="Times New Roman">Type du tournoi</FONT></strong><br/>
            <select name="typeTournoi">
              <option value="coupe">Coupe</option>
              <option value="championnat">Championnat</option>
              <option value="tournoisATour">Tournoi a tour</option>
            </select>

            <!--NOMBRE EQUIPE-->
            <strong><FONT face="Times New Roman">Nombre d'equipe</FONT></strong><br/>
            <input type="number" name="nbEquipe" placeholder="2 minimum" min ="2" required>



            <!-----------ORGANISATION------------->
            <legend><FONT face="Times New Roman"><strong>            L'ORGANISATION</FONT></strong></legend><br/>

            <!--LIEU-->
            <strong><FONT face="Times New Roman">Lieu (Ville, Nom du Stade / Terrain ...)</FONT></strong><br/>
            <input type="text" id="l" name="lieu" placeholder="Localisation" required onchange="window.frames[0].location='lieu.php?lieu='+getElementById('l').value"> 

            <!--affichage de la carte-->
            <iframe onchange="window.frames[0].location='lieu.php?lieu='+getElementById('l').value" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" width="640" height="580"></iframe>
            
            <!--DATE-->
            <strong><FONT face="Times New Roman">Date de debut du tournoi</FONT></strong><br/>
            <input type="datetime-local" name="dateDebut" required>

            <!--DUREE-->
            <strong><FONT face="Times New Roman">Duree du tournoi</FONT></strong><br/>
            <input type="number" min=0 name="duree" required>

            <!--Sport pour les infor generales-->
            <strong><FONT face="Times New Roman">Votre sport</FONT></strong>
        
            <?php
              $idUser = (int)$_SESSION['utilisateur']['id_utilisateur'];
              $sql = "SELECT idSport, idUtilisateur, nomSport FROM SportUtilisateur, Sport WHERE idSport = id_sport AND idUtilisateur = $idUser;";
            ?>

            <select name="idsport" id="sport">
        
            <?php

              $sport = $dbh->query("SELECT idSport, idUtilisateur, nomSport, nbjoueur FROM SportUtilisateur, Sport WHERE idSport = id_sport AND idUtilisateur = $idUser;");
            
              echo '<option value="val0">choisissez un sport</option>';
              foreach ($sport as $spt)
              {
                echo '<option id="sport" value="'.$spt['idSport'].'">'.$spt['nomSport'].'</option>';
              }
            ?>

            <!--<iframe style="width: 100%; border: 0"></iframe>-->
       
            </select><br/><br/>

            <!--BOUTONS-->
            <input type="reset" value="Reinitialiser" name="EffacerEntrees">    <input type="submit" value="Creer Le Tournoi" name="creerTournoi">

          </pre>
        </form>
        <pre></pre>
      </fieldset>

      <?php
        try {
          $var = 0;

          if (isset($_GET['creerTournoi'])) {
	          $sql = "INSERT INTO Tournoi (nomTournoi, dateDebut, duree, lieu, nbEquipe, typeT, idSport, etat) VALUES ('".$_GET['nomTournoi']."','".$_GET['dateDebut']."','".$_GET['duree']."','".$_GET['lieu']."',".$_GET['nbEquipe'].",'".$_GET['typeTournoi']."', '".$_GET['idsport']."', 'inscriptions ouvertes');";
            $sth = $dbh->prepare($sql);
            $sth->execute();
            $var = 1;
            }

            //METTRE FONCTION POUR BOUTTON VALIDER LIEU
            // FAIRE EXACTEMENT COMME LE RPFO MAIS EN PASSANT DERRIERE LE ? lieu

        } catch(PDOException $e) {
          print "Impossible d'ouvrir la base de données : " . $e->getMessage() . "<br/>";
          die("On arrête tout !");
        }

=======
<?php
  session_start();
  $isLoggedIn = isset($_SESSION['utilisateur']);
?>

<!doctype html>
<html lang="fr">
  <head> <meta charset="utf-8" />
   <title> Création d'un Tournoi </title>
  </head>

  <body>
    <h1><FONT face="Times New Roman"><pre>                                           Création du Tournoi </FONT></pre></h1>
      <?php 
       ini_set('display_errors', 1); error_reporting(E_ALL);
       try {
          $dsn = 'mysql:host=localhost;dbname=sports;charset=UTF8';
          $login = 'root';  // à délocaliser dans un fichier
          $password = '';  // à délocaliser dans un fichier 
          $dbh = new PDO($dsn, $login, $password);
        } 
        catch (PDOException $e) {
          print "Impossible d'ouvrir la base de données : " . $e->getMessage() . "<br/>";
          die("On arrête tout !");
        }
      ?>

      <fieldset>
        <form>
          <pre>
          
            <!-----------TOURNOI------------->

            <legend><FONT face="Times New Roman"><strong>            LE TOURNOI</FONT></strong></legend>

            <!--NOM-->
            <strong><FONT face="Times New Roman">Nom du tournoi</FONT></strong><br/>              
            <input type="text" name="nomTournoi" placeholder="Mon Tournoi" required/>

            <!--TYPE-->
            <strong><FONT face="Times New Roman">Type du tournoi</FONT></strong><br/>
            <select name="typeTournoi">
              <option value="coupe">Coupe</option>
              <option value="championnat">Championnat</option>
              <option value="tournoisATour">Tournoi a tour</option>
            </select>

            <!--NOMBRE EQUIPE-->
            <strong><FONT face="Times New Roman">Nombre d'equipe</FONT></strong><br/>
            <input type="number" name="nbEquipe" placeholder="2 minimum" min ="2" required>



            <!-----------ORGANISATION------------->
            <legend><FONT face="Times New Roman"><strong>            L'ORGANISATION</FONT></strong></legend><br/>

            <!--LIEU-->
            <strong><FONT face="Times New Roman">Lieu (Ville, Nom du Stade / Terrain ...)</FONT></strong><br/>
            <input type="text" id="l" name="lieu" placeholder="Localisation" required onchange="window.frames[0].location='lieu.php?lieu='+getElementById('l').value"> 

            <!--affichage de la carte-->
            <iframe onchange="window.frames[0].location='lieu.php?lieu='+getElementById('l').value" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" width="640" height="580"></iframe>
            
            <!--DATE-->
            <strong><FONT face="Times New Roman">Date de debut du tournoi</FONT></strong><br/>
            <input type="datetime-local" name="dateDebut" required>

            <!--DUREE-->
            <strong><FONT face="Times New Roman">Duree du tournoi</FONT></strong><br/>
            <input type="number" min=0 name="duree" required>

            <!--Sport pour les infor generales-->
            <strong><FONT face="Times New Roman">Votre sport</FONT></strong>
        
            <?php
              $idUser = (int)$_SESSION['utilisateur']['id_utilisateur'];
              $sql = "SELECT idSport, idUtilisateur, nomSport FROM SportUtilisateur, Sport WHERE idSport = id_sport AND idUtilisateur = $idUser;";
            ?>

            <select name="idsport" id="sport">
        
            <?php

              $sport = $dbh->query("SELECT idSport, idUtilisateur, nomSport, nbjoueur FROM SportUtilisateur, Sport WHERE idSport = id_sport AND idUtilisateur = $idUser;");
            
              echo '<option value="val0">choisissez un sport</option>';
              foreach ($sport as $spt)
              {
                echo '<option id="sport" value="'.$spt['idSport'].'">'.$spt['nomSport'].'</option>';
              }
            ?>

            <!--<iframe style="width: 100%; border: 0"></iframe>-->
       
            </select><br/><br/>

            <!--BOUTONS-->
            <input type="reset" value="Reinitialiser" name="EffacerEntrees">    <input type="submit" value="Creer Le Tournoi" name="creerTournoi">

          </pre>
        </form>
        <pre></pre>
      </fieldset>

      <?php
        try {
          $var = 0;

          if (isset($_GET['creerTournoi'])) {
	          $sql = "INSERT INTO Tournoi (nomTournoi, dateDebut, duree, lieu, nbEquipe, typeT, idSport, etat) VALUES ('".$_GET['nomTournoi']."','".$_GET['dateDebut']."','".$_GET['duree']."','".$_GET['lieu']."',".$_GET['nbEquipe'].",'".$_GET['typeTournoi']."', '".$_GET['idsport']."', 'inscriptions ouvertes');";
            $sth = $dbh->prepare($sql);
            $sth->execute();
            $var = 1;
            }

            //METTRE FONCTION POUR BOUTTON VALIDER LIEU
            // FAIRE EXACTEMENT COMME LE RPFO MAIS EN PASSANT DERRIERE LE ? lieu

        } catch(PDOException $e) {
          print "Impossible d'ouvrir la base de données : " . $e->getMessage() . "<br/>";
          die("On arrête tout !");
        }

>>>>>>> 3851daa9fbccf851b12ac4153978a9c8e82ff043
      ?>