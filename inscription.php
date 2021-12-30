<?php

$connect= mysqli_connect("localhost","root","","blog");

if (isset($_POST['env']))
{
  $email = $_POST['email'];
  $password = $_POST['password'];
  $login = $_POST['login'];
  $conf = $_POST['conf'];

  if (!empty($login) && !empty($password) && !empty($email) && !empty($conf)) {
    $sql=mysqli_query ($connect,"SELECT * FROM utilisateurs WHERE login='$login'"); 
    $res= mysqli_fetch_all($sql);
    if (count($res) == 0)
      if ($password == $conf) {
        echo 'Bienvenue ! vous pouvez des a présent vous conecter.';
        $req= mysqli_query($connect,"INSERT INTO utilisateurs (login,password,email,id_droits)
        VALUES('$login','$password','$email',1)");
      } else {echo 'Les mots de passes ne corespondent pas';}
      else {echo 'Ce compte existe deja, essaye un autre login !';}
  } else {echo 'Tout les champs doivent etre remplis';}
}

?>

<!DOCTYPE html>
<html lang="Fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="inscriptionstyle.css">
  <title>site</title>
</head>

<body>
  <div class="forum">
    <h1>Inscription</h1>
    <div class="forum">
      <form name="formu" action="" method="post">
        <br>
        <input name="login" type="text" placeholder="username" />
        <br>
        <br>
        <input name="email" type="text" placeholder="email" />
        <br>
        <br>
        <input name="password" type="password" placeholder="Ton mdp" />
        <br>
        <br>
        <input name="conf" type="password" placeholder="confimer" />
        <br>
        <br>
        <input name="env" type="submit" placeholder="clic ici">
        <p class="message">Deja inscrit ? par ici !<a href="connexion.php">Connexion</a></p>
        <p class="message">Ici un lien vers l'<a href="index.php">accueil</a></p>
      </form>
    </div>
</body>

</html>