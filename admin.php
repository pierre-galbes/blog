<!DOCTY<!DOCTYPE html>
<html>
    <head>
        <title>Cours PHP / MySQL</title>
        <meta charset="utf-8">

    </head>
    <body>
        <h1>Bases de données MySQL</h1>
        <?php
            
            
            $bdd = mysqli_connect("localhost","root","","blog");


            $req= mysqli_query($bdd," SELECT utilisateurs.id, utilisateurs.login , utilisateurs.password, utilisateurs.email, droits.nom FROM utilisateurs INNER JOIN droits ON utilisateurs.id_droits = droits.id"); 
            

            $res= mysqli_fetch_all($req); 
            var_dump($res);
            $id= $res[0][0];
            $login= $res[0][1];
            $email= $res[0][3];

            if (isset($_POST['env'])) {
                $id1=$_POST['id'];
                $login1 = $_POST['login'];
                $email1 = $_POST['email'];
                if($_POST['statut']=="utilisateur"){
                    $id_droit=1;
                }
                elseif($_POST['statut']=="administrateur"){
                    $id_droit=1337;
                }
                elseif($_POST['statut']=="moderateur"){
                    $id_droit=42;
                }

                var_dump($_POST);
                $req2= mysqli_query($bdd,"UPDATE utilisateurs SET login='$login1' , email='$email1', id_droits='$id_droit' WHERE  id = $id1 ");
                header("Location: admin.php");
                }

            ?>
            <form action="#" method="post">
            

            </form>

        <h1>Tableau</h1>
        <table>
            <thead>
                <th>id</th>
                <th>login</th>
                <th>email</th>
                <th>rôle</th>
            </thead>
           <tbody>
               <?php 
              
               foreach ($res as $utilisateur) {
                   echo '<tr><form method="post" action="">
                    <td> <input type="text"  value="'.$utilisateur[0].'" name="id"></td>
                    <td> <input type="text" value="'.$utilisateur[1].'" name="login"> </td>
                    <td> <input type="text" value="'.$utilisateur[3].'" name="email"> </td>
                    <td> <select name="statut" >
                    <option name="uti" value="utilisateur">utilisateur</option>
                    <option name="modo" value="moderateur">moderateur</option>
                    <option name="administrateur" value="administrateur">administrateur</option>
               </select></td><
               <td>   <input type="submit" name="env"  Envoyer /> </td>
               
                    </form> </tr>';
                    
               }

               
               ?>
            </tbody>
        </table>
    </body>
</html>