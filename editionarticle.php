<?php
session_start();
require('config/bdd.php');

    $listearticles = $bdd->query('SELECT `id` as ida, `article`, `id_utilisateur`, `id_categorie`, `date`, `titre` FROM `articles`');
    $categories = $bdd->query('SELECT `id` as idc, `nom` FROM `categories`');
    $fetchcate = $categories->fetchAll();
    
// ID nécessaire pour la connexion 
if (!isset($_SESSION['id']) || $_SESSION['id_droits'] != 1337) {
    header("Location: profil.php");
    exit();
}


if (isset($_POST['modiftitre']) && !empty($_POST['modiftitre'])) {
    $idchange = $_POST['ida'];
    $modificationtitre = $_POST['modiftitre'];
    $requetetitre = $bdd->prepare("SELECT * FROM articles WHERE titre = ?"); 
    $requetetitre->execute(array($modificationtitre));
    $titreexist = $requetetitre->rowCount(); 

    if ($titreexist != 0) {
        $_SESSION['msg'] = $_SESSION['msg'] . "Le titre éxiste déjà ! <br>";
    } else {

        $newtitre = htmlspecialchars($_POST['modiftitre']);
        $insertnewtitre = $bdd->prepare("UPDATE articles SET titre = ? WHERE id = ?");
        $insertnewtitre->execute(array($newtitre, $idchange));
        header('Location: editionarticle.php');
        exit();
    }
}


if (isset($_POST['modifarticle']) && !empty($_POST['modifarticle'])) {
    $idchange = $_POST['ida'];
    $modificationarticle = $_POST['modifarticle'];
    $requetearct = $bdd->prepare("SELECT * FROM articles WHERE article = ?"); 
    $requetearct->execute(array($modificationarticle));
    $articleexist = $requetearct->rowCount(); 


    if ($articleexist != 0) {
        $_SESSION['msg'] = $_SESSION['msg'] . "Il n'y as pas eu de modifications sur l'article <br>";
    } else {
        $newarticle = htmlspecialchars(trim($_POST['modifarticle']));
        $insertnewarticle = $bdd->prepare("UPDATE articles SET article = ? WHERE id = ?");
        $insertnewarticle->execute(array($newarticle, $idchange));

    }
}


if (isset($_POST['selectc'])) {

    $idchange = trim($_POST['ida']);
    $categoriechange = trim($_POST['selectc']);
    $changercateg = $bdd->prepare("UPDATE articles SET id_categorie = ? WHERE id = ?");
    $changercateg->execute(array($categoriechange, $idchange));
    header('Location: editionarticle.php');
    exit();
}


if (isset($_GET['supprimerarticle']) && !empty($_GET['supprimerarticle'])) {
    $supprimerarticle = (int) $_GET['supprimerarticle'];
    $reqc = $bdd->prepare('DELETE FROM articles WHERE id = ?');
    $reqc->execute(array($supprimerarticle));
    header("Location: editionarticle.php");
    exit();
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>MODIF profil</title>
</head>

<body>
    <header>

        <?php
        if (isset($_SESSION['login'])) {
            include_once("include/headeronline.php");
        } else {
            include_once('include/header.php');
        }
        ?>

    </header>
    <div class="az">
        <main>
        <table>
                <thead>
                    <tr class=test>
                        <th class="text-light">Titre</th>
                        <th class="text-light">Article</th>
                        <th class="text-light">Catégorie</th>

                    </tr>
                </thead>
                <?php while ($a = $listearticles->fetch()) { ?>
                    <tr>
                        <form  method="POST">
                            <input id="ida" type="hidden" name="ida" value="<?php echo $a['ida']; ?>">
                            <label class="text-light" for="modiftitre"></label>
                            <td><input class="" id="modiftitre" type="text" name="modiftitre" value="<?php echo $a['titre']; ?>"></td>
                            <label class="text-light" for="modifarticle"></label>
                            <td><textarea class="" id="modifarticle" rows="5" cols="33" name="modifarticle"> <?= $a['article']; ?></textarea></td>
                            <td>
                                <select name="selectc" id="selectc">
                                    <?php foreach ($fetchcate as $key => $value) { ?>
                                        <option <?= $a['id_categorie'] == $value['idc'] ? "selected" : NULL ?> value="<?= $value['idc'] ?>"><?= $value['nom'] ?></option>
                                    <?php

                                    } ?>
                                </select>
                            </td>
                            <td class=test><a class="btn btn-danger" href="editionarticle.php?supprimerarticle=<?= $a['ida'] ?>">Supprimer l'article</a></td>
                            <td class=test><input id="" type="submit" class="btn btn-primary" name="submit" value="Modifier"></td>
                        </form>
                    </tr>
                <?php } ?>

            </table>
            <br>

<br>
<?php

if (isset($_SESSION['msg'])) {
    echo '<font color="red">' . $_SESSION['msg'] . '</font><br /><br />';
    $_SESSION['msg'] = "";
}
?>
        </main>
    </div>
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

