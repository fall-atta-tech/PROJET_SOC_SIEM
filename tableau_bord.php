<html>
    <link rel='stylesheet' href='decor.css'>
 <?php
     session_start();
     if(isset($_SESSION['verif']) && !$_SESSION['verif']){
        header("location:login.php?erreur=0");
     }else{
        include 'db_connect.php';
        $demande=$pdo->prepare('SELECT equipement.*, sante.etat FROM equipement
        LEFT JOIN sante ON equipement.id_equipement=sante.id_equipement');
        /*le ON sert à relier 2 colonnes de tables différentes
        ici on appelle l'etat de l'équipement à tavers la table
        sante d'ou le LEFT JOIN aprés on ne peut mettre un select*/
        $demande->execute();
        echo"<table>";
        echo"<tr>";
        echo"<th>Type</th>";
        echo"<th>Adrese MAC</th>";
        echo"<th>Adresse IP</th>";
        echo"<th>Localisation</th>";
        echo"<th>ID Admin</th>";
        echo"<th>Statut</th>";
        echo"<th>Supression</th>";
        echo"</tr>";
     while($eq=$demande->fetch(PDO::FETCH_ASSOC)){
          echo"<tr>";
          echo"<td>".htmlspecialchars($eq['type_eq'])."</td>";
          echo"<td>".htmlspecialchars($eq['ad_mac'])."</td>";
          echo"<td>".htmlspecialchars($eq['ad_ip'])."</td>";
          echo"<td>".htmlspecialchars($eq['localisation_eq'])."</td>";
          echo"<td>".htmlspecialchars($eq['id_admin'])."</td>";
          $etat=(!empty($eq['etat']))?htmlspecialchars($eq['etat']):'attente...';
          //au cas ou il n'y aurai pas de statut  
          echo"<td><span class='formrond $etat'></span>".$etat."</td>";
          //class ne s'utilise pas directement sur td dou le span
          echo"<td><button><a href='suppression.php?id=$eq['id_eq']' 
          onclick="return confirm('voulez-vous supprimer cet éqipement?');">Supprimer</a></button></td>";    
          /*oneclick est un écouteur en JS qui permet l'affichage du message de confirmation 
          de suppression que l'on voit souvent lorsqu'on veut supprimer qqchose 
          confirm permet d'afficher le message entre ces parenthéses puis la case ok et annuler  */ 
          echo"</tr>";
     }
    echo"</table>";
    }     
?>
</html>