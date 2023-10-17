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
    $sportChoisi = $_GET['idsport'];
    //$sport = $dbh->query("SELECT id_sport, nomSport, nbjoueur FROM Sport");
    //$sport->execute();
    //foreach ($sport as $spt){
    //    if ($sportChoisi == $spt['id_sport']) {
    //      $nombre = $spt['nbjoueur'];}
    //}  

?>

<?php
    
  echo '<form action="Inscription_tournoi.php" target="parent">';
  //je veux recuperer la liste des tournois qui sont dans ce sport
    if ($_GET['idsport'] != 'val0') {


      //Equipe pour les infos generales;
      echo '<strong>Choisissez votre Equipe</strong><br/><br/>';

      $idUser = (int)$_SESSION['utilisateur']['id_utilisateur']; //on recupere l'id de l'utilisateur
            
      $sqlequipe = "SELECT id_equipe, nomEquipe FROM Equipe WHERE sport=".$_GET['idsport']." AND idCapitaine = $idUser;";
      //echo $sqlequipe;
      $equipe = $dbh->query($sqlequipe);
      $equipe->execute();

      echo '<br/><br/><select name="equipe" id="eq" >'; //on veut les valeurs
      echo '<br/><br/><option value="val0">Choisissez votre equipe</option>';

      foreach ($equipe as $equ)
      {
        echo '<option value="'.$equ['id_equipe'].'">'.$equ['nomEquipe'].'</option>';
      }
      echo"</select>";


      //Tournoi pour les infos generales
      echo '<br/><br/><br/><br/><strong>Choisissez un Tournoi</strong><br/><br/>';

      $sql = "SELECT id_tournoi, nomTournoi FROM Tournoi WHERE idSport=".$_GET['idsport'].";";
      //echo $sql;
      $tournoi= $dbh->query($sql);
      $tournoi->execute();

      echo '<br/><br/><select name="tournoi" id="tour">';
      echo '<br/><br/><option value="val0">Choisissez un Tournoi</option>';

      foreach ($tournoi as $tn)
      {
        echo '<option value="'.$tn['id_tournoi'].'">'.$tn['nomTournoi'].'</option>';
      }
      echo "</select></br>";


    

    //BOUTONS
    echo '</br></br><input type="reset" value="EFFACER" name="EffacerEntrees">';
    echo '<input type="submit" value="INSCRIPTION" name="Inscription" />';

    echo '</form>';  
 } ?>

<iframe style="width: 100%; border: 0"></iframe>

</body>
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
    $sportChoisi = $_GET['idsport'];
    //$sport = $dbh->query("SELECT id_sport, nomSport, nbjoueur FROM Sport");
    //$sport->execute();
    //foreach ($sport as $spt){
    //    if ($sportChoisi == $spt['id_sport']) {
    //      $nombre = $spt['nbjoueur'];}
    //}  

?>

<?php
    
  echo '<form action="Inscription_tournoi.php" target="parent">';
  //je veux recuperer la liste des tournois qui sont dans ce sport
    if ($_GET['idsport'] != 'val0') {


      //Equipe pour les infos generales;
      echo '<strong>Choisissez votre Equipe</strong><br/><br/>';

      $idUser = (int)$_SESSION['utilisateur']['id_utilisateur']; //on recupere l'id de l'utilisateur
            
      $sqlequipe = "SELECT id_equipe, nomEquipe FROM Equipe WHERE sport=".$_GET['idsport']." AND idCapitaine = $idUser;";
      //echo $sqlequipe;
      $equipe = $dbh->query($sqlequipe);
      $equipe->execute();

      echo '<br/><br/><select name="equipe" id="eq" >'; //on veut les valeurs
      echo '<br/><br/><option value="val0">Choisissez votre equipe</option>';

      foreach ($equipe as $equ)
      {
        echo '<option value="'.$equ['id_equipe'].'">'.$equ['nomEquipe'].'</option>';
      }
      echo"</select>";


      //Tournoi pour les infos generales
      echo '<br/><br/><br/><br/><strong>Choisissez un Tournoi</strong><br/><br/>';

      $sql = "SELECT id_tournoi, nomTournoi FROM Tournoi WHERE idSport=".$_GET['idsport'].";";
      //echo $sql;
      $tournoi= $dbh->query($sql);
      $tournoi->execute();

      echo '<br/><br/><select name="tournoi" id="tour">';
      echo '<br/><br/><option value="val0">Choisissez un Tournoi</option>';

      foreach ($tournoi as $tn)
      {
        echo '<option value="'.$tn['id_tournoi'].'">'.$tn['nomTournoi'].'</option>';
      }
      echo "</select></br>";


    

    //BOUTONS
    echo '</br></br><input type="reset" value="EFFACER" name="EffacerEntrees">';
    echo '<input type="submit" value="INSCRIPTION" name="Inscription" />';

    echo '</form>';  
 } ?>

<iframe style="width: 100%; border: 0"></iframe>

</body>
>>>>>>> 3851daa9fbccf851b12ac4153978a9c8e82ff043
</html>