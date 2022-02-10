<?php
session_start();
$bdd = new PDO("mysql:host=localhost;dbname=blog;charset=utf8", "root", "");
$articlesParPage = 5;
$articlesTotalesReq = $bdd->query('SELECT id FROM articles');
$articlesTotales = $articlesTotalesReq->rowCount();
$pagesTotales = ceil($articlesTotales/$articlesParPage);
if(isset($_GET['start']) AND !empty($_GET['start']) AND $_GET['start'] > 0 AND $_GET['start'] <= $pagesTotales) {
   $_GET['start'] = intval($_GET['start']);
   $pageCourante = $_GET['start'];
} else {
   $pageCourante = 1;
}
$depart = ($pageCourante-1)*$articlesParPage;
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<header>
<?php include("include/header.php") ?></header>


<main>                        
<br>                       
</main>                        
                        
                        
                        
                        


   </body>
<footer>
<?php include("include/footer.php") ?>
</footer>
</body>
</html>

