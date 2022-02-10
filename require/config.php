<?php 


function debug($var){
    echo'<pre>';
    var_dump($var);
    echo'</pre>';
}


define('DB_SERVER', 'localhost');
define('DB_LOGIN', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'blog');
 

$conn = mysqli_connect(DB_SERVER, DB_LOGIN, DB_PASSWORD, DB_NAME);
 

if($conn === false){
    die("ERREUR : Impossible de se connecter. " . mysqli_connect_error());
}


?>