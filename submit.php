<?php
$title = 'Traitement commentaire';
$connect= mysqli_connect("localhost","root","","blog");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<main>
<?php
session_start();
$idarticle = $_GET['idarticle'];
var_dump($_GET);

if (isset($_POST["envoyer"])) {
    $_SESSION['idarticle'] = $idarticle;
$id = $_SESSION["id"];
// récupérer le message et supprimer les antislashes ajoutés par le formulaire

$comm = strip_tags($_REQUEST['comm']); // j'utilise la fonction strip_tags pour qu'on ne puisse pas utiliser de balises html dans l'input
$time = date("Y-m-d H:i:s");
$query = "INSERT INTO commentaires (commentaire, id_article, id_utilisateur, date)
            VALUES ('$comm', '$idarticle','$id', '$time')";
$res = mysqli_query($connect, $query);
var_dump($res);

if (isset($res)) {
    echo "<div class='sucess'>
         <h3>Vous avez envoyé le commentaire avec succès.</h3>
         <p>Vous allez être redirigés vers l'article.</p>
         </div>";
     header("refresh:0; url=articles.php?idarticle=$idarticle");
} else {
    echo "L'envoi du commentaire a échoué";
}
}
?>
</main>
<footer>
  <?php include("include/footer.php") ?>
</footer>