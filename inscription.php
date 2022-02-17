<?php
session_start();
require('config/bdd.php');

if (isset($_SESSION['id']) && $_SESSION['id'] > 0) {
    header("Location: profil.php");
}

if (isset($_POST['forminscription'])) {
    $erreur = "";
    $login = htmlspecialchars($_POST['login']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $password2 = htmlspecialchars($_POST['password2']);
    if (!empty($_POST['login']) and !empty($_POST['password']) and !empty($_POST['password2']) and !empty($_POST['email'])) {
        $loginlenght = strlen($login);
        $passwordlenght = strlen($password);
        $password2lenght = strlen($password2);
        $id_droits = 1;

        $requetelogin = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?"); 
        $requetelogin->execute(array($login));
        $loginexist = $requetelogin->rowCount(); 
        $requeteemail = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = ?"); 
        $requeteemail->execute(array($email));
        $emailexist = $requeteemail->rowCount();  

        if ($loginlenght > 255)
            $erreur = "Votre login ne doit pas dépasser 255 caractères !";
        elseif ($passwordlenght > 255)
            $erreur = "Votre password ne doit pas dépasser 255 caractères !";
        elseif ($password !== $password2)
            $erreur = "Vos mots de passe ne correspondent pas !";

        if ($loginexist !== 0)
            $erreur = "Votre login est déjà pris !";

        if ($emailexist !== 0)
            $erreur = "Votre email est déjà pris !";

        if ($erreur == "") {
            $hachage = password_hash($password, PASSWORD_BCRYPT);
            $insertmbr = $bdd->prepare("INSERT INTO utilisateurs(id_droits,login, password, email) VALUES(?,?,?,?)"); // Prépare une requête à l'exécution et retourne un objet (PDO)
            $insertmbr->execute(array($id_droits, $login, $hachage, $email)); // Exécute une requête préparée PDO
            $erreur = "Votre compte à été crée !";
            header('Location: connexion.php');
            exit();
        }
    } else {
        $erreur = "Tout les champs doivent être remplis !";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>

<body>
    <header>
        <?php 
        
            include_once('include/header.php');
        
        ?>
    </header>
    <div class="az">
        <main class="text-light ">
            <h2 class="text-center pb-2" > Remplissez tout les champs</h2>
            

            <form class="" method="POST" action="">
                <section class="d-flex justify-content-center">
            <div class="d-flex flex-column text-center">

                            <label class="p-2 col-12" for="login">Login : </label>

                            <input class="p-2 col-12 " type="text" placeholder="Votre login" name="login" id="login" value="<?php if (isset($login)) {
                                                                                                                        echo $login;
                                                                                                                    } ?>">


                            <label class="p-2 col-12" for="email">Email : </label>

                            <input class="p-2 col-12" type="email" placeholder="Votre email" name="email" id="email">

                            <label class="p-2 col-12" for="password">Password : </label>

                            <input class="p-2 col-12"  type="password" placeholder="Votre password" name="password" id="password">

                            <label class="p-2 col-12" for="password2">Confirmation : </label>

                            <input class="p-2 col-12" type="password" placeholder="Confirmation password" name="password2" id="password2">

                    





                        
                            <input  class="btn btn-primary mb-4 mt-3" type="submit" name="forminscription" class="forminscription" value="Je m'inscris">
                            </div>

            </form>
            <?php
            if (isset($erreur)) {
                echo '<font color="red">' . $erreur . '</font>';
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