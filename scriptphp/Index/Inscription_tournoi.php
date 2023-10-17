<<<<<<< HEAD
<?php
  session_start();
?>

<html>

  <head> 

    <title> Inscription au Tournoi</title>

  </head>


  <body>

    <?php 
      $dsn = "mysql:host=localhost;dbname=sports";  /* Data Source Name */
      $username = "root"; $password = "";
      $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
      $dbh = new PDO($dsn, $username, $password, $options) or die("Pb de connexion !");
      $isLoggedIn = isset($_SESSION['utilisateur']); 
    ?>


    <?php
      // Inscription
      if (isset($_GET['Inscription'])) {

        //on teste si lequipe n'existe pas déjà dans le tournois
        //je doit recuperer toutes les equipes qui participent au tournoi
        $req="SELECT * from ParticipEquipe, Tournoi WHERE id_tournoi = idTournoi AND idTournoi = ".$_GET['tournoi'].";"; //ici on veut une requete mobile avec plusieurs chose après
        //echo $req;        
        $res = $dbh->query($req); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
        
        ///////nb d'equipe qui participe au tournoi demandé
        $nb_tournoi = "SELECT COUNT(*) from ParticipEquipe WHERE idTournoi = ".$_GET['tournoi'].";"; //ici on veut une requete mobile avec plusieurs chose après
        //echo $nb_tournoi;        
        $nb = $dbh->query($nb_tournoi); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
        
        //////nb de fois d'une equipe est inscrit dans le tournoi actuel
        $req2 = "SELECT COUNT(*) from ParticipEquipe WHERE idTournoi = ".$_GET['tournoi']." AND idEquipe = ".$_GET['equipe'].";"; //ici on veut une requete mobile avec plusieurs chose après
        //echo $nb_tournoi;        
        $res2 = $dbh->query($req2); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
        
        if (!$res) die("Impossible d'executer la requete !");
        echo "<ul>";
        if (!$res2) die("Impossible d'executer la requete !");
        echo "<ul>";
        if (!$nb) die("Impossible d'executer la requete !");
        echo "<ul>";

        foreach ($res2 as $id2){
          //si l'equipe est déjà inscrite
          if ($id2['COUNT(*)'] != 0){
            echo "<strong>Votre equipe est deja inscrit dans ce tournoi. <br/></strong>";
            break;
          }
          else {
            foreach ($res as $id){
              //si le tournoi est complet
              if ($id['etat'] != 'inscriptions ouvertes'){
                echo "<strong>Ce tournoi n'est plus en phase d'inscription.</strong>";
                break;
              }
              else {
                //sinon
                //insertion de base de l'inscription si l'equipe n'existe pas déjà
	              $sql = "INSERT INTO ParticipEquipe (idEquipe, idTournoi) VALUES (".(int)$_GET['equipe'].", ".(int)$_GET['tournoi'].");";
                //execution
                $sth = $dbh->prepare($sql);
                $sth->execute();
              }//fin du sinon
            }//fin du foreach
          }//fin du else
        }//fin du foreach
      }//fin du if

      ///////nb d'equipe qui participe au tournoi demandé
      $nb_tournoi_apres = "SELECT COUNT(*) from ParticipEquipe WHERE idTournoi = ".$_GET['tournoi'].";"; //ici on veut une requete mobile avec plusieurs chose après
      //echo $nb_tournoi;        
      $nb_apres = $dbh->query($nb_tournoi_apres); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
      
      foreach ($res as $id){
        foreach ($nb as $n){
          if ($id['nbEquipe'] <= $n['COUNT(*)']){
            $id['etat'] = 'inscriptions terminées';
          }
        }
      }

    ?>
  
    <h1 align="center">Inscription au tournoi </h1>

    <fieldset> <!--pour mettre un cadre autour-->

      <form><!--formulaire de saisie-->

        <!--SPORT-->
        <strong>Votre sport</strong><br/><br/><br/>
        
        <?php
          $idUser = (int)$_SESSION['utilisateur']['id_utilisateur']; //on recupere l'id de l'utilisateur
          $sql = "SELECT idSport, idUtilisateur, nomSport FROM SportUtilisateur, Sport WHERE idSport = id_sport AND idUtilisateur = '$idUser';";
        ?>

        <select name="idsport" id="sport" onchange="window.frames[0].location='liste_inscription_equipe.php?idsport='+this.value">
        
        <?php

          $sport = $dbh->query("SELECT idSport, idUtilisateur, nomSport, nbjoueur FROM SportUtilisateur, Sport WHERE idSport = id_sport AND idUtilisateur = '$idUser';");
          
          echo '<option value="val0">choisissez un sport</option>';
          foreach ($sport as $spt)
          {
            echo '<option id="sport" value="'.$spt['idSport'].'">'.$spt['nomSport'].'  </option>';
          }
        ?>
        
       
        </select><br/><br/><br/>
        <iframe style="width: 100%; border: 0"></iframe>
        
      </form>

    </fieldset>

    <br/><br/>
    <form><p STYLE="padding:0 0 0 10px;"> <button type="submit" name="Retourmenu" >Retour au menu</button> </form><br/>
    <?php
      if (isset($_GET['Retourmenu'])){
        header("Location: menu_def.php");
      }
    ?>

  </body>

  
  <footer>

    <br/>

    <?php
    if ($isLoggedIn)  {
      ?>
          <button><a href="Logout.php">Logout</a></button>
      <?php  
        } 
      ?>
  </footer>

=======
<?php
  session_start();
?>

<html>

  <head> 

    <title> Inscription au Tournoi</title>

  </head>


  <body>

    <?php 
      $dsn = "mysql:host=localhost;dbname=sports";  /* Data Source Name */
      $username = "root"; $password = "";
      $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
      $dbh = new PDO($dsn, $username, $password, $options) or die("Pb de connexion !");
      $isLoggedIn = isset($_SESSION['utilisateur']); 
    ?>


    <?php
      // Inscription
      if (isset($_GET['Inscription'])) {

        //on teste si lequipe n'existe pas déjà dans le tournois
        //je doit recuperer toutes les equipes qui participent au tournoi
        $req="SELECT * from ParticipEquipe, Tournoi WHERE id_tournoi = idTournoi AND idTournoi = ".$_GET['tournoi'].";"; //ici on veut une requete mobile avec plusieurs chose après
        //echo $req;        
        $res = $dbh->query($req); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
        
        ///////nb d'equipe qui participe au tournoi demandé
        $nb_tournoi = "SELECT COUNT(*) from ParticipEquipe WHERE idTournoi = ".$_GET['tournoi'].";"; //ici on veut une requete mobile avec plusieurs chose après
        //echo $nb_tournoi;        
        $nb = $dbh->query($nb_tournoi); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
        
        //////nb de fois d'une equipe est inscrit dans le tournoi actuel
        $req2 = "SELECT COUNT(*) from ParticipEquipe WHERE idTournoi = ".$_GET['tournoi']." AND idEquipe = ".$_GET['equipe'].";"; //ici on veut une requete mobile avec plusieurs chose après
        //echo $nb_tournoi;        
        $res2 = $dbh->query($req2); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
        
        if (!$res) die("Impossible d'executer la requete !");
        echo "<ul>";
        if (!$res2) die("Impossible d'executer la requete !");
        echo "<ul>";
        if (!$nb) die("Impossible d'executer la requete !");
        echo "<ul>";

        foreach ($res2 as $id2){
          //si l'equipe est déjà inscrite
          if ($id2['COUNT(*)'] != 0){
            echo "<strong>Votre equipe est deja inscrit dans ce tournoi. <br/></strong>";
            break;
          }
          else {
            foreach ($res as $id){
              //si le tournoi est complet
              if ($id['etat'] != 'inscriptions ouvertes'){
                echo "<strong>Ce tournoi n'est plus en phase d'inscription.</strong>";
                break;
              }
              else {
                //sinon
                //insertion de base de l'inscription si l'equipe n'existe pas déjà
	              $sql = "INSERT INTO ParticipEquipe (idEquipe, idTournoi) VALUES (".(int)$_GET['equipe'].", ".(int)$_GET['tournoi'].");";
                //execution
                $sth = $dbh->prepare($sql);
                $sth->execute();
              }//fin du sinon
            }//fin du foreach
          }//fin du else
        }//fin du foreach
      }//fin du if

      ///////nb d'equipe qui participe au tournoi demandé
      $nb_tournoi_apres = "SELECT COUNT(*) from ParticipEquipe WHERE idTournoi = ".$_GET['tournoi'].";"; //ici on veut une requete mobile avec plusieurs chose après
      //echo $nb_tournoi;        
      $nb_apres = $dbh->query($nb_tournoi_apres); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
      
      foreach ($res as $id){
        foreach ($nb as $n){
          if ($id['nbEquipe'] <= $n['COUNT(*)']){
            $id['etat'] = 'inscriptions terminées';
          }
        }
      }

    ?>
  
    <h1 align="center">Inscription au tournoi </h1>

    <fieldset> <!--pour mettre un cadre autour-->

      <form><!--formulaire de saisie-->

        <!--SPORT-->
        <strong>Votre sport</strong><br/><br/><br/>
        
        <?php
          $idUser = (int)$_SESSION['utilisateur']['id_utilisateur']; //on recupere l'id de l'utilisateur
          $sql = "SELECT idSport, idUtilisateur, nomSport FROM SportUtilisateur, Sport WHERE idSport = id_sport AND idUtilisateur = '$idUser';";
        ?>

        <select name="idsport" id="sport" onchange="window.frames[0].location='liste_inscription_equipe.php?idsport='+this.value">
        
        <?php

          $sport = $dbh->query("SELECT idSport, idUtilisateur, nomSport, nbjoueur FROM SportUtilisateur, Sport WHERE idSport = id_sport AND idUtilisateur = '$idUser';");
          
          echo '<option value="val0">choisissez un sport</option>';
          foreach ($sport as $spt)
          {
            echo '<option id="sport" value="'.$spt['idSport'].'">'.$spt['nomSport'].'  </option>';
          }
        ?>
        
       
        </select><br/><br/><br/>
        <iframe style="width: 100%; border: 0"></iframe>
        
      </form>

    </fieldset>

    <br/><br/>
    <form><p STYLE="padding:0 0 0 10px;"> <button type="submit" name="Retourmenu" >Retour au menu</button> </form><br/>
    <?php
      if (isset($_GET['Retourmenu'])){
        header("Location: menu_def.php");
      }
    ?>

  </body>

  
  <footer>

    <br/>

    <?php
    if ($isLoggedIn)  {
      ?>
          <button><a href="Logout.php">Logout</a></button>
      <?php  
        } 
      ?>
  </footer>

>>>>>>> 3851daa9fbccf851b12ac4153978a9c8e82ff043
</html>