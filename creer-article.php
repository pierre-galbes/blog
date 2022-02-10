<?php
session_start();

$bdd= mysqli_connect("localhost","root","","blog");

$id=$_SESSION['id'];
$req= mysqli_query($bdd," SELECT utilisateurs.id, utilisateurs.login, utilisateurs.prenom, utilisateurs.password, utilisateurs.email, droits.nom FROM utilisateurs INNER JOIN droits WHERE utilisateurs.id='$id' AND utilisateurs.id_droits = droits.id"); 


$res= mysqli_fetch_all($req);



?>
<html>
<head>
   <title>Rédaction</title>
   <meta charset="utf-8">
    <link rel="stylesheet" href="css/creer-article.css">
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
<header>
<?php include("include/header.php") ?>
</header>

        
        
   <form method="POST">
   <select name="statut" >
                 <option name="uti" value="1">Recettes</option>
                 <option name="modo" value="2">Nouvelles Recettes</option>
                 <option name="administrateur" value="3">Communauté</option>
         
            </select>
      <input name="Titre" placeholder="Titre l'article"></input><br/>
      <textarea name="id_text" placeholder="Texte  de l'article"></textarea><br/>
     
      <input type="submit" name="hero" value="Envoyer l'article"/>
     
   </form>
   <br/>
   <?php 
      if (isset($_POST['hero'])) {
         if(isset($res[0][3]) && isset($_POST['id_text']) && isset($_POST['Titre'])) {
              $id_utilisateur = htmlspecialchars($res[0][0]);
               $id_text = htmlspecialchars($_POST['id_text']);
               $id_categories = ($_POST['statut']);
               $titre = $_POST['Titre'];
              $ins = mysqli_query ($bdd,"INSERT INTO articles (titre, article,id_utilisateur, id_categorie, date) VALUES ('$titre','$id_text','$id_utilisateur', '$id_categories', NOW())");
              $message = 'Votre article a bien été posté';
              echo $message;
              
           } else {
              echo 'Veuillez remplir tous les champs';
        }
     }
   ?>
               </div>
</body>
</html>