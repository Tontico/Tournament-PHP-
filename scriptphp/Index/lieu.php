<<<<<<< HEAD
<?php
  session_start();

  // Si 'utilisateur' est dans le tableau $_SESSION, ca veut dire que l'utilisateur est connecté, donc on peut creer une variable intermédiaire qui vaudra vrai ou faux en fonction que l'utilisateur est connecté ou non
  $isLoggedIn = isset($_SESSION['utilisateur']);

  $localisation = "France";
?>

<!doctype html>
<html lang="fr">
  <head>
  <meta charset="utf-8" />
  </head>

  <style>
  fieldset {
    border: 0;
    }
  </style>

  <body>

  <?php
        if ($_GET['lieu'] != 'val0') {
         $localisation = $_GET['lieu'];
        }
      ?>

  <fieldset>
    <form><pre>

      <iframe width= "640" height="480" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q=<?php echo $_GET['lieu']; ?>&output=embed"></iframe>

    </pre>
    </form>
    <pre></pre>
  </fieldset>

  
=======
<?php
  session_start();

  // Si 'utilisateur' est dans le tableau $_SESSION, ca veut dire que l'utilisateur est connecté, donc on peut creer une variable intermédiaire qui vaudra vrai ou faux en fonction que l'utilisateur est connecté ou non
  $isLoggedIn = isset($_SESSION['utilisateur']);

  $localisation = "France";
?>

<!doctype html>
<html lang="fr">
  <head>
  <meta charset="utf-8" />
  </head>

  <style>
  fieldset {
    border: 0;
    }
  </style>

  <body>

  <?php
        if ($_GET['lieu'] != 'val0') {
         $localisation = $_GET['lieu'];
        }
      ?>

  <fieldset>
    <form><pre>

      <iframe width= "640" height="480" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q=<?php echo $_GET['lieu']; ?>&output=embed"></iframe>

    </pre>
    </form>
    <pre></pre>
  </fieldset>

  
>>>>>>> 3851daa9fbccf851b12ac4153978a9c8e82ff043
  </body>