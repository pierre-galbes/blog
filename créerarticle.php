<?php
require('config/bdd.php');
session_start();


if ($_SESSION['id_droits'] != 42 && $_SESSION['id_droits'] != 1337) {
    header("Location: index.php");
    exit();
} else {

    $listecate = $bdd->query('SELECT * FROM categories ORDER BY id ASC');
    $getid = intval($_SESSION['id']); 
    $requtilisateur = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?'); 
    $requtilisateur->execute(array($getid)); 
    $infoutilisateur = $requtilisateur->fetch();

    $a_msg = "";

    if (isset($_POST['submit_article'])) {

        $titre = htmlspecialchars($_POST['titre']);
        $article = htmlspecialchars($_POST['article']);
        $titrereq = $bdd->prepare("SELECT * FROM articles WHERE titre = ?"); 
        $titrereq->execute(array($titre));
        $titreexist = $titrereq->rowCount(); 


        if (isset($_POST['article']) && !empty($_POST['article'])) {
            $articlelenght = strlen($_POST['article']);

            if ($articlelenght > 5000)
                $a_msg = "<span style='color:red'>Votre article ne doit pas dépassé les 5000 caractères !</span><br><br>";

            if ($titreexist !== 0)
                $a_msg = "<span style='color:red'>Le titre est déjà utilisé !</span><br><br>";

            if ($a_msg == "") {
                $req = $bdd->query('SELECT id FROM categories WHERE nom ="' . $_POST['select'] . '"');
                $categ = $req->fetch();
                $lecommentaire = htmlspecialchars($_POST['article']);
                $postage = $bdd->prepare('INSERT INTO articles (id_categorie,id_utilisateur, article, titre, date) VALUES (?,?,?,?,NOW())');
                $postage->execute(array($categ['id'], $getid, $lecommentaire, $titre));
                $a_msg = "<span style='color:green'>Votre article a bien été posté</span><br><br>";
                unset($_POST);
            }
        } else {
            $a_msg = "Champs vide";
            unset($_POST);
        }
    }

?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <title>Créer un article</title>
    </head>

    <body>
        <header>
            <?php if (isset($_SESSION['login'])) {
                include_once("include/headeronline.php");
            } else {
                include_once('include/header.php');
            }
            ?>
        </header>
        <main class="az" id="crmaincreer">
            <form id="crformcreer" method="POST">
                <p class="text-light"> Bienvenue <?php echo $infoutilisateur['login'] ?></p><br><br>
                <input type="text" placeholder="Titre" name="titre" id="titre" value="<?php if (isset($titre)) {
                                                                                            echo $titre;
                                                                                        } ?>"><br><br>
                <select name="select" id="select">
                    <?php while ($lis = $listecate->fetch()) { ?>

                        <option><?= $lis['nom'] ?></option>
                    <?php } ?>
                </select><br><br>

                <textarea name="article" placeholder="Votre article..." value="<?php if (isset($article)) {
                                                                                    echo $article;
                                                                                } ?>" style="width: 300px; height: 100px"></textarea><br /><br>
                <input class="btn btn-primary" type="submit" value="Poster mon article" name="submit_article" />
            </form>
            <br>
            <?php if (isset($a_msg)) {
                echo $a_msg;
            } ?>
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

    </html>

<?php
}
?>