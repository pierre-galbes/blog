<?php

session_start();
$idarticle = $_GET['idarticle'];
$bdd= mysqli_connect("localhost","root","","blog");
$req= mysqli_query($bdd,"SELECT * FROM articles WHERE id = $idarticle");
$res= mysqli_fetch_all($req,MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/articles.css">
    <link rel="stylesheet" href="css/header.css">
    <title>Document</title>
</head>
<body>
<header>
<?php include("include/header.php") ?></header>

    <div class="contenue"><h1><?php echo $res[0]['titre'];?></h1></br>
    <?php
    echo $res[0]['article'];
    ?>


    <legend>Laissez un commentaire</legend>
            <form method="post" action=<?php echo '"submit.php?idarticle='.$idarticle.'"'?>>
                <label for="text">Votre commentaire : </label></br>
                <textarea id="text" type="text" name="comm"></textarea></br>
                <input type="submit" name="envoyer" value="Envoyer">
            </form>

            <?php

//Affichage des messages du blog//
$req = mysqli_query($bdd, "SELECT commentaires.date, commentaires.commentaire, utilisateurs.login FROM commentaires INNER JOIN utilisateurs ON commentaires.id_utilisateur = utilisateurs.id  WHERE id_article = $idarticle ORDER BY commentaires.date DESC");
$nbLignes = mysqli_num_rows($req);

if ($nbLignes > 0) {
    while ($row = mysqli_fetch_assoc($req)) {
        $nom = $row['login'];
        $comm = $row['commentaire'];
        $date = date_create($row['date']);
        $comm = nl2br($comm);

        echo ' <h5>Posté le ' .
            date_format($date, 'd/m/Y \à H:i:s') . ' par ' .  '<span class="user">' . $nom . '</span>:</h5><p style="white"><br>' .
            $comm . '</p><hr>';
    }
} else {
    echo "Aucun message n'a été publié pour le moment";
}
?>
</div>
            

        
</body>
</html>