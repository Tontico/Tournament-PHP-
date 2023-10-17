<?php
  session_start();
?>

<html>
  <head>
  <title> Accueil</title>
  <script>
    function Afficher()
    {
      var input = document.getElementById("motdepasse");
      if (input.type === "password")
      {
        input.type = "text";
      }
      else
      {
        input.type = "password";
      }
    }

    function Afficher2(){
        //pour l'inscription 
        var input2 = document.getElementById("mdpuse"); 
        if (input2.type === "password")
        { 
          input2.type = "text"; 
        } 
        else
        { 
          input2.type = "password"; 
        } 
      }

      function Afficher3(){
        //pour la confirmation de l'inscription
        var input3 = document.getElementById("mdpconf"); 
        if (input3.type === "password")
        { 
          input3.type = "text"; 
        } 
        else
        { 
          input3.type = "password"; 
        } 
      } 
  </script>
  </head>


  <body>
    <?php
      $dsn = "mysql:host=localhost;dbname=sports";  /* Data Source Name */
      $username = "root"; $password = "";
      $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
      $dbh = new PDO($dsn, $username, $password, $options) or die("Pb de connexion !");8
    ?>


    <?php
      // Inscription
      if (isset($_GET['Inscription'])) {
        // TODO: Verifier si il existe déjà en base un utilisateur avec $_GET['adresseUtilisateur'] comme email (requête similaire a la connexion mais sans MDP)

        //insertion de base de l'inscription
	      $sql = "INSERT INTO Utilisateur (adresseMail, nomUtilisateur, prenomUtilisateur, motDePasse) VALUES ('".$_GET['adresseUtilisateur']."','".$_GET['nomUtilisateur']."','".$_GET['prenomUtilisateur']."','".$_GET['motdepasseUtilisateur']."');";
        //execution
        $sth = $dbh->prepare($sql);
        $sth->execute();

        //selection de l'identificateur du mail de la personne qui vient de sinscrire
        $iduse = "SELECT id_utilisateur FROM Utilisateur WHERE adresseMail = '".$_GET['adresseUtilisateur']."' LIMIT 1;";
        //execution
        $sth = $dbh->query($iduse);
        //si la requete existe
        if (!$sth) die("Impossible d'éxécuter la requête !");
        //on stocke l'identificateur
        // On recupere la premiere colonne retournée par PDO, qui est la colonne contenant 'id_utilisateur'
        $idUtilisateur = $sth->fetchColumn(0);

        $roles = $_GET['roles'];
        // Si aucun role choisi, on envoi une erreur fatale.
        if (empty($roles)) {
          throw new \Exception('Vous devez choisir au moins un role !');
        }

        // On parcours la liste des roles demandées, avec $role => le role en cours et on insère chaque entrée une a une dans la table RoleUtilisateur
        foreach ($roles as $role) {
          $sql = "INSERT INTO RoleUtilisateur (idUtilisateur, idRole) VALUES ('$idUtilisateur','$role');";
          $sth = $dbh->prepare($sql);
          $sth->execute();
        }

        $sports = $_GET['sports'];
        // Si aucun sport choisi, on envoi une erreur fatale.
        if (empty($sports)) {
          throw new \Exception('Vous devez choisir au moins un sport !');
        }

        foreach ($sports as $sport) {
          $sql = "INSERT INTO SportUtilisateur (idUtilisateur, idSport) VALUES ('$idUtilisateur','$sport')";
          $sth = $dbh->prepare($sql);
          $sth->execute();
        }

      }

       //Connexion
      if (isset($_GET['Connexion'])) {
        $email = $_GET['mailUtilisateur'];
        $password = $_GET['mdpUtilisateur'];

        // On écrit la requete pour trouver l'utilisateur par son login & mdp
        $sql = "SELECT * FROM Utilisateur WHERE (adresseMail = '$email' AND motDePasse = '$password')";
        // On prépare et execute la requete
        $sth = $dbh->prepare($sql);
        $sth->execute();

        /* On recupère le retour de la requête executée qui ressemblera a ça :
        $utilisateur = [
          'id_utilisateur' => '22',
          'adresseMail' => 'antho.noex@live.fr',
          'nomUtilisateur' => 'Anhony',
          'prenomUtilisateur' => 'Suraci',
          'motDePasse' => 'bbb',
        ]
        */
        $utilisateur = $sth->fetch();

        // Si $utilisateur est false, la BDD n'a trouvé aucun résultat pour $email & $password
        if ($utilisateur === false) {
          echo "L'adresse mail ou le mot de passe est incorrect. Recommencez";
        } 
        
        else { // Sinon, $utilisateur est un tableau, et donc, l'utilisateur est valide
          //pour le role
          $sqlrole = "SELECT idRole FROM roleutilisateur WHERE idUtilisateur = '".$utilisateur['id_utilisateur']."' AND '".$email."' = '".$utilisateur['adresseMail']."';";

          $sthrole2 = $dbh->prepare($sqlrole);
          $sthrole2->execute();

          $_SESSION['utilisateur'] = $utilisateur;
          $_SESSION['currentRole'] = array ();

          foreach ($sthrole2 as $att2){
            $sqlrole2 = "SELECT nomRole FROM role WHERE id_role = '".$att2['idRole']."';";
            $sth3role = $dbh->prepare($sqlrole2);

            $sth3role->execute();

            foreach ($sth3role as $att3){
              array_push($_SESSION['currentRole'], $att3['nomRole']);
            }
          }

          //pour le sport
          $sqlsport = "SELECT idSport FROM sportUtilisateur WHERE idUtilisateur = '".$utilisateur['id_utilisateur']."';";
          echo $sqlsport;
          $sthsport2 = $dbh->prepare($sqlsport);
          $sthsport2->execute();

          $_SESSION['currentSport'] = array();

          foreach ($sthsport2 as $att3){
            $sqlsport3 = "SELECT nomSport FROM Sport WHERE id_sport = '".$att3['idSport']."';";
            echo $sqlsport3;
            $sthsport4 = $dbh->prepare($sqlsport3);

            $sthsport4->execute();

            foreach ($sthsport4 as $att4){
              array_push($_SESSION['currentSport'], $att4['nomSport']);
              
            }
          }

          header("Location: Menu_def.php");
        }
      }

    ?>

    <h1 align="center">Accueil </h1>

    <fieldset> <!--pour mettre un cadre autour-->

      <form><!--formulaire de saisie-->

        <legend><strong><pre><h3><FONT face="Times New Roman"><p STYLE="padding:0 0 0 50px;">CONNEXION</FONT></h3></pre></strong></legend><br/>

        <!--MAIL-->
        <label><strong>Adresse Mail</strong></label><br/><br/>
        <input type="text" name="mailUtilisateur" placeholder="Entrez un mail... "  required/><br/><br/><br/>

        <!--MOT DE PASSE-->
        <strong>Mot de Passe</strong><br/><br/>
        <input type="password" name="mdpUtilisateur" placeholder="Entrez un mot de passe... "  id = "motdepasse" required/>
        <input type="checkbox" onclick="Afficher()"> Afficher le mot de passe  <br/><br/><br/>

        <input type="reset" value="EFFACER" name="EffacerEntrees">
        <input type="submit" value="CONNEXION" name="Connexion" />

      </form>

    </fieldset>

    <br/>
    <h3 align="center">OU</h3>
    <br/>


    </fieldset>


    <fieldset> <!--pour mettre un cadre autour-->

      <form><!--formulaire de saisie-->

        <!--INSCRIPTION-->
        <legend><strong><pre><h3><FONT face="Times New Roman"><p STYLE="padding:0 0 0 50px;">INSCRIPTION</FONT></h3></pre></strong></legend><br/>

        <!--NOM-->
        <label><strong>Nom de l'utilisateur</strong></label><br/><br/>
        <input type="text" name="nomUtilisateur" placeholder="Entrez un Nom en majuscule... " required/><br/><br/><br/>

        <!--PRENOM-->
        <strong>Prenom de l'utilisateur</strong><br/><br/>
        <input type="text" name="prenomUtilisateur" placeholder="Entrez un Prenom... " required/> <br/><br/><br/>

        <!--MAIL-->
        <strong>Adresse Mail</strong> <br/><br/>
        <input type="email" name="adresseUtilisateur" placeholder="Entrez une adresse mail... " required/><br/><br/><br/>

        <!--MOT DE PASSE-->
        <strong>Mot de Passe</strong><br/><br/>
        <input type="password" name="motdepasseUtilisateur" placeholder="Entrez un mot de passe... " id="mdpuse" required/>
        <input type="checkbox" onclick="Afficher2()"> Afficher le mot de passe<br/><br/><br/>

        <!--CONFIRMATION MOT DE PASSE-->
        <strong>Confirmation du Mot de Passe</strong><br/><br/>
        <input type="password" name="confmotdepasseUtilisateur" placeholder="Entrez un mot de passe... " id="mdpconf" required/>
        <input type="checkbox" onclick="Afficher3()"> Afficher le mot de passe<br/><br/><br/>

        <!--ROLES-->
        <strong>Vos roles</strong><br/><br/>
        <!-- Pour avoir un select multiple il faut ajouter [] dans le name="" -->
        <select name='roles[]' id="role" multiple>

          <?php

            $role = $dbh->query("SELECT id_role, nomRole FROM Role");

            foreach ($role as $rl)
            {
              echo '<option id="role" value="'.$rl['id_role'].'">'.$rl['nomRole'].'</option>';
            }

          ?>

        </select><br/><br/><br/>

        <!--SPORTS-->
        <strong>Vos sports</strong><br/><br/>
        <!-- Pour avoir un select multiple il faut ajouter [] dans le name="" -->
        <select name="sports[]" id="sport" multiple>

          <?php

            $sport = $dbh->query("SELECT id_sport, nomSport FROM Sport");

            foreach ($sport as $spt)
            {
              echo '<option id="sport" value="'.$spt['id_sport'].'">'.$spt['nomSport'].'</option>';
            }

          ?>

        </select><br/><br/><br/>

        <!--BOUTONS-->
        <input type="reset" value="EFFACER" name="EffacerEntrees">
        <input type="submit" value="INSCRIPTION" name="Inscription" />


      </form>

    </fieldset>

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

</html>
