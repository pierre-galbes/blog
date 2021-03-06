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
</head>

<body>
    <div class="" id="fondHead">
        <div id="" class="container">
            <h1 class="text-light">blog DE CUISINE </h1>
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
                    <td class="nav-item"><a class="nav-link " href="inscription.php">
                            Inscription
                        </a>
                    </td>
                    <td class="nav-item"><a class="btn btn-primary " href="connexion.php">
                            Connexion
                        </a>
                    </td>
                </tr>
            </nav>
        </div>
    </div>
</body>

</html>