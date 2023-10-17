<<<<<<< HEAD
<?php
  session_start();
?>

<!doctype html>
<html>
  <head> 

    <title>Organisation des rencontres entre 2 equipes</title>

    <script>

      
    </script>
  </head>
  


  <body>

    <?php 
      var_dump($_SESSION['utilisateur']);
      var_dump($_SESSION['currentRole']);
      var_dump($_SESSION['currentSport']);
      $dsn = "mysql:host=localhost;dbname=sports";  /* Data Source Name */
      $username = "root"; $password = "";
      $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
      $dbh = new PDO($dsn, $username, $password, $options) or die("Pb de connexion !");
      $isLoggedIn = isset($_SESSION['utilisateur']); 
    ?>

    <!--on doit organiser une rencontres pour cela on doit prendre deux equipes qui sont dans le meme tournois donc par def dans le sport
    donc on cherche une equipe dans le tournois 
    equipe 1 = premier case : SELECT idEquipe, nomEquipe FROM ParticipEquipe, Equipe WHERE id_equipe = idEquipe AND idTournois = tournois ou je fait la rencontre;
    equipe2 = deuxieme case
    creer des binome jusqua ce qu'il n'y en ai plus que tu met dans la table rencontre et tu associe le match au tournois-->



    <h1 align="center">Organisation des rencontres entre 2 equipes</h1>
    <br/><br/>

    <!--Bouton pour revenir au menu-->
    <form><p STYLE="padding:0 0 0 10px;"> <button type="submit" name="Retourmenu" >Retour au menu</button> </form><br/>
    <?php
      if (isset($_GET['Retourmenu'])){
        header("Location: menu_def.php");
      }
    ?>


      <!--Sur la page :-->
     <!--Affichage de la liste des sport de l'utilisateur -->

    <?php
        $idUser = (int)$_SESSION['utilisateur']['id_utilisateur'];
        $sql = "SELECT idSport, idUtilisateur, nomSport FROM SportUtilisateur, Sport WHERE idSport = id_sport AND idUtilisateur = $idUser;";
    ?>
    <form>
        <strong>Choisissez un sport</strong><br/><br/>
        <select name="id" id="sport" >

        <?php
            $sport = $dbh->query("SELECT idSport, idUtilisateur, nomSport, nbjoueur FROM SportUtilisateur, Sport WHERE idSport = id_sport AND idUtilisateur = $idUser;");
            $sport->execute();
            echo '<option value="val0">choisissez un sport</option>';

            foreach ($sport as $spt)
            {
              echo '<option id="sport" value="'.$spt['idSport'].'">'.$spt['nomSport'].'</option>';
            }
        ?>

        </select><br/><br/><br/>

        <!--BOUTONS-->
        <input type="reset" value="ENLEVER LE SPORT CHOISIT" name="EffacerEntrees"> 
        <input type="submit" id="submit" value="AFFICHER LES TOURNOIS DANS CE SPORT" name="affichesport" > <br/><br/><br/>
    </form>
    


    <?php

        
    //Quan dj'ai afficher mon sport je fais voir un autre formulaire pour selectionner un tournois

      if (isset($_GET['affichesport'])){
        //tu chercher les tournois qui sont dans ce sport 
        echo "Liste des tournois dans ce sport : ";

        $listetournoi="SELECT * from Tournoi WHERE idSport = ".$_GET['id']." ;"; //ici on veut une requete mobile avec plusieurs chose après
        echo $listetournoi;
        //echo $req;
  
        $tour = $dbh->query($listetournoi); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
        if (!$tour) die("Impossible d'éxécuter la requête !");
        echo "<ul>";

        echo "<form>";
        echo "<strong>Choisissez un tournoi</strong><br/><br/>";
        echo "<select name='idtournoi' id='tournoi' >";

        echo '<option value="val0">choisissez un tournoi</option>';

        foreach ($tour as $t)
        {
            echo '<option id="tournoi" value="'.$t['id_tournoi'].'">'.$t['nomTournoi'].'</option>';
        }

    ?>

        </select><br/><br/><br/>

        <!--BOUTONS-->
        <input type="reset" value="ENLEVER LE TOURNOI CHOISIT" name="EffacerEntrees"> 
        <input type="submit" id="submit" value="AFFICHER LES EQUIPES DANS CE TOUNOI" name="affichetournoi" > <br/><br/><br/>
    </form>

    <?php } ?>

    <!--Fin du tournoi-->


    <?php
    
        //Quand j'ai afficher le tournois je veux maintenant les equipes qui sont dans ce tournoi

        if (isset($_GET['affichetournoi'])){
         
            //Affichage des equipes du tournois-->
    
            echo "Liste des equipes participant au tournoi : ";
      
            $req="SELECT * from Equipe, ParticipEquipe, Sport WHERE id_equipe = idEquipe AND id_sport = sport AND idTournoi = ".$_GET['idtournoi']." ;"; //ici on veut une requete mobile avec plusieurs chose après
            //echo $req;

            $res = $dbh->query($req); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
        
            if (!$res) die("Impossible d'éxécuter la requête !");
            echo "<ul>";

            //je vuex recup les info du tournoi selectionné
            $reqt="SELECT * from Tournoi WHERE id_tournoi = ".$_GET['idtournoi']." ;"; //ici on veut une requete mobile avec plusieurs chose après
            //echo $req;
            $rest = $dbh->prepare($reqt); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
            $rest->execute();

            if (!$rest) die("Impossible d'éxécuter la requête !");
            echo "<ul>";
            
            $tournoi = $rest->fetch();
            $_SESSION ['currentTournoi'] = $tournoi;
            var_dump($_SESSION['currentTournoi']);

            echo "Nom du Tournoi : ".$_SESSION['currentTournoi']['nomTournoi']."";
            

            //On a afficher la liste des equipes qui participent au tournoi dans le sport choisis maintenant il faut créer les rencontres donc afficher les différents binome d'equipe 
            //et rapeler le script jusqua qu'il n'y est plus dequipe à l'etape une et renvoyer les equipe gagnante à l'étape deux-->
        
            //Pour cela on doit prednre la premiere equipe et la deuxieme equipe du tournois pour les inscrire dans un match et le match qu'on inscrira dans le tournoi-->
        
            //on selectionne toutes les equipes qui participe au tournois--> 

            echo "<br/><br/>";
            $nombre = 0;
            foreach($res as $nom){ //$enr tableau de chaque enregistrement
              $nombre = $nombre + 1;
              echo "<li> Equipe$nombre : ".$nom['nomEquipe']." </li>"; //nom un des attributs
            }
            echo "</ul>";//permet de créer une liste

            echo "<form>";
            //BOUTONS-->
            echo "<input type='submit' id='submit' value='AFFICHER LES RENCONTRES' name='afficherencontre' > <br/><br/><br/>";
            echo "</form>";

            //maintenant on vient de lister les equipe on va donc devoir les mettre en binome 
            //donc on va les inscrire dans des matchs donc faut qu'on créer  un script qui va se rapeler jusqu'a il n'y est plus d'equipe
            //on va créer un nouveau bouton qui va etre afficher les rencontres entre les equipes
        }


        if (isset ($_GET['afficherencontre'])){

          $req="SELECT * from Equipe, ParticipEquipe, Sport WHERE id_equipe = idEquipe AND id_sport = sport AND idTournoi = ".(int)$_SESSION['currentTournoi']['id_tournoi']." ;"; //ici on veut une requete mobile avec plusieurs chose après
          //echo $req;
        
          $res = $dbh->query($req); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
        
          if (!$res) die("Impossible d'éxécuter la requête !");
          echo "<ul>";

          echo "<br/><br/>";


          /////////CALCULER LA DATE DE FIN DE TOURNOIS//////////


          //jour
          $jourTournoi1 = $_SESSION['currentTournoi']['dateDebut'][8];
          $jourTournoi2 = $_SESSION['currentTournoi']['dateDebut'][9];

          $jourTournoi = "".$jourTournoi1."".$jourTournoi2."";
          //echo $jourTournoi;

          //mois
          $moisTournoi1 = $_SESSION['currentTournoi']['dateDebut'][5];
          $moisTournoi2 = $_SESSION['currentTournoi']['dateDebut'][6];

          $moisTournoi = "".$moisTournoi1."".$moisTournoi2."";
          //echo $moisTournoi;

          //annee
          $anneeTournoi1 = $_SESSION['currentTournoi']['dateDebut'][0];
          $anneeTournoi2 = $_SESSION['currentTournoi']['dateDebut'][1];
          $anneeTournoi3 = $_SESSION['currentTournoi']['dateDebut'][2];
          $anneeTournoi4 = $_SESSION['currentTournoi']['dateDebut'][3];

          $anneeTournoi = "".$anneeTournoi1."".$anneeTournoi2."".$anneeTournoi3."".$anneeTournoi4."";
          //echo $anneeTournoi;

          $duree = (int)$_SESSION['currentTournoi']['duree'];

          echo "date de debut : ";
          echo $anneeTournoi;
          echo "-";
          echo $moisTournoi;
          echo "-";
          echo $jourTournoi;
          echo "<br/>";

          echo "duree : ";
          echo $duree;
          echo "<br/>";

          //fonction qui me calcul la date en fonction de la durée 
          function differentMois($nb, $moisT, $jourT, $anneeT, $d){
            if ($d == $nb){//si la duree est egale a $nb jours
              if ($moisT+1 > 12){
                date_fin(0, ($moisT+1)-12, $jourT, $anneeT+1);
              }
              else{
                date_fin(0, $moisT+1, $jourT, $anneeT);
              }
            }
            elseif ($d > $nb) {
              //si la longueur du tournoi est de plus de $nb jours on ajoute au mois 1 et on enleve $nb a la duree
              if ($moisT+1 > 12){
                date_fin($d-$nb, ($moisT+1)-12, $jourT, $anneeT+1);
              }
              else{
                date_fin($d-$nb, $moisT+1, $jourT, $anneeT);
              }
            }
            elseif ($d < $nb){//si la duree et plus petite que $nb jours
              if ($moisT > 12){
                date_fin(0, $moisT-12, $jourT+$d, $anneeT+1);
              }
              else{
                date_fin(0, $moisT, $jourT+$d, $anneeT);
              }
            }
          }

          //fonction qui affiche la date de fin du tournoi 
          function date_fin($d, $moisT, $jourT, $anneeT){
            
            if ($d != 0){
              if ($moisT == 1 || $moisT == 3 || $moisT == 5 || $moisT == 7 || $moisT == 8 || $moisT == 10 || $moisT == 12) {
                //si ce sont des mois en 31 jours
                differentMois(31, $moisT, $jourT, $anneeT, $d);
              }
              elseif (($moisT == 4 || $moisT == 6) || ($moisT == 9 || $moisT == 11)){
                //si ce sont des mois en 30 jours
                differentMois(30, $moisT, $jourT, $anneeT, $d);
              }
              elseif ($moisT == 2){  //si le mois est egal à 02 donc le mois de février
                differentMois(28, $moisT, $jourT, $anneeT, $d);                  
              }
            }
            else{
              if ($moisT < 10){
                return $anneeT."-0".$moisT."-".$jourT;
              }
              else{
                return $anneeT."-".$moisT."-".$jourT;
              }
            }
          }

          echo "date de fin : ";
          echo date_fin(2, 03, 12, 2021);
          
          echo "<br/><br/>";
          //jappel ma fonction date_fin() pour obtenir ma date de finS

          //fonction qui donne la date voulu en fonction de la date de debut et de la durée on pourrait utiliser afficher_date_de_fin mais il faut stocker le resultat dans une variable
          
          //echo $anneeT;
          //echo "-0";
          //echo $moisT;
          //echo "-";
          //echo $jourT;



          /////////AFFICHAGE DES RENCONTRES ENTRE LES EQUIPES/////////

          //faut que je fasse match 1 : equipe 1 equipe 2
          //match 2 : equipe 3 equipe 4

          echo "<br/>Rencontre du Tournoi : ";
          echo $_SESSION['currentTournoi']['nomTournoi'];
          echo " avec l'id ";
          echo $_SESSION['currentTournoi']['id_tournoi'];
          echo "<br/><br/>";


          $nombrematch = 0;
          $jour = 0;
          $dateHoraire = "";

          for ($i=0; $i<($_SESSION['currentTournoi']['nbEquipe'] / 2); $i++){
            
            foreach($res as $nom){
              var_dump($nom);
              $jour = $jour + 1;
              echo "<br/><strong>Jour : ";
              echo $jour;
              echo "</strong><br/><br/>";

              $dateHoraire = $dateHoraire.date_fin($jour, $moisTournoi, $jourTournoi, $anneeTournoi)." 14:00:00";
              //echo $dateHoraire;

              /////insertion de base de la RECONTRE///
              $sql = "INSERT INTO Rencontre (dateHoraire, idGagnant, poule, tour_journee) VALUES (NULL, NULL, NULL, $jour);";
              //execution
              $sth = $dbh->prepare($sql);
              $sth->execute();
              if (!$sth) die("Impossible d'éxécuter la requête !");
              echo "<ul>";


              //je vuex recup les info du match en cours
              $infos_match="SELECT * from Rencontre WHERE id_match = LAST_INSERT_ID() ;"; //ici on veut une requete mobile avec plusieurs chose après
              //echo $req;
              $infos = $dbh->prepare($infos_match); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
              $infos->execute();
              if (!$infos) die("Impossible d'éxécuter la requête !");
              //echo "<ul>";
              $match = $infos->fetch();
              //on stocke les infos dans la session
              $_SESSION ['currentMatch'] = $match;
              var_dump($_SESSION ['currentMatch']);


              echo "<li> Match".($nombrematch+$i+1)." : </li>";
              echo "<ul> Equipe 1 : ".$nom['nomEquipe']." </ul>"; //nom un des attributs

              foreach($res as $nom2){
                var_dump($nom2);
                echo "<ul> Equipe 2 : ".$nom2['nomEquipe']." </ul>"; //nom un des attributs
                
                //insertion de table LISTEEQUIPE pour lier les match avec les equipes et attribuer les score à chacun
	              //PREMIERE EQUIPE
                $sql = "INSERT INTO ListeEquipe (idMatch, idEquipe, score) VALUES (".$_SESSION ['currentMatch']['id_match'].", ".$nom['id_equipe'].", NULL);";
                //execution
                $sth = $dbh->prepare($sql);
                $sth->execute();
                //DEUXIEME EQUIPE
                $sql = "INSERT INTO ListeEquipe (idMatch, idEquipe, score) VALUES (".$_SESSION['currentMatch']['id_match'].", ".$nom2['id_equipe'].", NULL);";
                //execution
                $sth = $dbh->prepare($sql);
                $sth->execute();

                //insertion dans PARTICIPMATCH les liens des matchs avec les tournois
                $sql2 = "INSERT INTO ParticipMatch (idMatch, idTournoi) VALUES (".$_SESSION['currentMatch']['id_match'].", ".$_SESSION['currentTournoi']['id_tournoi'].");";
                //execution
                $sth2 = $dbh->prepare($sql2);
                $sth2->execute();
                break;
              }
              $nombrematch = $nombrematch + 1;
            }
            $dateHoraire = "";
          }


          $date_debut_tournoi = $_SESSION['currentTournoi']['dateDebut'];
        }

    ?>


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

<!doctype html>
<html>
  <head> 

    <title>Organisation des rencontres entre 2 equipes</title>

    <script>

      
    </script>
  </head>
  


  <body>

    <?php 
      var_dump($_SESSION['utilisateur']);
      var_dump($_SESSION['currentRole']);
      var_dump($_SESSION['currentSport']);
      $dsn = "mysql:host=localhost;dbname=sports";  /* Data Source Name */
      $username = "root"; $password = "";
      $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
      $dbh = new PDO($dsn, $username, $password, $options) or die("Pb de connexion !");
      $isLoggedIn = isset($_SESSION['utilisateur']); 
    ?>

    <!--on doit organiser une rencontres pour cela on doit prendre deux equipes qui sont dans le meme tournois donc par def dans le sport
    donc on cherche une equipe dans le tournois 
    equipe 1 = premier case : SELECT idEquipe, nomEquipe FROM ParticipEquipe, Equipe WHERE id_equipe = idEquipe AND idTournois = tournois ou je fait la rencontre;
    equipe2 = deuxieme case
    creer des binome jusqua ce qu'il n'y en ai plus que tu met dans la table rencontre et tu associe le match au tournois-->



    <h1 align="center">Organisation des rencontres entre 2 equipes</h1>
    <br/><br/>

    <!--Bouton pour revenir au menu-->
    <form><p STYLE="padding:0 0 0 10px;"> <button type="submit" name="Retourmenu" >Retour au menu</button> </form><br/>
    <?php
      if (isset($_GET['Retourmenu'])){
        header("Location: menu_def.php");
      }
    ?>


      <!--Sur la page :-->
     <!--Affichage de la liste des sport de l'utilisateur -->

    <?php
        $idUser = (int)$_SESSION['utilisateur']['id_utilisateur'];
        $sql = "SELECT idSport, idUtilisateur, nomSport FROM SportUtilisateur, Sport WHERE idSport = id_sport AND idUtilisateur = $idUser;";
    ?>
    <form>
        <strong>Choisissez un sport</strong><br/><br/>
        <select name="id" id="sport" >

        <?php
            $sport = $dbh->query("SELECT idSport, idUtilisateur, nomSport, nbjoueur FROM SportUtilisateur, Sport WHERE idSport = id_sport AND idUtilisateur = $idUser;");
            $sport->execute();
            echo '<option value="val0">choisissez un sport</option>';

            foreach ($sport as $spt)
            {
              echo '<option id="sport" value="'.$spt['idSport'].'">'.$spt['nomSport'].'</option>';
            }
        ?>

        </select><br/><br/><br/>

        <!--BOUTONS-->
        <input type="reset" value="ENLEVER LE SPORT CHOISIT" name="EffacerEntrees"> 
        <input type="submit" id="submit" value="AFFICHER LES TOURNOIS DANS CE SPORT" name="affichesport" > <br/><br/><br/>
    </form>
    


    <?php

        
    //Quan dj'ai afficher mon sport je fais voir un autre formulaire pour selectionner un tournois

      if (isset($_GET['affichesport'])){
        //tu chercher les tournois qui sont dans ce sport 
        echo "Liste des tournois dans ce sport : ";

        $listetournoi="SELECT * from Tournoi WHERE idSport = ".$_GET['id']." ;"; //ici on veut une requete mobile avec plusieurs chose après
        echo $listetournoi;
        //echo $req;
  
        $tour = $dbh->query($listetournoi); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
        if (!$tour) die("Impossible d'éxécuter la requête !");
        echo "<ul>";

        echo "<form>";
        echo "<strong>Choisissez un tournoi</strong><br/><br/>";
        echo "<select name='idtournoi' id='tournoi' >";

        echo '<option value="val0">choisissez un tournoi</option>';

        foreach ($tour as $t)
        {
            echo '<option id="tournoi" value="'.$t['id_tournoi'].'">'.$t['nomTournoi'].'</option>';
        }

    ?>

        </select><br/><br/><br/>

        <!--BOUTONS-->
        <input type="reset" value="ENLEVER LE TOURNOI CHOISIT" name="EffacerEntrees"> 
        <input type="submit" id="submit" value="AFFICHER LES EQUIPES DANS CE TOUNOI" name="affichetournoi" > <br/><br/><br/>
    </form>

    <?php } ?>

    <!--Fin du tournoi-->


    <?php
    
        //Quand j'ai afficher le tournois je veux maintenant les equipes qui sont dans ce tournoi

        if (isset($_GET['affichetournoi'])){
         
            //Affichage des equipes du tournois-->
    
            echo "Liste des equipes participant au tournoi : ";
      
            $req="SELECT * from Equipe, ParticipEquipe, Sport WHERE id_equipe = idEquipe AND id_sport = sport AND idTournoi = ".$_GET['idtournoi']." ;"; //ici on veut une requete mobile avec plusieurs chose après
            //echo $req;

            $res = $dbh->query($req); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
        
            if (!$res) die("Impossible d'éxécuter la requête !");
            echo "<ul>";

            //je vuex recup les info du tournoi selectionné
            $reqt="SELECT * from Tournoi WHERE id_tournoi = ".$_GET['idtournoi']." ;"; //ici on veut une requete mobile avec plusieurs chose après
            //echo $req;
            $rest = $dbh->prepare($reqt); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
            $rest->execute();

            if (!$rest) die("Impossible d'éxécuter la requête !");
            echo "<ul>";
            
            $tournoi = $rest->fetch();
            $_SESSION ['currentTournoi'] = $tournoi;
            var_dump($_SESSION['currentTournoi']);

            echo "Nom du Tournoi : ".$_SESSION['currentTournoi']['nomTournoi']."";
            

            //On a afficher la liste des equipes qui participent au tournoi dans le sport choisis maintenant il faut créer les rencontres donc afficher les différents binome d'equipe 
            //et rapeler le script jusqua qu'il n'y est plus dequipe à l'etape une et renvoyer les equipe gagnante à l'étape deux-->
        
            //Pour cela on doit prednre la premiere equipe et la deuxieme equipe du tournois pour les inscrire dans un match et le match qu'on inscrira dans le tournoi-->
        
            //on selectionne toutes les equipes qui participe au tournois--> 

            echo "<br/><br/>";
            $nombre = 0;
            foreach($res as $nom){ //$enr tableau de chaque enregistrement
              $nombre = $nombre + 1;
              echo "<li> Equipe$nombre : ".$nom['nomEquipe']." </li>"; //nom un des attributs
            }
            echo "</ul>";//permet de créer une liste

            echo "<form>";
            //BOUTONS-->
            echo "<input type='submit' id='submit' value='AFFICHER LES RENCONTRES' name='afficherencontre' > <br/><br/><br/>";
            echo "</form>";

            //maintenant on vient de lister les equipe on va donc devoir les mettre en binome 
            //donc on va les inscrire dans des matchs donc faut qu'on créer  un script qui va se rapeler jusqu'a il n'y est plus d'equipe
            //on va créer un nouveau bouton qui va etre afficher les rencontres entre les equipes
        }


        if (isset ($_GET['afficherencontre'])){

          $req="SELECT * from Equipe, ParticipEquipe, Sport WHERE id_equipe = idEquipe AND id_sport = sport AND idTournoi = ".(int)$_SESSION['currentTournoi']['id_tournoi']." ;"; //ici on veut une requete mobile avec plusieurs chose après
          //echo $req;
        
          $res = $dbh->query($req); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
        
          if (!$res) die("Impossible d'éxécuter la requête !");
          echo "<ul>";

          echo "<br/><br/>";


          /////////CALCULER LA DATE DE FIN DE TOURNOIS//////////


          //jour
          $jourTournoi1 = $_SESSION['currentTournoi']['dateDebut'][8];
          $jourTournoi2 = $_SESSION['currentTournoi']['dateDebut'][9];

          $jourTournoi = "".$jourTournoi1."".$jourTournoi2."";
          //echo $jourTournoi;

          //mois
          $moisTournoi1 = $_SESSION['currentTournoi']['dateDebut'][5];
          $moisTournoi2 = $_SESSION['currentTournoi']['dateDebut'][6];

          $moisTournoi = "".$moisTournoi1."".$moisTournoi2."";
          //echo $moisTournoi;

          //annee
          $anneeTournoi1 = $_SESSION['currentTournoi']['dateDebut'][0];
          $anneeTournoi2 = $_SESSION['currentTournoi']['dateDebut'][1];
          $anneeTournoi3 = $_SESSION['currentTournoi']['dateDebut'][2];
          $anneeTournoi4 = $_SESSION['currentTournoi']['dateDebut'][3];

          $anneeTournoi = "".$anneeTournoi1."".$anneeTournoi2."".$anneeTournoi3."".$anneeTournoi4."";
          //echo $anneeTournoi;

          $duree = (int)$_SESSION['currentTournoi']['duree'];

          echo "date de debut : ";
          echo $anneeTournoi;
          echo "-";
          echo $moisTournoi;
          echo "-";
          echo $jourTournoi;
          echo "<br/>";

          echo "duree : ";
          echo $duree;
          echo "<br/>";

          //fonction qui me calcul la date en fonction de la durée 
          function differentMois($nb, $moisT, $jourT, $anneeT, $d){
            if ($d == $nb){//si la duree est egale a $nb jours
              if ($moisT+1 > 12){
                date_fin(0, ($moisT+1)-12, $jourT, $anneeT+1);
              }
              else{
                date_fin(0, $moisT+1, $jourT, $anneeT);
              }
            }
            elseif ($d > $nb) {
              //si la longueur du tournoi est de plus de $nb jours on ajoute au mois 1 et on enleve $nb a la duree
              if ($moisT+1 > 12){
                date_fin($d-$nb, ($moisT+1)-12, $jourT, $anneeT+1);
              }
              else{
                date_fin($d-$nb, $moisT+1, $jourT, $anneeT);
              }
            }
            elseif ($d < $nb){//si la duree et plus petite que $nb jours
              if ($moisT > 12){
                date_fin(0, $moisT-12, $jourT+$d, $anneeT+1);
              }
              else{
                date_fin(0, $moisT, $jourT+$d, $anneeT);
              }
            }
          }

          //fonction qui affiche la date de fin du tournoi 
          function date_fin($d, $moisT, $jourT, $anneeT){
            
            if ($d != 0){
              if ($moisT == 1 || $moisT == 3 || $moisT == 5 || $moisT == 7 || $moisT == 8 || $moisT == 10 || $moisT == 12) {
                //si ce sont des mois en 31 jours
                differentMois(31, $moisT, $jourT, $anneeT, $d);
              }
              elseif (($moisT == 4 || $moisT == 6) || ($moisT == 9 || $moisT == 11)){
                //si ce sont des mois en 30 jours
                differentMois(30, $moisT, $jourT, $anneeT, $d);
              }
              elseif ($moisT == 2){  //si le mois est egal à 02 donc le mois de février
                differentMois(28, $moisT, $jourT, $anneeT, $d);                  
              }
            }
            else{
              if ($moisT < 10){
                return $anneeT."-0".$moisT."-".$jourT;
              }
              else{
                return $anneeT."-".$moisT."-".$jourT;
              }
            }
          }

          echo "date de fin : ";
          echo date_fin(2, 03, 12, 2021);
          
          echo "<br/><br/>";
          //jappel ma fonction date_fin() pour obtenir ma date de finS

          //fonction qui donne la date voulu en fonction de la date de debut et de la durée on pourrait utiliser afficher_date_de_fin mais il faut stocker le resultat dans une variable
          
          //echo $anneeT;
          //echo "-0";
          //echo $moisT;
          //echo "-";
          //echo $jourT;



          /////////AFFICHAGE DES RENCONTRES ENTRE LES EQUIPES/////////

          //faut que je fasse match 1 : equipe 1 equipe 2
          //match 2 : equipe 3 equipe 4

          echo "<br/>Rencontre du Tournoi : ";
          echo $_SESSION['currentTournoi']['nomTournoi'];
          echo " avec l'id ";
          echo $_SESSION['currentTournoi']['id_tournoi'];
          echo "<br/><br/>";


          $nombrematch = 0;
          $jour = 0;
          $dateHoraire = "";

          for ($i=0; $i<($_SESSION['currentTournoi']['nbEquipe'] / 2); $i++){
            
            foreach($res as $nom){
              var_dump($nom);
              $jour = $jour + 1;
              echo "<br/><strong>Jour : ";
              echo $jour;
              echo "</strong><br/><br/>";

              $dateHoraire = $dateHoraire.date_fin($jour, $moisTournoi, $jourTournoi, $anneeTournoi)." 14:00:00";
              //echo $dateHoraire;

              /////insertion de base de la RECONTRE///
              $sql = "INSERT INTO Rencontre (dateHoraire, idGagnant, poule, tour_journee) VALUES (NULL, NULL, NULL, $jour);";
              //execution
              $sth = $dbh->prepare($sql);
              $sth->execute();
              if (!$sth) die("Impossible d'éxécuter la requête !");
              echo "<ul>";


              //je vuex recup les info du match en cours
              $infos_match="SELECT * from Rencontre WHERE id_match = LAST_INSERT_ID() ;"; //ici on veut une requete mobile avec plusieurs chose après
              //echo $req;
              $infos = $dbh->prepare($infos_match); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
              $infos->execute();
              if (!$infos) die("Impossible d'éxécuter la requête !");
              //echo "<ul>";
              $match = $infos->fetch();
              //on stocke les infos dans la session
              $_SESSION ['currentMatch'] = $match;
              var_dump($_SESSION ['currentMatch']);


              echo "<li> Match".($nombrematch+$i+1)." : </li>";
              echo "<ul> Equipe 1 : ".$nom['nomEquipe']." </ul>"; //nom un des attributs

              foreach($res as $nom2){
                var_dump($nom2);
                echo "<ul> Equipe 2 : ".$nom2['nomEquipe']." </ul>"; //nom un des attributs
                
                //insertion de table LISTEEQUIPE pour lier les match avec les equipes et attribuer les score à chacun
	              //PREMIERE EQUIPE
                $sql = "INSERT INTO ListeEquipe (idMatch, idEquipe, score) VALUES (".$_SESSION ['currentMatch']['id_match'].", ".$nom['id_equipe'].", NULL);";
                //execution
                $sth = $dbh->prepare($sql);
                $sth->execute();
                //DEUXIEME EQUIPE
                $sql = "INSERT INTO ListeEquipe (idMatch, idEquipe, score) VALUES (".$_SESSION['currentMatch']['id_match'].", ".$nom2['id_equipe'].", NULL);";
                //execution
                $sth = $dbh->prepare($sql);
                $sth->execute();

                //insertion dans PARTICIPMATCH les liens des matchs avec les tournois
                $sql2 = "INSERT INTO ParticipMatch (idMatch, idTournoi) VALUES (".$_SESSION['currentMatch']['id_match'].", ".$_SESSION['currentTournoi']['id_tournoi'].");";
                //execution
                $sth2 = $dbh->prepare($sql2);
                $sth2->execute();
                break;
              }
              $nombrematch = $nombrematch + 1;
            }
            $dateHoraire = "";
          }


          $date_debut_tournoi = $_SESSION['currentTournoi']['dateDebut'];
        }

    ?>


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