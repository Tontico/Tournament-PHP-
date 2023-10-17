<!doctype html>
<html lang="fr">
<head> <meta charset="utf-8" /> </head>

<body>
  <?php
    $sport = $_GET['sport'];
    // il faut interroger la table sports, récupérer le nombre de joueurs dans une équipe (variable $nombre)
    if ($sport == 'rugby') $nombre = 15;
    if ($sport == 'volley') $nombre = 6;    

    // il faut interroger les tables joueurs et sports pour connaitre les joueurs inscrits dans le sport
    // Je simule ;)
    $joueurs = array("Pompidor", "Meynard");

    echo "<form action='creation_equipe1.php' target='parent'>";
    for ($i=0; $i < $nombre; $i++) {
	echo "<select name='joueur$i'>";
	foreach ($joueurs as $nom) {
	    echo "<option> $nom </option>";
        }
        echo "</select>";
    }
    echo "<br/> <input type='submit' name='listejoueurs' value='VALIDER LES JOUEURS' />";
    echo "</form>";
  ?>
</body>
</html>
