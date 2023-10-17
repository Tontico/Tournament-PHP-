<<<<<<< HEAD
<!doctype html>
<html lang="fr">

  <head>
  
    <meta charset="utf-8" />
    <title> Liste des utilisateurs </title>

    <style>
    table, th {
      border : 3px solid black; border-collapse: collapse;
      }
    td, tr {
      border : 1px solid black; border-collapse: collapse;
    }
    </style>

  </head>
   
  <body>

    <h1> Liste des utilisateurs </h1>


    <?php //pour se connecter à la table SQL créé

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
	   
      $req = "SELECT * from Utilisateur order by nomUtilisateur;";
      $res = $dbh->query($req);
      echo "<ul>";

      $req2 = "SELECT * from Role order by nomRole;";
      $res2 = $dbh->query($req2);
      echo "<ul>";

      $reqroles = "SELECT * from Utilisateur, Role, RoleUtilisateur where idRole=id_role AND idUtilisateur = id_utilisateur order by nomRole;";
      $resrole = $dbh->query($reqroles);
      echo "<ul>";

    ?>

    <table> <!--construction d'un tableau pour donner les données de chaques utilisateurs--> 
      <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Adresse Mail</th>
        <th>Mot de Passe</th>
      </tr>

      <?php //mettre les lignes avec les attributs récupérés dans la table

        foreach ($res as $uti) {                                           
          echo "<tr>
            <td align='center'> {$uti['nomUtilisateur']} </td>
            <td align='center'> {$uti['prenomUtilisateur']} </td> 
            <td align='center'> {$uti['adresseMail']} </td>
            <td align='center'> {$uti['motDePasse']} </td>
          </tr>";
        }
        echo '</table>';
      
      ?>
    
    <h2 align='left'>Liste des Roles qu'on peut leurs attribuer</h2>


    <style>
      table, th {
        border : 3px solid black; border-collapse: collapse;
      }
      td, tr {
        border : 1px solid black; border-collapse: collapse;
      }
    </style>


    <table> <!--construction d'un tableau pour donner les roles qu'on peut attribuer à chaque utilisateur--> 
      <tr>
        <th align='center'>Roles</th>
      </tr>

      <?php //mettre les lignes avec les attributs récupérés dans la table

        foreach ($res2 as $role) {                                           
          echo "<tr>
            <td align='center'> {$role['nomRole']} </td>
          </tr>";
        }
        echo '</table>';
      
      ?>

    <h2 align='left'>Roles des utilisateurs</h2>

    <table> <!--construction d'un tableau pour donner les roles de chaque utilisateurs--> 
      <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Role</th>
      </tr>

      <?php //mettre les lignes avec les attributs récupérés dans la table

        foreach ($resrole as $urole) {                              
          echo "<tr>
            <td align='center'> {$urole['nomUtilisateur']} </td>
            <td align='center'> {$urole['prenomUtilisateur']} </td> 
            <td align='center'> {$urole['nomRole']} </td>
          </tr>";
        }
        echo '</table>';
      
      ?>  


  </body>

</html>
=======
<!doctype html>
<html lang="fr">

  <head>
  
    <meta charset="utf-8" />
    <title> Liste des utilisateurs </title>

    <style>
    table, th {
      border : 3px solid black; border-collapse: collapse;
      }
    td, tr {
      border : 1px solid black; border-collapse: collapse;
    }
    </style>

  </head>
   
  <body>

    <h1> Liste des utilisateurs </h1>


    <?php //pour se connecter à la table SQL créé

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
	   
      $req = "SELECT * from Utilisateur order by nomUtilisateur;";
      $res = $dbh->query($req);
      echo "<ul>";

      $req2 = "SELECT * from Role order by nomRole;";
      $res2 = $dbh->query($req2);
      echo "<ul>";

      $reqroles = "SELECT * from Utilisateur, Role, RoleUtilisateur where idRole=id_role AND idUtilisateur = id_utilisateur order by nomRole;";
      $resrole = $dbh->query($reqroles);
      echo "<ul>";

    ?>

    <table> <!--construction d'un tableau pour donner les données de chaques utilisateurs--> 
      <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Adresse Mail</th>
        <th>Mot de Passe</th>
      </tr>

      <?php //mettre les lignes avec les attributs récupérés dans la table

        foreach ($res as $uti) {                                           
          echo "<tr>
            <td align='center'> {$uti['nomUtilisateur']} </td>
            <td align='center'> {$uti['prenomUtilisateur']} </td> 
            <td align='center'> {$uti['adresseMail']} </td>
            <td align='center'> {$uti['motDePasse']} </td>
          </tr>";
        }
        echo '</table>';
      
      ?>
    
    <h2 align='left'>Liste des Roles qu'on peut leurs attribuer</h2>


    <style>
      table, th {
        border : 3px solid black; border-collapse: collapse;
      }
      td, tr {
        border : 1px solid black; border-collapse: collapse;
      }
    </style>


    <table> <!--construction d'un tableau pour donner les roles qu'on peut attribuer à chaque utilisateur--> 
      <tr>
        <th align='center'>Roles</th>
      </tr>

      <?php //mettre les lignes avec les attributs récupérés dans la table

        foreach ($res2 as $role) {                                           
          echo "<tr>
            <td align='center'> {$role['nomRole']} </td>
          </tr>";
        }
        echo '</table>';
      
      ?>

    <h2 align='left'>Roles des utilisateurs</h2>

    <table> <!--construction d'un tableau pour donner les roles de chaque utilisateurs--> 
      <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Role</th>
      </tr>

      <?php //mettre les lignes avec les attributs récupérés dans la table

        foreach ($resrole as $urole) {                              
          echo "<tr>
            <td align='center'> {$urole['nomUtilisateur']} </td>
            <td align='center'> {$urole['prenomUtilisateur']} </td> 
            <td align='center'> {$urole['nomRole']} </td>
          </tr>";
        }
        echo '</table>';
      
      ?>  


  </body>

</html>
>>>>>>> 3851daa9fbccf851b12ac4153978a9c8e82ff043
