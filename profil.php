<?php
session_start();
require('config/bdd.php');
if (isset($_SESSION['id']) && $_SESSION['id'] > 0) {
    $getid = intval($_SESSION['id']); 
    $requtilisateur = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?'); 
    $requtilisateur->execute(array($getid)); // return le tableau de mon utilisateur
    $infoutilisateur = $requtilisateur->fetch(); // récupere les informations que j'appelle
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Profil</title>
</head>

<body>
    <header>
        <?php if (isset($_SESSION['login'])) {
            include_once("include/headeronline.php");
        } else {
            header('location: connexion.php');
            exit;
        }
        ?>
    </header>
    <div class="az">
        <main>
            <div id="crdivprofil">
                <h2 class="text-light">Profil de <?php echo $infoutilisateur['login'] ?> </h2>
                <br />
                <p class="text-light"> Login = <?php echo $infoutilisateur['login'] ?></p>
                <br />
                <p class="text-light"> Email = <?php echo $infoutilisateur['email'] ?></p>
                <br />
                <a class="profila" href="editionprofil.php"> Editer son profil</a>
                <br />
                <?php
                // ID nécessaire pour voir creer un article
                if ($_SESSION['id_droits'] == 1337) { ?>
                    <a href="créerarticle.php">Créer un article</a><br>

                <?php  }                 ?>



            </div>
    </div>
    </main>

    <footer>
        <?php
        if (!isset($_SESSION["login"])) { 
            include_once('include/footer.php');
        } else if (isset($_SESSION["id_droits"]) == 1337) { 
            include_once("include/footerAdmin.php");
        } else if (isset($_SESSION["id_droits"]) == 42) { 
            include_once("include/footerModo.php");
        } else { 
            include_once("include/footerOnline.php");
        }

        ?>
    </footer>
</body>

</html> 
