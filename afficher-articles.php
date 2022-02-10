<?php
session_start();
ini_set('display_errors','off');
$bdd = new PDO("mysql:host=localhost;dbname=blog;charset=utf8", "root", "");
$req=  $bdd->query('SELECT login,articles.article, articles.id_utilisateur FROM utilisateurs, articles');  

$articlesParPage = 5;
$articlesTotalesReq = $bdd->query('SELECT id FROM articles');
$articlesTotales = $articlesTotalesReq->rowCount();
$pagesTotales = ceil($articlesTotales/$articlesParPage);
//adapter la pagination par rapport au nombre d'articles dans la catégorie
if(isset($_GET['start']) AND !empty($_GET['start']) AND $_GET['start'] > 0 AND $_GET['start'] <= $pagesTotales) {
   $_GET['start'] = intval($_GET['start']);
   $pageCourante = $_GET['start'];
} else {
   $pageCourante = 1;
}
$depart = ($pageCourante-1)*$articlesParPage;
?>
<html>

<head>
    <title>articles</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/afficher-articles.css">
    <link rel="stylesheet" href="css/header.css">
    

</head>     

<body>
<header>
<?php include("include/header.php") ?></header>
<div class="formulaire">
<p>categorie :</p>
            <form method="GET" action="">
            <select name="categorie" >
         
</br>

                    <option  value="1">Recettes</option>
                    <option value="2">Nouvelles recettes</option>
                    <option value="3">Communauté</option>
               </select>
</br></br>
               <input type="submit"   value="Entrer"/>
               <br>
               
            <?php
           

      $categorie = $_GET["categorie"]; 
      $categories = $bdd->prepare('SELECT login, date, titre,article, id_categorie, articles.id AS idarticles FROM articles INNER JOIN categories ON categories.id = articles.id_categorie INNER JOIN utilisateurs ON articles.id_utilisateur = utilisateurs.id where id_categorie = ? ORDER BY articles.date DESC LIMIT '.$depart.','.$articlesParPage);
      $categories->execute(array($categorie));
      $result=$categories->fetchAll(PDO::FETCH_ASSOC);  
      
      foreach($result AS $res) {

      ?> 
  
      
            <b>Titre:<?php echo $res['titre']; ?></b>
            </br></i> article écrit par: <?php echo $res['login']; ?> </br>
            <a id="afiicherarticles" href='articles.php?idarticle=<?php echo $res['idarticles']; ?> '> voir l'article.</a>
            </b> posté le : <?php echo $res['date']; ?>
            <br /><br />
            <?php
      }

      ?>

      
            <?php
      for($i=1;$i<=$pagesTotales;$i++) {
         if($i == $pageCourante) {
            echo $i.' ';
         } else {
            echo '<a id="afiicherarticles" href="afficher-articles.php?categorie='.$categorie.'&start='.$i.'">'.$i.'</a> ';
         }
      }
      ?>
      </div>
</body>

</html>