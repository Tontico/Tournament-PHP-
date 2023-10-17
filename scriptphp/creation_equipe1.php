<!doctype html>
<html lang="fr">
<head> <meta charset="utf-8" /> </head>

<body>
  <?php
    if (isset($_GET['infosgenerales'])) {
       echo "Infos générales à stocker dans la base";
    }
    if (isset($_GET['listejoueurs'])) {
       echo "Joueurs de l'équipe à stocker dans la base";
    }
  ?>     
  
  <form>
      ICI il y a les premiers contrôles (nom, ...) <br/>
      <input type="submit" name="infosgenerales" value="VALIDER LES INFOS GENERALES DE L'EQUIPE"></input>
  </form>

  <br/>
  Choix du sport <select onchange="window.frames[0].location='creation_equipe2.php?sport='+this.value">
      <option> Choisissez le sport </option>
      <?php
         // ICI il y a votre code qui interroge la table sport
         echo "<option value='rugby'> rugby </option>";
         echo "<option value='volley'> volley </option>";
      ?>
      </select>

      <br/>
      <iframe style="width: 100%; border: 0"></iframe>
</body>
</html>
