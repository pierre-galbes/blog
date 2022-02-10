<?php
ob_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>adminn</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/admin.css">
    <meta charset="utf-8">

</head>

<body>
    <header>
        <?php include("include/header.php") ?></header>
    <?php
    $bdd = mysqli_connect("localhost", "root", "", "blog");
    $req = mysqli_query($bdd, " SELECT utilisateurs.id, utilisateurs.login, utilisateurs.prenom, utilisateurs.password, utilisateurs.email, droits.nom FROM utilisateurs INNER JOIN droits ON utilisateurs.id_droits = droits.id");
    
    if (isset($_POST['ban'])) {
        $id1 = $_POST['id'];
    $reqban = mysqli_query($bdd, "DELETE FROM utilisateurs WHERE id = $id1");
    }
    $res = mysqli_fetch_all($req);
    $id = $res[0][0];
    $login = $res[0][1];
    $email = $res[0][3];
    $prenom = $res[0][2];

    if (isset($_POST['env'])) {
        $id1 = $_POST['id'];
        $login1 = $_POST['login'];
        $prenom1 = $_POST['prenom'];
        $email1 = $_POST['email'];
        if ($_POST['statut'] == "utilisateur") {
            $id_droit = 1;
        } elseif ($_POST['statut'] == "administrateur") {
            $id_droit = 1337;
        } elseif ($_POST['statut'] == "moderateur") {
            $id_droit = 42;
        }
        
        $req2 = mysqli_query($bdd, "UPDATE utilisateurs SET login='$login1', prenom='$prenom1', email='$email1', id_droits='$id_droit' WHERE  id = $id1 ");
        header("Location: admin.php");
    }

    ?>
    <form action="#" method="post">
    </br></br></br>
    <h1 id=infoprofil >Informations du profil</h1>

    <table>
        <thead>
            <th>id</th>
            <th>login</th>
            <th>prenom</th>
            <th>email</th>
            <th>rôle</th>
        </thead>
        <tbody>


    </form>

    
            <?php

            foreach ($res as $utilisateur) {
                echo '<tr><form method="post" action="">
                    <td> <input type="text"  value="' . $utilisateur[0] . '" name="id"></td>
                    <td> <input type="text" value="' . $utilisateur[1] . '" name="login"></td>
                    <td> <input type="text" value="' . $utilisateur[2] . '" name="prenom"></td>
                    <td> <input type="text" value="' . $utilisateur[3] . '" name="email"></td>
                    <td> <select name="statut" >
                    <option name="uti" value="utilisateur">utilisateur</option>
                    <option name="modo" value="moderateur">moderateur</option>
                    <option name="administrateur" value="administrateur">administrateur</option>
               </select></td><
               <td>   <input type="submit" name="env"  Envoyer /> </td>
               <td>   <input type="submit"  name=ban value="Bannir"/> </td>
                    </form> </tr>';
            }


            ?>
        </tbody>
    </table>


    <?php


    $bdd = mysqli_connect("localhost", "root", "", "blog");


    //    j'ai récup les infos d'article avec ma req
    $req = mysqli_query($bdd, "SELECT articles.id, articles.titre,articles.article,articles.id_categorie,articles.date,utilisateurs.login FROM articles INNER JOIN utilisateurs ON utilisateurs.id = articles.id_utilisateur");

    $res = mysqli_fetch_all($req, MYSQLI_ASSOC);
    $id = $res[0]['id'];
    $login = $res[0]['login'];
    $titre = $res[0]['titre'];
    $article = $res[0]['article'];

    if (isset($_POST['ban'])) {
        $id1 = $_POST['id'];

        $reqban = mysqli_query($bdd, "DELETE FROM articles WHERE id = $id");
    }


    // Un if pour que quand les infos sont def, qu'elle puisse update les infos dans la bdd
    if (isset($_POST['envarticle'])) {
        $titre1 = $_POST['titre'];
        $article1 = $_POST['article'];
        $id = $_POST['id'];


        $req = ("UPDATE articles SET titre= '$titre1' , article= '$article1' WHERE  id = $id");
        var_dump($req);
        $req2 = mysqli_query($bdd, $req);
    }

    ?>
    <form action="#" method="post">




    </form>

    <h1>Tableau</h1>
    <table>
        <thead>
            <th>ID </th>
            <th>Titre</th>
            <th>Article</th>
            <th>login</th>

        </thead>
        <tbody>
            <?php
            //   Foreach pour afficher les articles
            foreach ($res as $articles) {
                echo '<tr><form method="post" action="">
           <td> <input type="titre"  value="' . $articles['id'] . '" name="id"></td>
           <td> <input type="titre"  value="' . $articles['titre'] . '" name="titre"></td>
           <td> <input type="article"  value="' . $articles['article'] . '" name="article"></td>
           <td> <input type="text" value="' . $articles['login'] . '" name="login"> </td>
           <td>   <input type="submit" name="envarticle"  Envoyer /> </td>
           <td>   <input type="submit"  name=ban value="Bannir"/> </td>
           </form> </tr>';
            }


            ?>
        </tbody>
    </table>
</body>

<?php

$req3 = mysqli_query($bdd, "SELECT * FROM categories");
$res3 = mysqli_fetch_all($req3, MYSQLI_ASSOC);


?>

<h1>Categorie</h1>
<table>
    <thead>
        <th>nom</th>
    </thead>
    <tbody>
        <?php

        foreach ($res3 as $categorie) {
            echo '<tr><form method="post" action="">
            <td> <input type="titre"  value="' . $categorie['id'] . '" name="id"></td>
            <td> <input type="titre"  value="' . $categorie['nom'] . '" name="nom"></td>
            <td>   <input type="submit" name="envcategorie"  Envoyer /> </td>
            <td>   <input type="submit"  name="ban" value="Bannir"/> </td>
            </form> </tr>';

            
        

        if (isset($_POST['ban'])) {
            
            $idcate = $_POST['id'];
            

            $reqban = mysqli_query($bdd, "DELETE FROM categories WHERE id = $idcate");
            var_dump($reqban);
        }
}




        //  creer categorie
        echo '<tr><form method="post" action="">
       <td> <input type="titre"  placeholder="Crrer une categorie" value="" name="creercategorie"></td>
       <td> <input type="submit" name="categorie"  Envoyer /> </td>
       </form> </tr>';




        if (isset($_POST['categorie'])) {
            $nomcategorie = $_POST['creercategorie'];
            $reqcreercate = mysqli_query($bdd, "INSERT INTO categories (nom) VALUES ('$nomcategorie')");
            header("Location: admin.php");
            var_dump($reqcreercate);
        }


        ?>
    </tbody>
</table>


</body>

</html>
<?php
ob_end_flush();
?>