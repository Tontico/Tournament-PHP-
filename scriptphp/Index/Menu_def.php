<<<<<<< HEAD
<?php
  session_start();
  var_dump($_SESSION ['currentRole']);
 
?>

<!doctype html>
<html lang="fr">
  <head>
  <meta charset="utf-8" />
  <!--bootstrap : biblio  qui permet l'adaptation du interface à différents écran avec ordi tablette telephone va amener à javascript(animation, ....)-->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!--bcq de lien style graphique, sous biblio de js, ... pour utiliser bootstrapcdn on copie colle les liens avnt-->

    <title> Menu </title>

    <style>
    button {
      margin: 0 auto;
      background-color: black;
      border: black;
      border-radius: 15px;
      color: white;
      padding: 10px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 15px;
      cursor: pointer;

    }


    .carousel-item {
      height:300px;
    }
    .carousel-item img {
      height:300px;
    }

    .agrandir
    {
      width: 200px;
      height: 50px;
    }

    </style>

  </head>

  <body>

    <?php
      $dsn = "mysql:host=localhost;dbname=sports";  /* Data Source Name */
      $username = "root"; $password = "";
      $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
      $dbh = new PDO($dsn, $username, $password, $options) or die("Pb de connexion !");

      // Si 'utilisateur' est dans le tableau $_SESSION, ca veut dire que l'utilisateur est connecté, donc on peut creer une variable intermédiaire qui vaudra vrai ou faux en fonction que l'utilisateur est connecté ou non
      $isLoggedIn = isset($_SESSION['utilisateur']); 

      $idUser = (int)$_SESSION ['utilisateur']['id_utilisateur'];
      //je veux savoir si mon utilisateur est capitaine
      $capitaine = "SELECT idCapitaine FROM Equipe WHERE idCapitaine = $idUser;";
  
      $idcapitaine = $dbh->prepare($capitaine);
      $idCap = $idcapitaine->execute();
      $nbidCap=$idcapitaine->rowCount();
      //echo $capitaine;
      //echo $nbidCap;
    ?>
    
    <header class="row">
    
    <h1 class="col-sm-12 text-center align-self-center">
      <strong>
        <FONT face="Times New Roman">
          Menu  <br/>
          <h2> 
            <strong> 
              <?php 
                if ($isLoggedIn)  {
                // Quelqu'un est connecté, sprintf 
                  echo sprintf('Connecté(e) en tant que %s %s', $_SESSION['utilisateur']['nomUtilisateur'], $_SESSION['utilisateur']['prenomUtilisateur']);
                } 
                else {
                  echo 'Non connecté';
                }
              ?>
            </strong>
          </h2>
        </FONT>
      </strong>
    </h1>
  </header>

  <hr>
    <div class="row">
      <nav class="col-sm-3">
      
        <!-- ACCUEIL-->
        <br/><br/>
        
        
        <form><p STYLE="padding:0 0 0 100px;"> <button type="submit" name="Accueil" class="agrandir" style="font-weight: bold;"class="agrandir">Accueil</button></form><br/>
        <?php
          if (isset($_GET['Accueil'])){
            header("Location: Accueil.php");
          }

        ?>

        <!-- Création de l'équipe-->
        <?php if (in_array("Administrateur",$_SESSION ['currentRole']) || ($nbidCap != 0)) { //si non capitaine et si Adimin?> 
    
        <form><p STYLE="padding:0 0 0 100px;"> <button type="submit" name="Equipe"  style="font-weight: bold;" class="agrandir"> Creation d'une equipe </button></form><br/>
        
        <?php
          if (isset($_GET['Equipe'])){
            header("Location: Creation_Equipe.php");
          }
        ?>
        <?php } ?>

        <!-- Creation du tournois-->
        <?php if (in_array("Administrateur",$_SESSION ['currentRole']) || in_array("Gestionnaire",$_SESSION ['currentRole'])) { ?>

        <form><p STYLE="padding:0 0 0 100px;"> <button type="submit" name="Creation_Tournoi"  style="font-weight: bold;" class="agrandir">Creation du Tournoi </button> </form><br/>
        <?php
          if (isset($_GET['Creation_Tournoi'])){
            header("Location: Creation_Tournoi.php");
          }

        ?>
        <?php } ?>
    
      </nav>
    

      <nav class="col-sm-3">

    
        <!-- Inscription au tournois de l'equipe-->
        <?php if (in_array("Administrateur",$_SESSION ['currentRole']) || ($nbidCap != 0)) { ?>

        <br/><br/>
        <form><p STYLE="padding:0 0 0 10px;"> <button type="submit" name="Inscription_Tournois" style="font-weight: bold;" class="agrandir">Inscription au Tournoi</button> </form><br/>
        <?php
          if (isset($_GET['Inscription_Tournois'])){
            header("Location: Inscription_tournoi.php");
          }
        ?>
        <?php } ?>

        <!-- Planning des Rencontres-->
        <form><p STYLE="padding:0 0 0 10px;"> <button type="submit" name="Planning_rencontres" style="font-weight: bold;" class="agrandir">Planning des rencontres</button> </form><br/>
        <?php
          if (isset($_GET['Planning_rencontres'])){
            header("Location: championnat_match.php");
          }
        ?>

        <!-- Planning des Tournois-->
        <form><p STYLE="padding:0 0 0 10px;"> <button type="submit" name="Planning_tournois" style="font-weight: bold;" class="agrandir">Planning des Tournois</button> </form><br/>
        <?php
          if (isset($_GET['Planning_tournois'])){
          
          }
        ?>

      </nav>


      <div class="col-sm-6">
      <!--création des liens de catégories pour aller a un lien exterrieur ou non-->


        <div id="carousel" class="carousel slide col-sm-9 align-self-center" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="./image/boxe.jpg" alt="boxe">
            </div>
            <div class="carousel-item">
              <img  src="./image/basket.jpg" alt="basket">
            </div>
            <div class="carousel-item">
              <img  src="./image/course.jpg" alt="course">
            </div>
            <div class="carousel-item">
              <img  src="./image/medailles.jpg" alt="medailles">
            </div>
            <div class="carousel-item">
              <img  src="./image/rugby.jpg" alt="rugby">
            </div>
            <div class="carousel-item">
              <img  src="./image/tennis.jpg" alt="tennis">
            </div>
          </div>
        </div>

      </div>

      <script> 
        $('.carousel').carousel({ interval: 3000 })
      </script>

    </div> 

    <br/>
    <br/>
    
    <hr>

    <footer class="row">
  
	    <div class='col-sm-4 text-center'>
        <form><button type="submit" name="Aide" class="agrandir">Aide</button> </form><br/>
          <?php
            if (isset($_GET['Aide'])){
            
            }
          ?>
	    </div>

	    <div class='col-sm-4 text-center'>
		    <h2><strong><FONT face="Times New Roman">Tournoi sportif</FONT></strong></h2>
	    </div>

	    <div class='col-sm-4 text-center'>
		    <button><a href="mailto:contact@harddiscounter.com?subject=Demande de Contact">Nous contacter</a></button> <!--pour nous contacter pour ouvrir une page pour leurs envoyer un mail-->
      </div>

      <br/>

      <?php
        // On affiche le lien de déconnexion que si l'utilisateur est connecté.
        if ($isLoggedIn)  {
      ?>
          <button><a href="Logout.php">Logout</a></button>
      <?php  
        } 
      ?>
  
    </footer>

  </body>

</html>
=======
<?php
  session_start();
  var_dump($_SESSION ['currentRole']);
 
?>

<!doctype html>
<html lang="fr">
  <head>
  <meta charset="utf-8" />
  <!--bootstrap : biblio  qui permet l'adaptation du interface à différents écran avec ordi tablette telephone va amener à javascript(animation, ....)-->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!--bcq de lien style graphique, sous biblio de js, ... pour utiliser bootstrapcdn on copie colle les liens avnt-->

    <title> Menu </title>

    <style>
    button {
      margin: 0 auto;
      background-color: black;
      border: black;
      border-radius: 15px;
      color: white;
      padding: 10px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 15px;
      cursor: pointer;

    }


    .carousel-item {
      height:300px;
    }
    .carousel-item img {
      height:300px;
    }

    .agrandir
    {
      width: 200px;
      height: 50px;
    }

    </style>

  </head>

  <body>

    <?php
      $dsn = "mysql:host=localhost;dbname=sports";  /* Data Source Name */
      $username = "root"; $password = "";
      $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
      $dbh = new PDO($dsn, $username, $password, $options) or die("Pb de connexion !");

      // Si 'utilisateur' est dans le tableau $_SESSION, ca veut dire que l'utilisateur est connecté, donc on peut creer une variable intermédiaire qui vaudra vrai ou faux en fonction que l'utilisateur est connecté ou non
      $isLoggedIn = isset($_SESSION['utilisateur']); 

      $idUser = (int)$_SESSION ['utilisateur']['id_utilisateur'];
      //je veux savoir si mon utilisateur est capitaine
      $capitaine = "SELECT idCapitaine FROM Equipe WHERE idCapitaine = $idUser;";
  
      $idcapitaine = $dbh->prepare($capitaine);
      $idCap = $idcapitaine->execute();
      $nbidCap=$idcapitaine->rowCount();
      //echo $capitaine;
      //echo $nbidCap;
    ?>
    
    <header class="row">
    
    <h1 class="col-sm-12 text-center align-self-center">
      <strong>
        <FONT face="Times New Roman">
          Menu  <br/>
          <h2> 
            <strong> 
              <?php 
                if ($isLoggedIn)  {
                // Quelqu'un est connecté, sprintf 
                  echo sprintf('Connecté(e) en tant que %s %s', $_SESSION['utilisateur']['nomUtilisateur'], $_SESSION['utilisateur']['prenomUtilisateur']);
                } 
                else {
                  echo 'Non connecté';
                }
              ?>
            </strong>
          </h2>
        </FONT>
      </strong>
    </h1>
  </header>

  <hr>
    <div class="row">
      <nav class="col-sm-3">
      
        <!-- ACCUEIL-->
        <br/><br/>
        
        
        <form><p STYLE="padding:0 0 0 100px;"> <button type="submit" name="Accueil" class="agrandir" style="font-weight: bold;"class="agrandir">Accueil</button></form><br/>
        <?php
          if (isset($_GET['Accueil'])){
            header("Location: Accueil.php");
          }

        ?>

        <!-- Création de l'équipe-->
        <?php if (in_array("Administrateur",$_SESSION ['currentRole']) || ($nbidCap != 0)) { //si non capitaine et si Adimin?> 
    
        <form><p STYLE="padding:0 0 0 100px;"> <button type="submit" name="Equipe"  style="font-weight: bold;" class="agrandir"> Creation d'une equipe </button></form><br/>
        
        <?php
          if (isset($_GET['Equipe'])){
            header("Location: Creation_Equipe.php");
          }
        ?>
        <?php } ?>

        <!-- Creation du tournois-->
        <?php if (in_array("Administrateur",$_SESSION ['currentRole']) || in_array("Gestionnaire",$_SESSION ['currentRole'])) { ?>

        <form><p STYLE="padding:0 0 0 100px;"> <button type="submit" name="Creation_Tournoi"  style="font-weight: bold;" class="agrandir">Creation du Tournoi </button> </form><br/>
        <?php
          if (isset($_GET['Creation_Tournoi'])){
            header("Location: Creation_Tournoi.php");
          }

        ?>
        <?php } ?>
    
      </nav>
    

      <nav class="col-sm-3">

    
        <!-- Inscription au tournois de l'equipe-->
        <?php if (in_array("Administrateur",$_SESSION ['currentRole']) || ($nbidCap != 0)) { ?>

        <br/><br/>
        <form><p STYLE="padding:0 0 0 10px;"> <button type="submit" name="Inscription_Tournois" style="font-weight: bold;" class="agrandir">Inscription au Tournoi</button> </form><br/>
        <?php
          if (isset($_GET['Inscription_Tournois'])){
            header("Location: Inscription_tournoi.php");
          }
        ?>
        <?php } ?>

        <!-- Planning des Rencontres-->
        <form><p STYLE="padding:0 0 0 10px;"> <button type="submit" name="Planning_rencontres" style="font-weight: bold;" class="agrandir">Planning des rencontres</button> </form><br/>
        <?php
          if (isset($_GET['Planning_rencontres'])){
            header("Location: championnat_match.php");
          }
        ?>

        <!-- Planning des Tournois-->
        <form><p STYLE="padding:0 0 0 10px;"> <button type="submit" name="Planning_tournois" style="font-weight: bold;" class="agrandir">Planning des Tournois</button> </form><br/>
        <?php
          if (isset($_GET['Planning_tournois'])){
          
          }
        ?>

      </nav>


      <div class="col-sm-6">
      <!--création des liens de catégories pour aller a un lien exterrieur ou non-->


        <div id="carousel" class="carousel slide col-sm-9 align-self-center" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="./image/boxe.jpg" alt="boxe">
            </div>
            <div class="carousel-item">
              <img  src="./image/basket.jpg" alt="basket">
            </div>
            <div class="carousel-item">
              <img  src="./image/course.jpg" alt="course">
            </div>
            <div class="carousel-item">
              <img  src="./image/medailles.jpg" alt="medailles">
            </div>
            <div class="carousel-item">
              <img  src="./image/rugby.jpg" alt="rugby">
            </div>
            <div class="carousel-item">
              <img  src="./image/tennis.jpg" alt="tennis">
            </div>
          </div>
        </div>

      </div>

      <script> 
        $('.carousel').carousel({ interval: 3000 })
      </script>

    </div> 

    <br/>
    <br/>
    
    <hr>

    <footer class="row">
  
	    <div class='col-sm-4 text-center'>
        <form><button type="submit" name="Aide" class="agrandir">Aide</button> </form><br/>
          <?php
            if (isset($_GET['Aide'])){
            
            }
          ?>
	    </div>

	    <div class='col-sm-4 text-center'>
		    <h2><strong><FONT face="Times New Roman">Tournoi sportif</FONT></strong></h2>
	    </div>

	    <div class='col-sm-4 text-center'>
		    <button><a href="mailto:contact@harddiscounter.com?subject=Demande de Contact">Nous contacter</a></button> <!--pour nous contacter pour ouvrir une page pour leurs envoyer un mail-->
      </div>

      <br/>

      <?php
        // On affiche le lien de déconnexion que si l'utilisateur est connecté.
        if ($isLoggedIn)  {
      ?>
          <button><a href="Logout.php">Logout</a></button>
      <?php  
        } 
      ?>
  
    </footer>

  </body>

</html>
>>>>>>> 3851daa9fbccf851b12ac4153978a9c8e82ff043
