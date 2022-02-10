<?php

session_start();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/inscription.css">
    <link rel="stylesheet" href="css/header.css">
</head>
<body>

<header>
<?php include("include/header.php") ?></header>


   <div class="container">
           
                        <div class="formu">
                        <form name="salut" action="" method="post">
                        <label class="input1" for="login">Pseudo</label>
                        <input name="login" type="text" placeholder="username" />

                        <label for="prenom">Prenom</label>
                        <input class="inpute" name="prenom" type="text" placeholder="prenom" />

                        <label class="label" for="email">Email</label>
                        <input class="inpute" name="email" type="text" placeholder="exemple@gmail.com" />

                        <label class="label" for="password">Mot de passe</label>
                        <input class="inpute" name="password" type="password" placeholder="Ton mdp" />

                        <label class="label" for="conf">Confirmation Mot de passe</label>
                        <input class="inpute" name="conf" type="password" placeholder="confirmation mdp" />

                        <input class="inscription" name="inscription" type="submit" placeholder="Envoyer" />
                        <p>Deja parmis nous ? <a  href='connexion.php'>connecte toi .</a></p>

                        
                        <?php
                  $bdd = mysqli_connect("localhost","root","","blog");
      
                  if (isset($_SESSION['login']) == false)
                  {
                    
                      if (isset($_POST['inscription']) && !empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['conf']) && !empty($_POST['email']) && !empty($_POST['prenom']))
                      {
                        
                          $login = $_POST['login'];
                         
                                    $email = $_POST['email'];
                                    $prenom = $_POST['prenom'];
                                    $password = $_POST['password'];
                                    $conf = $_POST['conf'];
                          $checklogin = "SELECT login FROM utilisateurs WHERE login = '$login'";
                          $query = mysqli_query($bdd, $checklogin);
                          $veriflogin = mysqli_fetch_all($query);
      
                          if (empty($veriflogin))
                          {
                              if ($_POST['password'] == $_POST['conf'])
                              {
                                  
                                  $ajoutbdd = 'INSERT INTO utilisateurs (login, prenom, email, password, id_droits) VALUES ("'.$login.'", "'.$prenom.'", "'.$email.'", "'.$password.'" ,1)';
                                  $ajout = mysqli_query($bdd, $ajoutbdd);
                                  echo '<h1 style="text-align: center; color: black">Bienvenue</h1>';
                                  header ("refresh:2;url=index.php");
                                  
                                  
                              }
      
                              else
                              {
                                 echo '<h2 style="text-align: center; color: red">La mot de passe et sa confirmation ne sont pas semblable. Réessayez.</h2>';
                              }
                          }
      
                          
                          else
                          {   
                              echo '<h2 style="text-align: center; color: red">login pas disponible, trouvez-en un autre.</h2>';
                          }
                      }
                      mysqli_close($bdd);
                  }
               
                      
              ?>
                  
                    </form>
                            
                </div>
            </div>
          
        </section>
        
</header>


    <main>
    
    </main>

</body>

</html>