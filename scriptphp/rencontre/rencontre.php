<<<<<<< HEAD
<!doctype html>
<html lang="fr">
   <head><meta charset="utf-8" />
   <title> Liste des rencontres </title>
   <link rel="stylesheet" href="rencontre_style.css">
   </head>
   
   <body>
     <h1> Rencontres </h1>
     <?php
       ini_set('display_errors', 1); error_reporting(E_ALL);
       try {
         $dsn = 'mysql:host=localhost;dbname=sports;charset=UTF8';
         $login = 'root';  // à délocaliser dans un fichier
         $password = '';  // à délocaliser dans un fichier 
         $dbh = new PDO($dsn, $login, $password);
       } catch (PDOException $e) {
         print "Impossible d'ouvrir la base de données : " . $e->getMessage() . "<br/>";
         die("On arrête tout !");
       }
	   
      
       $req = "SELECT * from Rencontre;";
       $res = $dbh->query($req);
       
      echo "<table>";
      echo "<tr>";
      echo  "<th>"."id match"."</th>"."<th>"."poule"."</th>"."<th>"."id gagnant"."</th>"."<th>"."date et heure "."</th>";
      echo "</tr>";
      foreach ($res as $enr) {
        echo "<tr>";
  	    echo  "<td>".$enr['id_match']."</td>".
		"<td>".$enr['poule']."</td>".
		"<td>".$enr['idGagnant']."</td>".
		"<td>".$enr['dateHoraire']."</td>";
        echo "</tr>";
       } 
      
      echo "</table>";

  ?>
  </body>
  </html>
=======
<!doctype html>
<html lang="fr">
   <head><meta charset="utf-8" />
   <title> Liste des rencontres </title>
   <link rel="stylesheet" href="rencontre_style.css">
   </head>
   
   <body>
     <h1> Rencontres </h1>
     <?php
       ini_set('display_errors', 1); error_reporting(E_ALL);
       try {
         $dsn = 'mysql:host=localhost;dbname=sports;charset=UTF8';
         $login = 'root';  // à délocaliser dans un fichier
         $password = '';  // à délocaliser dans un fichier 
         $dbh = new PDO($dsn, $login, $password);
       } catch (PDOException $e) {
         print "Impossible d'ouvrir la base de données : " . $e->getMessage() . "<br/>";
         die("On arrête tout !");
       }
	   
      
       $req = "SELECT * from Rencontre;";
       $res = $dbh->query($req);
       
      echo "<table>";
      echo "<tr>";
      echo  "<th>"."id match"."</th>"."<th>"."poule"."</th>"."<th>"."id gagnant"."</th>"."<th>"."date et heure "."</th>";
      echo "</tr>";
      foreach ($res as $enr) {
        echo "<tr>";
  	    echo  "<td>".$enr['id_match']."</td>".
		"<td>".$enr['poule']."</td>".
		"<td>".$enr['idGagnant']."</td>".
		"<td>".$enr['dateHoraire']."</td>";
        echo "</tr>";
       } 
      
      echo "</table>";

  ?>
  </body>
  </html>
>>>>>>> 3851daa9fbccf851b12ac4153978a9c8e82ff043
