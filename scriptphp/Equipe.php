<<<<<<< HEAD
<!doctype html>
<html lang="fr">
   <head><meta charset="utf-8" />
   <title> Liste des Equipes </title>
   <style>
   
   table
{
    border-collapse: collapse;
}
td,th
{
    border: 3px solid #000;
    padding: px;
    text-align: center;
}
tr
{
    border: 3px solid #000;
    padding: px;
    text-align: center;

}
   
   </style>
   
   </head>
   
   <body>
     <h1> Liste des Equipes </h1>
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
	   
       $req = "SELECT * from equipe;";
       $res = $dbh->query($req);
       
       	echo "<table>";
	  	echo "<tr><td>" . 'id_equipe' . "</td><td>" . 'nomEquipe' . "</td><td>" . 'niveau' . "</td><td>" . 'adresseMail' . "</td><td>" . 'numeroTel'. "</td><td>" . 'idCapitaine'. "</td><td>" . 'sport' . "</td></tr>";
      foreach ($res as $enr) { 
	  	echo "<tr>";
  	    echo  "<td>".$enr['id_equipe']."</td>"."<td>".$enr['nomEquipe']."</td>"."<td>".$enr['niveau']."</td>"."<td>".$enr['adresseMail']."</td>".
		      "<td>".$enr['numeroTel']."</td>"."<td>".$enr['idCapitaine']."</td>"."<td>".$enr['sport']."</td>";
        echo "</tr>";
          
        }
        echo '</table>';

  ?>
  </table>
  </body>
  </html>
=======
<!doctype html>
<html lang="fr">
   <head><meta charset="utf-8" />
   <title> Liste des Equipes </title>
   <style>
   
   table
{
    border-collapse: collapse;
}
td,th
{
    border: 3px solid #000;
    padding: px;
    text-align: center;
}
tr
{
    border: 3px solid #000;
    padding: px;
    text-align: center;

}
   
   </style>
   
   </head>
   
   <body>
     <h1> Liste des Equipes </h1>
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
	   
       $req = "SELECT * from equipe;";
       $res = $dbh->query($req);
       
       	echo "<table>";
	  	echo "<tr><td>" . 'id_equipe' . "</td><td>" . 'nomEquipe' . "</td><td>" . 'niveau' . "</td><td>" . 'adresseMail' . "</td><td>" . 'numeroTel'. "</td><td>" . 'idCapitaine'. "</td><td>" . 'sport' . "</td></tr>";
      foreach ($res as $enr) { 
	  	echo "<tr>";
  	    echo  "<td>".$enr['id_equipe']."</td>"."<td>".$enr['nomEquipe']."</td>"."<td>".$enr['niveau']."</td>"."<td>".$enr['adresseMail']."</td>".
		      "<td>".$enr['numeroTel']."</td>"."<td>".$enr['idCapitaine']."</td>"."<td>".$enr['sport']."</td>";
        echo "</tr>";
          
        }
        echo '</table>';

  ?>
  </table>
  </body>
  </html>
>>>>>>> 3851daa9fbccf851b12ac4153978a9c8e82ff043
