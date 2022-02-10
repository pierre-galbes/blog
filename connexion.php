<?php

session_start();

$connect= mysqli_connect("localhost","root","","blog");

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/header.css">
</head>

<body>
<header>
<?php include("include/header.php") ?></header>
    <main>
    <div class="container">
            <div class="formu">
                <h1 class="h1">Connecte toi !</h1>

                <form name="salut" action="" method="post">
                    <label class="input1" for="login">Pseudo</label>
                    <input name="login" type="text" placeholder="username" />

                    <label for="password">Mot de passe</label>
                    <input name="password" type="password" placeholder="Ton mdp" />


                    <input class="env" name="env" type="submit" Envoyer />
                    
<?php
    if(isset($_POST['login']) && isset($_POST['password'])){
    $login=$_POST['login'];
    $password=$_POST['password'];
    $sql=mysqli_query ($connect,"SELECT * FROM utilisateurs WHERE login='$login' AND password='$password'");
    $res= mysqli_fetch_all($sql); 
    
    if (empty($res)) {
        echo 'Ton mot de passe ou login est faux  ';
    }
     else {
        if($res[0][4] == $password){
            
        if ( $password == 'Admin'){
                
        header ("refresh:2;url=admin.php");
    
                                    }
            else {
                echo $res[0][2] .'Bonjour, tu va être rediriger vers ton profil';
                $_SESSION["id"] = $res[0][0];
                header ("refresh:4;url=profil.php");

                
            }
         }else {
             echo "pas bon";
         }
     }
     
}


?>

                </form>
            </div>
        </div>
    </main>
  
</body>

</html>