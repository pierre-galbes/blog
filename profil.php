<?php

session_start();
$id = $_SESSION["id"];
$bdd= mysqli_connect("localhost","root","","blog");
$req= mysqli_query($bdd,"SELECT * FROM utilisateurs WHERE id = $id");
$res= mysqli_fetch_all($req,MYSQLI_ASSOC);
$login = $res[0]['login'];
$password = $res[0]['password']; 
$email = $res[0]['email'];

if (isset($_POST['env']))
{
    $email1= $_POST['email'];
    $password1 = $_POST['password'];
    $login1 = $_POST['login'];
    if($login1 !='admin')
    $req2= mysqli_query($bdd,"UPDATE utilisateurs SET login='$login1', password='$password1' , email='$email1' WHERE  id = $id ");
    header("Location: profil.php");
} 

?>


<!DOCTYPE html>
<html lang="Fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profil</title>
    <link rel="stylesheet" href="profil.css">
    <style type="text/css">
        A {
            text-decoration: none;
        }
    </style>
</head>

<body>

    <header class="img">
        <h1>Modification du profil</h1>
        <div class="pdp">
            <img src="https://meetanentrepreneur.lu/wp-content/uploads/2019/08/profil-linkedin.jpg">
        </div>
        <nav>
            <ul>
                <li id="index"> <a href="index.php">Accueil </a> </li>
                <?php 
            if (isset($_SESSION["id"])) {
            echo "<li><a href='deconnexion.php'>deconnexion</a></li>";
            echo "<li><a href='profil.php'>Profil</a></li>"; 
            } else {
            echo "<li><a href='connexion.php'>Se connecter</a></li>";
            echo "<li><a href='inscription.php'>Sinscrire</a></li>";
        };
            ?>

            </ul>
        </nav>

    </header>

    <main>
        <form name="salut" action="" method="post">
            <label class="input1" for="login">Pseudo</label>
            <input name="login" value="<?php echo $login?>" type="text" placeholder="username" />


            <label class="label" for="email">Email</label>
            <input class="inpute" value="<?php echo $email?>" name="email" type="email"
                placeholder="exemple@hotmail.fr" />

            <label class="label" for="password">Mot de passe</label>
            <input class="inpute" value="<?php echo $password?>" name="password" type="password"
                placeholder="Ton mdp" />

            <input class="env" name="env" type="submit" Envoyer />
            
        </form>
    </main>

    <footer>


    </footer>

</body>

</html>