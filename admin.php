<?php
session_start();
require('config/bdd.php');

$articles = $bdd->query('SELECT articles.`id` as ida, article, id_utilisateur, id_categorie, categories.nom, date, titre FROM articles INNER JOIN categories ON categories.id = articles.id_categorie ORDER BY articles.id ASC;');
$listearticles = $bdd->query('SELECT `id` as ida, `article`, `id_utilisateur`, `id_categorie`, `date`, `titre` FROM `articles`');
$lisar = $articles->fetchAll();
$categories = $bdd->query('SELECT `id` as idc, `nom` FROM `categories`');
$categoriess = $bdd->query('SELECT `id` as idc, `nom` FROM `categories`');
$fetchcate = $categories->fetchAll();
$utilisateurs = $bdd->query('SELECT utilisateurs.`id` as idu, `login`, `password`, `email`, `id_droits`,`nom` FROM `utilisateurs` INNER JOIN droits ON droits.id = utilisateurs.id_droits ORDER BY utilisateurs.id ASC;');
$listedroits = $bdd->query('SELECT * FROM droits');
$lis = $listedroits->fetchAll();


// ID nécessaire pour la connexion 
if (!isset($_SESSION['id']) || $_SESSION['id_droits'] != 1337) {
    header("Location: profil.php");
    exit();
}

// Fonction supprimé une catégorie
if (isset($_GET['supprimercateg']) && !empty($_GET['supprimercateg'])) {
    $supprimercateg = (int) $_GET['supprimercateg'];
    $reqc = $bdd->prepare('DELETE FROM categories WHERE id = ?');
    $reqc->execute(array($supprimercateg));
    header("Location: admin.php");
    exit();
}


// Fonction ajouter une catégorie 
if (isset($_POST['creercateg']) && !empty($_POST['creercateg'])) {
    $creercateg = htmlspecialchars($_POST['creercateg']);
    $requetecategor = $bdd->prepare("SELECT * FROM categories WHERE nom = ?"); // SAVOIR SI LE MEME LOGIN EST PRIS
    $requetecategor->execute(array($creercateg));
    $categexist = $requetecategor->rowCount(); // rowCount = Si une ligne existe = PAS BON

    if ($categexist !== 0) {
        $_SESSION['msg'] = $_SESSION['msg'] . "la catégorie existe déjà <br>";
    } else {

        $creercategorie = htmlspecialchars($_POST['creercateg']);
        $insertcateg = $bdd->prepare("INSERT INTO categories (nom) VALUES (?)");
        $insertcateg->execute(array($creercategorie));
        header('Location: admin.php');
        exit();
    }
}


// Fonction supprimé un utilisateur
if (isset($_GET['supprimer']) && !empty($_GET['supprimer'])) {
    $supprimer = (int) $_GET['supprimer'];
    $req = $bdd->prepare('DELETE FROM utilisateurs WHERE id = ?');
    $req->execute(array($supprimer));
    header("Location: admin.php");
    exit();
}

// Fonction modifié la catégorie
if (isset($_POST['newcateg']) && !empty($_POST['newcateg'])) {
    $idchange = $_POST['idc'];
    $newcateg = $_POST['newcateg'];
    $requetecateg = $bdd->prepare("SELECT * FROM categories WHERE nom = ?"); // SAVOIR SI LE MEME LOGIN EST PRIS
    $requetecateg->execute(array($newcateg));
    $categexist = $requetecateg->rowCount(); // rowCount = Si une ligne existe = PAS BON

    if ($categexist !== 0) {
        $_SESSION['msg'] = $_SESSION['msg'] . "la catégorie existe déjà <br>";
    } else {

        $newcategorie = htmlspecialchars($_POST['newcateg']);
        $insertcateg = $bdd->prepare("UPDATE categories SET nom = ? WHERE id = ?");
        $insertcateg->execute(array($newcategorie, $idchange));
        header('Location: admin.php');
        exit();
    }
}


// Fonction Modifié le login d'un utilisateur
if (isset($_POST['newlogin']) && !empty($_POST['newlogin'])) {
    $idchange = $_POST['id'];
    $login = $_POST['newlogin'];
    $requetelogin = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?"); // SAVOIR SI LE MEME LOGIN EST PRIS
    $requetelogin->execute(array($login));
    $loginexist = $requetelogin->rowCount(); // rowCount = Si une ligne existe = PAS BON

    if ($loginexist !== 0) {
        $_SESSION['msg'] = $_SESSION['msg'] . "le login existe déjà  <br>";
    } else {
        $newlogin = htmlspecialchars($_POST['newlogin']);
        $insertlogin = $bdd->prepare("UPDATE utilisateurs SET login = ? WHERE id = ?");
        $insertlogin->execute(array($newlogin, $idchange));
        header('Location: admin.php');
        exit();
    }
}





// modif email 
if (isset($_POST['newmail']) && !empty($_POST['newmail'])) {
    $idchange = $_POST['id'];
    $email = $_POST['newmail'];
    $requetemail = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = ?"); 
    $requetemail->execute(array($email));
    $emailexist = $requetemail->rowCount(); 

    if ($emailexist !== 0) {
        $_SESSION['msg'] = $_SESSION['msg'] . "l'email existe déjà <br>";
    } else {

        $newmail = htmlspecialchars($_POST['newmail']);
        $insertlogin = $bdd->prepare("UPDATE utilisateurs SET email = ? WHERE id = ?");
        $insertlogin->execute(array($newmail, $idchange));
        header('Location: admin.php');
        exit();
    }
}
// Fonction modifié le rang utilisateur
if (isset($_POST['select'])) {

    $idchange = $_POST['id'];
    $rang = $_POST['select'];
    $changerrang = $bdd->prepare("UPDATE utilisateurs SET id_droits = ? WHERE id = ?");
    $changerrang->execute(array($rang, $idchange));
    header('Location: admin.php');
    exit();
}



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <title>Espace Admin</title>
    
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
    <div class="az">
        <main class="container pt-3">
            <h2 class="text-light">Espace Admin</h2>
            <br />
            <table>
                <thead>
                    <tr class=test>
                        <th class="text-light">Login</th>
                        <th class="text-light">Email</th>
                        <th class="text-light">Droits</th>
                    </tr>
                </thead>
                <?php while ($u = $utilisateurs->fetch()) { ?>

                    <form class="" method="POST">
                        ""
                        <input id="id" type="hidden" name="id" value="<?php echo $u['idu']; ?>">
                        <label class="text-light" for="newlogin"></label>
                        <td><input class="" id="newlogin" type="text" name="newlogin" value="<?php echo $u['login']; ?>"></td>
                        <label class="text-light" for="newmail"></label>
                        <td><input class="" id="newmail" type="mail" name="newmail" value="<?php echo $u['email']; ?>"></td>
                        <td>
                            <select name="select" id="select">
                                <?php foreach ($lis as $key => $value) { ?>
                                    <option <?= $u['id_droits'] == $value['id'] ? "selected" : NULL ?> value="<?= $value['id'] ?>"><?= $value['nom'] ?></option>
                                <?php
                                } ?>
                            </select>
                        </td>
                        <td class=test><a class="btn btn-danger" href="admin.php?supprimer=<?= $u['idu'] ?>">Bannir</a></td>
                        <td class=test><input id="" type="submit" class="btn btn-primary" name="submit" value="Modifier !"></td>
                    </form>
                    </tr>
                <?php } ?>
            </table>

            <table>
                <thead>
                    <tr class=test>
                        <th class="text-light">Catégories</th>

                    </tr>
                </thead>
                <?php while ($c = $categoriess->fetch()) { ?>
                    <form method="POST">
                        <input id="idc" type="hidden" name="idc" value="<?php echo $c['idc']; ?>">
                        <label class="text-light" for="newcateg"></label>
                        <td><input class="" id="newcateg" type="text" name="newcateg" value="<?php echo $c['nom']; ?>"></td>
                        <td class=test><a class="btn btn-danger" href="admin.php?supprimercateg=<?= $c['idc'] ?>">Supprimer la catégorie</a></td>
                        <td class=test><input id="" type="submit" class="btn btn-primary" name="submit" value="Modifier"></td>
                    </form>
                    </tr>
                <?php } ?>
                <form method="POST">
                    <label class="mt-4 text-light" for="creercateg"></label>
                    <td><input class="mt-4" id="creercateg" type="text" name="creercateg" placeholder="Ajoutez une catégorie..."></td>
                    <td class=test><input id="" type="submit" class="btn btn-primary mt-4 ms-3" name="submit" value="Confirmé !"></td>
                </form>
            </table>
            <br>
            <a href="editionarticle.php"><input class="btn btn-secondary btn-lg" type="button" value="Modifier article"></a>
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
        if (!isset($_SESSION["login"])) { // si l'utilisateur n'est pas connecté
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
</head>