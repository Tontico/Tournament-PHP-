<<<<<<< HEAD
<?php
  session_start();

  function scheduler($team,$shuffle=0,$reverse=0) { // on créé la fonction avec en param les équipes, le mélange et le reverse 
    if (count($team)%2 != 0){//si le nbre déquipe n'est pas pair 
      die("impossible d'éxécuter la requête ! Il vous faut un nombre d'équipe pair pour commencer le championnat !");//on push le tableau et cela ne marche pas 
    }
    if ($shuffle == 1){//si shuffle == 1 alors chaque tournoi généré aura un ordre aléatoire
        shuffle($team);//mélange les éléments du tableau
    }
    $exte = array_splice($team,(count($team)/2));//on efface une partie du tableau pr prendre que les equipes exterieur 
    $dom = $team;
    for ($i=0; $i < count($dom)+count($exte)-1; $i++){//premiere boucle 
        for ($j=0; $j<count($dom); $j++){//deuxieme boucle 
            if (($i%2 !=0) && ($j%2 ==0)){ // si i n'est pas pair et et j est pair 
                $schedule[$i][$j]["Home"]=$exte[$j];//alors exterieur joue a domicile 
                $schedule[$i][$j]["Away"]=$dom[$j];//domicile joue a l'exterieur 
            } else {
                $schedule[$i][$j]["Home"]=$dom[$j];//sinn l'inverse 
                $schedule[$i][$j]["Away"]=$exte[$j]; 
            }
        }
        if(count($dom)+count($exte)-1 > 2){//si le nbre d'équipe et le nbre d'équipe a exté -1 est > 2 
          $tmpArray = array_splice($dom,1,1);// on passe par réference on efface et on remplace 
          $Array = array_shift($tmpArray);//on enleve l'equipe de trop et on la place dans la var
            array_unshift($exte,$Array);// on empile le array de exte et celui de $array
          array_push($dom,array_pop($exte));
        }
    }
    if ($reverse == 1){//si reverse ==1 alors on inverse dom et exte au debut 
        for ($k=0; $k < count($dom)+count($exte)-1; $k++){
            for ($j=0; $j<count($dom); $j++){
                if (($k%2 !=0) && ($j%2 ==0)){
                    $schedule[$i][$j]["Home"]=$dom[$j];
                    $schedule[$i][$j]["Away"]=$exte[$j];
                } else {
                    $schedule[$i][$j]["Home"]=$exte[$j];
                    $schedule[$i][$j]["Away"]=$dom[$j]; 
                }
            }
        if(count($dom)+count($exte)-1 > 2){
          $tmpArray = array_splice($dom,1,1);
          $string = array_shift($tmpArray);
            array_unshift($exte,$string);
            array_push($dom,array_pop($exte));
        }
        $i++;
        }
    }
    return $schedule;
  }
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

?>

<html>
  <head>
  <title> Rencontre</title>
  </head>
  
  <body>
    <?php
      $dsn = "mysql:host=localhost;dbname=sports";  /* Data Source Name */
      $username = "root"; $password = "";
      $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
      $dbh = new PDO($dsn, $username, $password, $options) or die("Pb de connexion !");
    ?>

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
        $sql = "SELECT idSport, idUtilisateur, nomSport FROM sportutilisateur, sport WHERE idSport = id_sport AND idUtilisateur = $idUser;";
    ?>
    <form>
        <strong>Choisissez un sport</strong><br/><br/>
        <select name="id" id="sport" >

        <?php
            $sport = $dbh->query("SELECT idSport, idUtilisateur, nomSport, nbjoueur FROM sportutilisateur, sport WHERE idSport = id_sport AND idUtilisateur = $idUser;");
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
        //var_dump($_SESSION['currentTournoi']);

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

      if (isset($_GET['afficherencontre'])) { //on va afficher les matchs

        $idT = (int)$_SESSION['currentTournoi']['id_tournoi']; //id du tournoi courant

        // On va chercher en base si les rencontres ont déjà été calculées
       /* $sql = "SELECT * FROM Rencontre WHERE id_tournoi = $idT;";
        $sth = $dbh->query($sql);
        if (!$sth) {
          die("impossible d'éxécuter la requête !");
        }
        $rencontres = $sth->fetchAll();*/

        $req="SELECT * from Equipe, ParticipEquipe, Sport WHERE id_equipe = idEquipe AND id_sport = sport AND idTournoi = ".(int)$_SESSION['currentTournoi']['id_tournoi']." ;"; //ici on veut une requete mobile avec plusieurs chose après
        //echo $req;
      
        $res = $dbh->query($req); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
      
        if (!$res) die("Impossible d'éxécuter la requête !");
        echo "<ul>";

        echo "<br/><br/>";

        // Si on ne trouve pas de match en BDD pour ce tournoi, on génère le planning et on l'insère en base, puis on relit la base une seconde fois
        //if (empty($rencontres)) {
          //On stocke le nom des équipes 
          //on recup ensuite la colone contenant le nom des équipes 
          $idsEquipes = $res->fetchAll(PDO::FETCH_COLUMN, 0);
            var_dump($idsEquipes);
  
          $teams = [];
          foreach ($idsEquipes as $idEquipe) { //on parcours les equipes pour recuperer leurs nom
            //var_dump($idEquipe);
            $sql = "SELECT id_equipe FROM Equipe WHERE id_equipe = $idEquipe;";
            
            $sth = $dbh->query($sql);
          
            if (!$sth) {
              die("impossible d'éxécuter la requête !");
            }
            $teams[$idEquipe] = $sth->fetchColumn(0);
            //var_dump($idEquipes);
            var_dump( $teams[$idEquipe]);
            //var_dump($idEquipe); 
          }
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

          //teams contient donc lassociation des idequipe et de leurs nom
   
          // on place les equipes dans le tournoi
          //si le tournoi est open
          if (empty ($teams)){
            throw new \Exception ('Il vous faut au moins 1 équipe !');
          }
           

          $idT = (int)$_SESSION['currentTournoi']['id_tournoi']; //id du tournoi courant
          // on appelle la fonction avec le reverse activé (aller retour)
         
          $schedule = scheduler($teams,1,1);//on appelle la fonction dans une var
          //var_dump($schedule);
          //var_dump($teams);
         // $schedule = scheduler($teams,1,1);//on appelle la fonction dans une var
          // boucle permettant d'afficher les match programmé
          
              foreach($schedule AS $rounds => $games){
               //var_dump($games);
                $round = $rounds+1;
                echo "Journée $round"."<br>";
                $sql = "INSERT INTO Rencontre (dateHoraire, idGagnant, poule, tour_journee) VALUES (NULL, NULL, NULL, ".$round.");";
                //var_dump($sql);
                $sth = $dbh->prepare($sql);
                $sth->execute();
                if (!$sth) {
                  die("impossible d'éxécuter la requête !");
                }
                
               foreach ($games as $play1){
                $infos_match="SELECT * from Rencontre WHERE id_match = LAST_INSERT_ID();"; //ici on veut une requete mobile avec plusieurs chose après
                //echo $req;
                $infos = $dbh->query($infos_match); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
                
                if (!$infos) die("Impossible d'éxécuter la requête !");
                //echo "<ul>";
                $match = $infos->fetch();
                //on stocke les infos dans la session
                $_SESSION ['currentMatch'] = $match;
                //var_dump($_SESSION ['currentMatch']);
               foreach($play1 as $play2){
                $sql = "SELECT id_equipe FROM Equipe WHERE nomEquipe = '$play2'";
                //var_dump($sql);
                $sth = $dbh->query($sql);
                //var_dump($sql);
                var_dump($sth);
                if (!$sth) {
                  die("impossible d'éxécuter la requête !");
                
                }
              }
              
               // var_dump($play1);
                //var_dump($play2);
               
               
              
                    //var_dump($teams);
                    
                  $home = $play1["Home"];
                   //var_dump($home);
                  
                  
                  
                    //var_dump($play1);
                  
                  $away = $play1 ["Away"];
                  
                  //var_dump($aways);
                  echo "$home vs $away"."<br>";
                  $sql = "INSERT INTO ListeEquipe (idMatch, idEquipe, score) VALUES (".$_SESSION ['currentMatch']['id_match'].", ".$home[$idEquipe].", NULL);";
                  $sth = $dbh->prepare($sql);
                  $sth->execute();
                  //var_dump($sth);
               
                  $sql = "INSERT INTO ListeEquipe (idMatch, idEquipe, score) VALUES (".$_SESSION['currentMatch']['id_match'].", ".$away.", NULL);";
                  //execution
                  $sth = $dbh->prepare($sql);
                  $sth->execute();

                  //insertion dans PARTICIPMATCH les liens des matchs avec les tournois
                   $sql2 = "INSERT INTO ParticipMatch (idMatch, idTournoi) VALUES (".$_SESSION['currentMatch']['id_match'].", ".$_SESSION['currentTournoi']['id_tournoi'].");";
                    //execution
                      $sth2 = $dbh->prepare($sql2);
                       $sth2->execute();   

                        //echo iplode("-",$play1)."<BR>";// permet de creer la chaine equipe1 vs equipe2
              
            
                  }
                
              }
            
       }
      
      
    
      //$idEquipes = array_unique(array_merge(array_column($rencontres, ), array_column($rencontres, 'id_teamB')));

      /*$sql = "SELECT id_equipe, nomEquipe FROM equipe WHERE id_equipe IN (".implode(',', $idEquipes).");";
      $sth = $dbh->query($sql);
      if (!$sth) {
        die("impossible d'éxécuter la requête !");
      }
      $nomsEquipes = $sth->fetchAll(PDO::FETCH_KEY_PAIR);
      foreach ($rencontres as $rencontre) {
        echo "Journee ".$rencontre['tour_journee'].": ".$nomsEquipes[$rencontre['id_teamA']]." vs ".$nomsEquipes[$rencontre['id_teamB']]."<br />";
      }
*/
    
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


    <!-- On affiche le lien de déconnexion que si l'utilisateur est connecté.-->
    <button><a href="logout.php">Logout</a></button>

  </footer>

=======
<?php
  session_start();

  function scheduler($team,$shuffle=0,$reverse=0) { // on créé la fonction avec en param les équipes, le mélange et le reverse 
    if (count($team)%2 != 0){//si le nbre déquipe n'est pas pair 
      die("impossible d'éxécuter la requête ! Il vous faut un nombre d'équipe pair pour commencer le championnat !");//on push le tableau et cela ne marche pas 
    }
    if ($shuffle == 1){//si shuffle == 1 alors chaque tournoi généré aura un ordre aléatoire
        shuffle($team);//mélange les éléments du tableau
    }
    $exte = array_splice($team,(count($team)/2));//on efface une partie du tableau pr prendre que les equipes exterieur 
    $dom = $team;
    for ($i=0; $i < count($dom)+count($exte)-1; $i++){//premiere boucle 
        for ($j=0; $j<count($dom); $j++){//deuxieme boucle 
            if (($i%2 !=0) && ($j%2 ==0)){ // si i n'est pas pair et et j est pair 
                $schedule[$i][$j]["Home"]=$exte[$j];//alors exterieur joue a domicile 
                $schedule[$i][$j]["Away"]=$dom[$j];//domicile joue a l'exterieur 
            } else {
                $schedule[$i][$j]["Home"]=$dom[$j];//sinn l'inverse 
                $schedule[$i][$j]["Away"]=$exte[$j]; 
            }
        }
        if(count($dom)+count($exte)-1 > 2){//si le nbre d'équipe et le nbre d'équipe a exté -1 est > 2 
          $tmpArray = array_splice($dom,1,1);// on passe par réference on efface et on remplace 
          $Array = array_shift($tmpArray);//on enleve l'equipe de trop et on la place dans la var
            array_unshift($exte,$Array);// on empile le array de exte et celui de $array
          array_push($dom,array_pop($exte));
        }
    }
    if ($reverse == 1){//si reverse ==1 alors on inverse dom et exte au debut 
        for ($k=0; $k < count($dom)+count($exte)-1; $k++){
            for ($j=0; $j<count($dom); $j++){
                if (($k%2 !=0) && ($j%2 ==0)){
                    $schedule[$i][$j]["Home"]=$dom[$j];
                    $schedule[$i][$j]["Away"]=$exte[$j];
                } else {
                    $schedule[$i][$j]["Home"]=$exte[$j];
                    $schedule[$i][$j]["Away"]=$dom[$j]; 
                }
            }
        if(count($dom)+count($exte)-1 > 2){
          $tmpArray = array_splice($dom,1,1);
          $string = array_shift($tmpArray);
            array_unshift($exte,$string);
            array_push($dom,array_pop($exte));
        }
        $i++;
        }
    }
    return $schedule;
  }
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

?>

<html>
  <head>
  <title> Rencontre</title>
  </head>
  
  <body>
    <?php
      $dsn = "mysql:host=localhost;dbname=sports";  /* Data Source Name */
      $username = "root"; $password = "";
      $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
      $dbh = new PDO($dsn, $username, $password, $options) or die("Pb de connexion !");
    ?>

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
        $sql = "SELECT idSport, idUtilisateur, nomSport FROM sportutilisateur, sport WHERE idSport = id_sport AND idUtilisateur = $idUser;";
    ?>
    <form>
        <strong>Choisissez un sport</strong><br/><br/>
        <select name="id" id="sport" >

        <?php
            $sport = $dbh->query("SELECT idSport, idUtilisateur, nomSport, nbjoueur FROM sportutilisateur, sport WHERE idSport = id_sport AND idUtilisateur = $idUser;");
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
        //var_dump($_SESSION['currentTournoi']);

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

      if (isset($_GET['afficherencontre'])) { //on va afficher les matchs

        $idT = (int)$_SESSION['currentTournoi']['id_tournoi']; //id du tournoi courant

        // On va chercher en base si les rencontres ont déjà été calculées
       /* $sql = "SELECT * FROM Rencontre WHERE id_tournoi = $idT;";
        $sth = $dbh->query($sql);
        if (!$sth) {
          die("impossible d'éxécuter la requête !");
        }
        $rencontres = $sth->fetchAll();*/

        $req="SELECT * from Equipe, ParticipEquipe, Sport WHERE id_equipe = idEquipe AND id_sport = sport AND idTournoi = ".(int)$_SESSION['currentTournoi']['id_tournoi']." ;"; //ici on veut une requete mobile avec plusieurs chose après
        //echo $req;
      
        $res = $dbh->query($req); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
      
        if (!$res) die("Impossible d'éxécuter la requête !");
        echo "<ul>";

        echo "<br/><br/>";

        // Si on ne trouve pas de match en BDD pour ce tournoi, on génère le planning et on l'insère en base, puis on relit la base une seconde fois
        //if (empty($rencontres)) {
          //On stocke le nom des équipes 
          //on recup ensuite la colone contenant le nom des équipes 
          $idsEquipes = $res->fetchAll(PDO::FETCH_COLUMN, 0);
            var_dump($idsEquipes);
  
          $teams = [];
          foreach ($idsEquipes as $idEquipe) { //on parcours les equipes pour recuperer leurs nom
            //var_dump($idEquipe);
            $sql = "SELECT id_equipe FROM Equipe WHERE id_equipe = $idEquipe;";
            
            $sth = $dbh->query($sql);
          
            if (!$sth) {
              die("impossible d'éxécuter la requête !");
            }
            $teams[$idEquipe] = $sth->fetchColumn(0);
            //var_dump($idEquipes);
            var_dump( $teams[$idEquipe]);
            //var_dump($idEquipe); 
          }
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

          //teams contient donc lassociation des idequipe et de leurs nom
   
          // on place les equipes dans le tournoi
          //si le tournoi est open
          if (empty ($teams)){
            throw new \Exception ('Il vous faut au moins 1 équipe !');
          }
           

          $idT = (int)$_SESSION['currentTournoi']['id_tournoi']; //id du tournoi courant
          // on appelle la fonction avec le reverse activé (aller retour)
         
          $schedule = scheduler($teams,1,1);//on appelle la fonction dans une var
          //var_dump($schedule);
          //var_dump($teams);
         // $schedule = scheduler($teams,1,1);//on appelle la fonction dans une var
          // boucle permettant d'afficher les match programmé
          
              foreach($schedule AS $rounds => $games){
               //var_dump($games);
                $round = $rounds+1;
                echo "Journée $round"."<br>";
                $sql = "INSERT INTO Rencontre (dateHoraire, idGagnant, poule, tour_journee) VALUES (NULL, NULL, NULL, ".$round.");";
                //var_dump($sql);
                $sth = $dbh->prepare($sql);
                $sth->execute();
                if (!$sth) {
                  die("impossible d'éxécuter la requête !");
                }
                
               foreach ($games as $play1){
                $infos_match="SELECT * from Rencontre WHERE id_match = LAST_INSERT_ID();"; //ici on veut une requete mobile avec plusieurs chose après
                //echo $req;
                $infos = $dbh->query($infos_match); //dbh objet contient linfo pour se co au gbd || soit liste des argument soit rien si erreur ou table vide
                
                if (!$infos) die("Impossible d'éxécuter la requête !");
                //echo "<ul>";
                $match = $infos->fetch();
                //on stocke les infos dans la session
                $_SESSION ['currentMatch'] = $match;
                //var_dump($_SESSION ['currentMatch']);
               foreach($play1 as $play2){
                $sql = "SELECT id_equipe FROM Equipe WHERE nomEquipe = '$play2'";
                //var_dump($sql);
                $sth = $dbh->query($sql);
                //var_dump($sql);
                var_dump($sth);
                if (!$sth) {
                  die("impossible d'éxécuter la requête !");
                
                }
              }
              
               // var_dump($play1);
                //var_dump($play2);
               
               
              
                    //var_dump($teams);
                    
                  $home = $play1["Home"];
                   //var_dump($home);
                  
                  
                  
                    //var_dump($play1);
                  
                  $away = $play1 ["Away"];
                  
                  //var_dump($aways);
                  echo "$home vs $away"."<br>";
                  $sql = "INSERT INTO ListeEquipe (idMatch, idEquipe, score) VALUES (".$_SESSION ['currentMatch']['id_match'].", ".$home[$idEquipe].", NULL);";
                  $sth = $dbh->prepare($sql);
                  $sth->execute();
                  //var_dump($sth);
               
                  $sql = "INSERT INTO ListeEquipe (idMatch, idEquipe, score) VALUES (".$_SESSION['currentMatch']['id_match'].", ".$away.", NULL);";
                  //execution
                  $sth = $dbh->prepare($sql);
                  $sth->execute();

                  //insertion dans PARTICIPMATCH les liens des matchs avec les tournois
                   $sql2 = "INSERT INTO ParticipMatch (idMatch, idTournoi) VALUES (".$_SESSION['currentMatch']['id_match'].", ".$_SESSION['currentTournoi']['id_tournoi'].");";
                    //execution
                      $sth2 = $dbh->prepare($sql2);
                       $sth2->execute();   

                        //echo iplode("-",$play1)."<BR>";// permet de creer la chaine equipe1 vs equipe2
              
            
                  }
                
              }
            
       }
      
      
    
      //$idEquipes = array_unique(array_merge(array_column($rencontres, ), array_column($rencontres, 'id_teamB')));

      /*$sql = "SELECT id_equipe, nomEquipe FROM equipe WHERE id_equipe IN (".implode(',', $idEquipes).");";
      $sth = $dbh->query($sql);
      if (!$sth) {
        die("impossible d'éxécuter la requête !");
      }
      $nomsEquipes = $sth->fetchAll(PDO::FETCH_KEY_PAIR);
      foreach ($rencontres as $rencontre) {
        echo "Journee ".$rencontre['tour_journee'].": ".$nomsEquipes[$rencontre['id_teamA']]." vs ".$nomsEquipes[$rencontre['id_teamB']]."<br />";
      }
*/
    
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


    <!-- On affiche le lien de déconnexion que si l'utilisateur est connecté.-->
    <button><a href="logout.php">Logout</a></button>

  </footer>

>>>>>>> 3851daa9fbccf851b12ac4153978a9c8e82ff043
</html>