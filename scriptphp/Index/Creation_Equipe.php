<<<<<<< HEAD
<?php
  session_start();
?>

<!doctype html>
<html>
  <head> 
    <title> Creation de l'Equipe</title>
    
    <style>

    </style>

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


    <h1 align="center">Creation de l'Equipe </h1>
    <br/><br/>
    <form><p STYLE="padding:0 0 0 10px;"> <button type="submit" name="Retourmenu" >Retour au menu</button> </form><br/>
    <?php
      if (isset($_GET['Retourmenu'])){
        header("Location: menudef.php");
      }
    ?>
     
    <fieldset> <!--pour mettre un cadre autour-->

      <form method="get">
  
        <!--VOTRE EQUIPE-->
        <legend><strong><pre><h3><FONT face="Times New Roman"><p STYLE="padding:0 0 0 50px;">VOTRE EQUIPE</FONT></h3></pre></strong></legend><br/>

        <!--NOM-->
        <label><strong>Nom de l'equipe</strong></label><br/><br/>  
        <input type="text" name="nomequipe" value="<?php if (isset ($_GET['nomequipe'])){echo $_GET['nomequipe']; }?>" placeholder = "Entrez un Nom..." /><br/><br/><br/>

        <!--Capitaine-->
        <label><strong>id capitaine</strong></label><br/><br/>  
        <input type="hidden" name="idCapitaine"  value="<?php if (isset ($_SESSION['utilisateur']['id_utilisateur'])){echo (int)$_SESSION['utilisateur']['id_utilisateur'];} ?>" /> <?php echo (int)$_SESSION['utilisateur']['id_utilisateur'];?> <br/><br/><br/>

        <!--NIVEAU-->
        <strong>Niveau de l'equipe</strong><br/><br/>
        <input type="number" max= "10" min="1" name="niveau" value="<?php if (isset ($_GET['niveau'])){echo $_GET['niveau']; }?>" placeholder = "Niveau.." /><br/><br/><br/>

        <!--MAIL-->
        <strong>Adresse Mail</strong> <br/><br/>
        <input type="email" name="adresseMail"  value="<?php if (isset ($_GET['adresseMail'])){echo $_GET['adresseMail']; }?>" placeholder = "Entrez une Adresse Mail.." /><br/><br/><br/>

        <!--NUM-->
        <strong>Numero de telephone</strong><br/><br/>
        <input type="number" name="numeroTel" value="<?php if (isset ($_GET['numeroTel'])){echo $_GET['numeroTel'];} ?>" placeholder = "Entrez un numero.." /><br/><br/><br/>
        
        <!--Sport pour les infor generales-->
        <strong>Votre sport</strong><br/><br/>
        
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
       
        </select><br/><br/><br/>


        <!--BOUTONS-->
        <input type="reset" value="REINITIALISER" name="EffacerEntrees"> 
        <input type="submit" id="submit" value="VALIDATION DES INFORMATIONS GENERALES" name="creerEquipe" > <br/><br/><br/>


      </form> 

    

      <?php


        //on voudra recuperer les valeurs de l'adresse mail et le sport de l'equipe
        $sport = ' ';


        if (isset ($_GET['creerEquipe']) ){

          $adresseMail = $_GET['adresseMail'];
          $sport = $sport + $_GET['idsport'];

      ?>

        <form>
          <!--Sport pour les infos generales-->

          <?php
          $idUser = (int)$_SESSION['utilisateur']['id_utilisateur'];
          $sql = "SELECT idSport, idUtilisateur, nomSport FROM SportUtilisateur, Sport WHERE idSport = id_sport AND idUtilisateur = $idUser;";
          ?>

          <strong>Remettez votre sport</strong><br/><br/>
          <select name="idsport" id="sport" onchange="window.frames[0].location='liste_membre_equipe.php?idsport='+this.value+'&adresseMail='+this.$adresseMail+'&idCapitaine='+this.$capitaine">

            <?php
              $sport = $dbh->query("SELECT idSport, idUtilisateur, nomSport, nbjoueur FROM SportUtilisateur, Sport WHERE idSport = id_sport AND idUtilisateur = $idUser;");
              $sport->execute();
              echo '<option value="val0">choisissez un sport</option>';

              foreach ($sport as $spt)
              {
                echo '<option id="sport" value="'.$spt['idSport'].'">'.$spt['nomSport'].'</option>';
              }
              $adresseMail = $_GET['adresseMail'];
              $capitaine = $_GET['idCapitaine'];
            ?>

          </select><br/><br/><br/>

          <iframe style="width: 100%; border: 0"></iframe>

        </form>

      <?php

          //INFORMATION GENERALES::

          $sql = "INSERT INTO Equipe (nomEquipe, niveau, adresseMail, numeroTel, idCapitaine, sport) VALUES ('".$_GET['nomequipe']."','".$_GET['niveau']."','".$_GET['adresseMail']."','".$_GET['numeroTel']."','".$_GET['idCapitaine']."','".$_GET['idsport']."');";
          $sth = $dbh->prepare($sql);
          $sth->execute();
      
        }//fin du isset

        //INSCRIPTION DES MEMBRES////

        if (isset ($_GET['listejoueurs'])){


          $sport = $dbh->query("SELECT id_sport, nomSport, nbjoueur FROM Sport;");
          $sport->execute();          
  

          //on commence par calculer le max des id créer c'est a dire la derniere equipe qui vient d'etre créé
          $id = $dbh->query("SELECT MAX(id_equipe) FROM Equipe;"); //l'equipe qu'on vient de créer est la derniere
          $idequipe = $id->fetchColumn(0);


          //on ajoute le capitaine à l'equipe
          $cap = "INSERT INTO membreEquipe (idUtilisateur, idEquipe) VALUES (".(int)$_SESSION['utilisateur']['id_utilisateur'].", ".(int)$idequipe.");";
          if (!$cap) die("Impossible d'executer la requête !");
          $sthcap = $dbh->prepare($cap);
          $sthcap->execute();

          //puis les membres
          foreach ($_GET['joueur'] as $idjoueur) {
            $membre = "INSERT INTO membreEquipe (idUtilisateur, idEquipe) VALUES (".(int)$idjoueur.", ".(int)$idequipe.");";
            if (!$membre) die("Impossible d'executer la requête !");
            $sthmembre = $dbh->prepare($membre);
            $sthmembre->execute();
          }

          echo "Votre equipe vient d'etre creer !";
        }
      
      ?>

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

<!doctype html>
<html>
  <head> 
    <title> Creation de l'Equipe</title>
    
    <style>

    </style>

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


    <h1 align="center">Creation de l'Equipe </h1>
    <br/><br/>
    <form><p STYLE="padding:0 0 0 10px;"> <button type="submit" name="Retourmenu" >Retour au menu</button> </form><br/>
    <?php
      if (isset($_GET['Retourmenu'])){
        header("Location: menudef.php");
      }
    ?>
     
    <fieldset> <!--pour mettre un cadre autour-->

      <form method="get">
  
        <!--VOTRE EQUIPE-->
        <legend><strong><pre><h3><FONT face="Times New Roman"><p STYLE="padding:0 0 0 50px;">VOTRE EQUIPE</FONT></h3></pre></strong></legend><br/>

        <!--NOM-->
        <label><strong>Nom de l'equipe</strong></label><br/><br/>  
        <input type="text" name="nomequipe" value="<?php if (isset ($_GET['nomequipe'])){echo $_GET['nomequipe']; }?>" placeholder = "Entrez un Nom..." /><br/><br/><br/>

        <!--Capitaine-->
        <label><strong>id capitaine</strong></label><br/><br/>  
        <input type="hidden" name="idCapitaine"  value="<?php if (isset ($_SESSION['utilisateur']['id_utilisateur'])){echo (int)$_SESSION['utilisateur']['id_utilisateur'];} ?>" /> <?php echo (int)$_SESSION['utilisateur']['id_utilisateur'];?> <br/><br/><br/>

        <!--NIVEAU-->
        <strong>Niveau de l'equipe</strong><br/><br/>
        <input type="number" max= "10" min="1" name="niveau" value="<?php if (isset ($_GET['niveau'])){echo $_GET['niveau']; }?>" placeholder = "Niveau.." /><br/><br/><br/>

        <!--MAIL-->
        <strong>Adresse Mail</strong> <br/><br/>
        <input type="email" name="adresseMail"  value="<?php if (isset ($_GET['adresseMail'])){echo $_GET['adresseMail']; }?>" placeholder = "Entrez une Adresse Mail.." /><br/><br/><br/>

        <!--NUM-->
        <strong>Numero de telephone</strong><br/><br/>
        <input type="number" name="numeroTel" value="<?php if (isset ($_GET['numeroTel'])){echo $_GET['numeroTel'];} ?>" placeholder = "Entrez un numero.." /><br/><br/><br/>
        
        <!--Sport pour les infor generales-->
        <strong>Votre sport</strong><br/><br/>
        
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
       
        </select><br/><br/><br/>


        <!--BOUTONS-->
        <input type="reset" value="REINITIALISER" name="EffacerEntrees"> 
        <input type="submit" id="submit" value="VALIDATION DES INFORMATIONS GENERALES" name="creerEquipe" > <br/><br/><br/>


      </form> 

    

      <?php


        //on voudra recuperer les valeurs de l'adresse mail et le sport de l'equipe
        $sport = ' ';


        if (isset ($_GET['creerEquipe']) ){

          $adresseMail = $_GET['adresseMail'];
          $sport = $sport + $_GET['idsport'];

      ?>

        <form>
          <!--Sport pour les infos generales-->

          <?php
          $idUser = (int)$_SESSION['utilisateur']['id_utilisateur'];
          $sql = "SELECT idSport, idUtilisateur, nomSport FROM SportUtilisateur, Sport WHERE idSport = id_sport AND idUtilisateur = $idUser;";
          ?>

          <strong>Remettez votre sport</strong><br/><br/>
          <select name="idsport" id="sport" onchange="window.frames[0].location='liste_membre_equipe.php?idsport='+this.value+'&adresseMail='+this.$adresseMail+'&idCapitaine='+this.$capitaine">

            <?php
              $sport = $dbh->query("SELECT idSport, idUtilisateur, nomSport, nbjoueur FROM SportUtilisateur, Sport WHERE idSport = id_sport AND idUtilisateur = $idUser;");
              $sport->execute();
              echo '<option value="val0">choisissez un sport</option>';

              foreach ($sport as $spt)
              {
                echo '<option id="sport" value="'.$spt['idSport'].'">'.$spt['nomSport'].'</option>';
              }
              $adresseMail = $_GET['adresseMail'];
              $capitaine = $_GET['idCapitaine'];
            ?>

          </select><br/><br/><br/>

          <iframe style="width: 100%; border: 0"></iframe>

        </form>

      <?php

          //INFORMATION GENERALES::

          $sql = "INSERT INTO Equipe (nomEquipe, niveau, adresseMail, numeroTel, idCapitaine, sport) VALUES ('".$_GET['nomequipe']."','".$_GET['niveau']."','".$_GET['adresseMail']."','".$_GET['numeroTel']."','".$_GET['idCapitaine']."','".$_GET['idsport']."');";
          $sth = $dbh->prepare($sql);
          $sth->execute();
      
        }//fin du isset

        //INSCRIPTION DES MEMBRES////

        if (isset ($_GET['listejoueurs'])){


          $sport = $dbh->query("SELECT id_sport, nomSport, nbjoueur FROM Sport;");
          $sport->execute();          
  

          //on commence par calculer le max des id créer c'est a dire la derniere equipe qui vient d'etre créé
          $id = $dbh->query("SELECT MAX(id_equipe) FROM Equipe;"); //l'equipe qu'on vient de créer est la derniere
          $idequipe = $id->fetchColumn(0);


          //on ajoute le capitaine à l'equipe
          $cap = "INSERT INTO membreEquipe (idUtilisateur, idEquipe) VALUES (".(int)$_SESSION['utilisateur']['id_utilisateur'].", ".(int)$idequipe.");";
          if (!$cap) die("Impossible d'executer la requête !");
          $sthcap = $dbh->prepare($cap);
          $sthcap->execute();

          //puis les membres
          foreach ($_GET['joueur'] as $idjoueur) {
            $membre = "INSERT INTO membreEquipe (idUtilisateur, idEquipe) VALUES (".(int)$idjoueur.", ".(int)$idequipe.");";
            if (!$membre) die("Impossible d'executer la requête !");
            $sthmembre = $dbh->prepare($membre);
            $sthmembre->execute();
          }

          echo "Votre equipe vient d'etre creer !";
        }
      
      ?>

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