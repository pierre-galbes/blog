<?php

session_start();
$id = $_SESSION["id"];
$bdd= mysqli_connect("localhost","root","","blog");
$req= mysqli_query($bdd,"SELECT * FROM utilisateurs WHERE id = $id");
$res= mysqli_fetch_all($req,MYSQLI_ASSOC);
$login = $res[0]['login'];
$prenom = $res[0]['prenom'];
$email = $res[0]['email'];
$password = $res[0]['password']; 


if (isset($_POST['env']))
{
   
    $email1 = $_POST['email'];
    $prenom1 = $_POST['prenom'];
    $password1 = $_POST['password'];
    $login1 = $_POST['login'];
    $req2= mysqli_query($bdd,"UPDATE utilisateurs SET login='$login1', prenom='$prenom1', email='$email1', password='$password1' WHERE  id = $id ");
    header("Location: profil.php");
} 

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profil</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/profil.css">
</head>
<body>
<header>
<main>
<?php include("include/header.php") ?></header>

        <section class="home">
            <div class="container">
                <div class="formu">
                    <form name="salut" action="" method="post">
                        <label class="input1" for="login">Pseudo</label>
                        <input name="login" value="<?php echo $login?>" type="text" placeholder="username" />

                        <label for="prenom">Prenom</label>
                        <input class="inpute"  value="<?php echo $prenom?>" name="prenom" type="text" placeholder="prenom" />

                        <label class="label" for="email">Email</label>
                        <input class="inpute"  value="<?php echo $email?>" name="email" type="email" placeholder="exemple@hotmail.fr" />

                        <label class="label" for="password">Mot de passe</label>
                        <input class="inpute" value="<?php echo $password?>" name="password" type="password" placeholder="Ton mdp" />

                        <input class="env" name="env" type="submit" Envoyer />
                      
                    </form>
                </div>
        </section>
</header>
</main>
<body>
</html>