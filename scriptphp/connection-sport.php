<<<<<<< HEAD
<html>
  <head> 
  <title> Inscription de l'Equipe</title>
  </head>
  <body>

    <?php 
      $dsn = "mysql:host=localhost;dbname=sports";  /* Data Source Name */
      $username = "root"; $password = "";
      $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
      $dbh = new PDO($dsn, $username, $password, $options) or die("Pb de connexion !");
    ?>


    <?php
      // Inscription
    if (isset($_GET['InscriptionSport'])) {
	    $sql = "INSERT INTO Sport (nomSport) VALUES ('".$_GET['nomsport']."')";
	    echo $sql; echo "\n";
        $sth = $dbh->prepare($sql);
        $sth->execute();
    }


    ?>

  <h1 align="center">Inscription du sport  </h1>
     
     <fieldset> <!--pour mettre un cadre autour-->

<form><!--formulaire de saisie-->
  
  <legend><strong><pre><h3><FONT face="Times New Roman"><p STYLE="padding:0 0 0 50px;">VOTRE EQUIPE</FONT></h3></pre></strong></legend><br/>


  
  <strong>Votre sport</strong><br/><br/>
  <select name="sportName" id="sport">
  <?php
  $sport = $dbh->query("SELECT id_sport, nomSport FROM Sport");
  foreach ($sport as $spt)
    {
    echo '<option id="spor" value="'.$spt['id_sport'].'">'.$spt['nomSport'].'</option>';
                
    }
            
  ?>


  </select><br/><br/><br/>

  
  <input type="reset" value="Reinitialiser" name="EffacerEntrees"> <!--bouton pour effacer le texte-->
  
  <input type="submit" value="InscriptionSport" name="InscriptionSport"> 


</form> 

</fieldset>

</body>

=======
<html>
  <head> 
  <title> Inscription de l'Equipe</title>
  </head>
  <body>

    <?php 
      $dsn = "mysql:host=localhost;dbname=sports";  /* Data Source Name */
      $username = "root"; $password = "";
      $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
      $dbh = new PDO($dsn, $username, $password, $options) or die("Pb de connexion !");
    ?>


    <?php
      // Inscription
    if (isset($_GET['InscriptionSport'])) {
	    $sql = "INSERT INTO Sport (nomSport) VALUES ('".$_GET['nomsport']."')";
	    echo $sql; echo "\n";
        $sth = $dbh->prepare($sql);
        $sth->execute();
    }


    ?>

  <h1 align="center">Inscription du sport  </h1>
     
     <fieldset> <!--pour mettre un cadre autour-->

<form><!--formulaire de saisie-->
  
  <legend><strong><pre><h3><FONT face="Times New Roman"><p STYLE="padding:0 0 0 50px;">VOTRE EQUIPE</FONT></h3></pre></strong></legend><br/>


  
  <strong>Votre sport</strong><br/><br/>
  <select name="sportName" id="sport">
  <?php
  $sport = $dbh->query("SELECT id_sport, nomSport FROM Sport");
  foreach ($sport as $spt)
    {
    echo '<option id="spor" value="'.$spt['id_sport'].'">'.$spt['nomSport'].'</option>';
                
    }
            
  ?>


  </select><br/><br/><br/>

  
  <input type="reset" value="Reinitialiser" name="EffacerEntrees"> <!--bouton pour effacer le texte-->
  
  <input type="submit" value="InscriptionSport" name="InscriptionSport"> 


</form> 

</fieldset>

</body>

>>>>>>> 3851daa9fbccf851b12ac4153978a9c8e82ff043
</html>