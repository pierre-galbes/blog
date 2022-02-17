<?php
require_once('config/bdd.php');
$req = $bdd->prepare("SELECT * FROM categories ");
$req->execute(array());
$categories = $req->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta charset='utf-8'>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="" id="fondHead">
        <div id="" class="container">
            <h1 class="text-light">BLOG DE CUISINE</h1>
            <nav class="alflex">
                <tr class="nav nav-tabs">
                    <td class="nav-item">
                        <a class="nav-link" href="index.php">
                            Accueil
                        </a>
                    </td>
                    <td>
                        <div class="dropdown">
                            <a class="nav-link">
                                Articles
                            </a>
                            <div class="dropdown-content">
                                <a href="articles.php">Tous les articles</a>
                            <?php
                                foreach($categories as $categorie){
                                ?>
                                <a href="articles.php?categorie=<?= $categorie["id"] ?>"><?php echo $categorie["nom"] ?></a>
    <?php } ?>
                            </div>
                        </div>
                    </td>
                    <td class="nav-item">
                        <a class="nav-link" href="profil.php">
                            Profil
                        </a>
                    </td>
                    <td class="nav-item">
                        <form class="" action="" method="get">
                            <input class="btn btn-primary " name="off" type="submit" value="Déconnexion">
                        </form>
                    </td>
                </tr>
            </nav>
        </div>
    </div>
</body>

</html>



<?php
// déconnexion
if (isset($_GET['off'])) {

    session_destroy();
    header('location: index.php');
}

?>