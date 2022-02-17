<?php
session_start();
require('config/bdd.php');
if (isset($_SESSION['id']) && $_SESSION['id'] > 0) {
    $requtilisateur = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
    $requtilisateur->execute(array($_SESSION['id']));
    $infoutilisateur = $requtilisateur->fetch();
    if (isset($_POST['submit']) && $_POST['submit'] == 1) {

        if (isset($_POST['newlogin']) && !empty($_POST['newlogin']) && $_POST['newlogin'] != $infoutilisateur['login']) {
            $login = $_POST['newlogin'];
            $requetelogin = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?"); 
            $requetelogin->execute(array($login));
            $loginexist = $requetelogin->rowCount(); 

            if ($loginexist !== 0) {
                $msg = "Le login existe déjà !";
            } else {
                $newlogin = htmlspecialchars($_POST['newlogin']);
                $insertlogin = $bdd->prepare("UPDATE utilisateurs SET login = ? WHERE id = ?");
                $insertlogin->execute(array($newlogin, $_SESSION['id']));
                header('Location: profil.php');
                exit();
            }
        }

        if (isset($_POST['newemail']) && !empty($_POST['newemail']) && $_POST['newemail'] != $infoutilisateur['email']) {
            $email = $_POST['newemail'];
            $requeteemail = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = ?"); 
            $requeteemail->execute(array($email));
            $emailexist = $requeteemail->rowCount(); 

            if ($emailexist !== 0) {
                $msg = "L'email existe déjà !";
            } else {
                $newmail = htmlspecialchars($_POST['newemail']);
                $insertmail = $bdd->prepare("UPDATE utilisateurs SET email = ? WHERE id = ?");
                $insertmail->execute(array($newmail, $_SESSION['id']));
                header('Location: profil.php');
                exit();
            }
        }

        if (!$_POST['newmdp'] || !$_POST['newmdp2']) {
            $msg = "Champs du mot de passe vide";
        }

        if (isset($_POST['newmdp']) && !empty($_POST['newmdp']) && isset($_POST['newmdp2']) && !empty($_POST['newmdp2'])) {

            $mdp1 = $_POST['newmdp'];
            $mdp2 = $_POST['newmdp2'];

            if ($mdp1 == $mdp2) {
                $hachage = password_hash($mdp1, PASSWORD_BCRYPT);
                $insertmdp = $bdd->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");
                $insertmdp->execute(array($hachage, $_SESSION['id']));
                header('Location: profil.php');
            } else {
                $msg = "Vos mots de passes ne correspondent pas !";
            }
        }
    }
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <title>Edition profil</title>
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
                <div id="crdivedition">
                    <h2 class="text-light">modif de mon profil</h2>
                    <br />
                    <form method="POST" action="">
                        <input id="hidden" name="submit" type="hidden" value=1>
                        <table>
                            <tr class="crtdinscription">
                                <td align="right">
                                    <label class="text-light" for="login">Login :</label>
                                </td>
                                <td>
                                    <input class="crtdedition" id="login" type="text" name="newlogin" placeholder="Login" value="<?php echo $infoutilisateur['login']; ?>">
                                </td>
                            </tr>
                            <tr class="crtdinscription">
                                <td align="right">
                                    <label class="text-light" for="email">Email :</label>
                                </td>
                                <td class=test>
                                    <input class="crtdedition" id="email" type="text" name="newemail" placeholder="Email" value="<?php echo $infoutilisateur['email']; ?>">
                                </td>
                            </tr>
                            <tr class="crtdinscription">
                                <td class=test align="right">
                                    <label class="text-light" for="newmdp">Password :</label>
                                </td>
                                <td>
                                    <input class="crtdedition" id="newmdp" type="password" name="newmdp" placeholder="Mot de passe">
                                </td>
                            </tr>
                            <tr class="crtdinscription">
                                <td class=test align="right">
                                    <label class="text-light" for="newmdp2">Confirmation du password :</label>
                                </td>
                                <td>
                                    <input class="crtdedition" type="password" id="newmdp2" name="newmdp2" placeholder="Confirmation mot de passe">
                                </td>
                            </tr>
                        </table>
                </div>

                <?php
                if (isset($msg)) {
                    echo '<font color="red">' . $msg . '</font><br /><br />';
                }
                ?>
                <input id="crinputedition" type="submit" class="formconnexion" name="confirmation" value="Confirmé !">
                </form>
                <br><br>
                <a href="profil.php" class="formconnexion">Retour</a><br><br><br>
            </main>
        </div>
        <footer>
            <?php
            if (!isset($_SESSION["login"])) { 
                include_once('include/footer.php');
            } else if (isset($_SESSION["login"])) { 
                include_once("include/footerOnline.php");
            } else if (isset($_SESSION["id_droits"]) == 1337) { 
                include_once("include/footerAdmin.php");
            } else if (isset($_SESSION["id_droits"]) == 42) { 
                include_once("include/footerModo.php");
            }
            ?>
        </footer>
    </body>

    </html>

<?php
} else {
    header("Location: connexion.php");
    exit();
}

?>