<html>
    <link rel='stylesheet' href='decor.css'>
 <?php
     session_start();
     if(isset($_SESSION['verif'])){
        if(!$_SESSION['verif']){
        header("location:login.php?erreur=0");
     }else{
        include 'db_connect.php';
        if(isset($_GET['erreur'],$_GET['succes'])){
         if($_GET['erreur']==0){
            echo"<h5>Vous ne disposez pas des droits nécessaires pour effectuer cette action </h5>";
         }else if($_GET['succes']==0){
            echo"<h3>Equipement ajouté avec succés</h3>";
         }else if($_GET['erreur']==1){
            echo"<h5>Serveur en panne</h5>";
         }else if($_GET['succes']==0){
            echo"<h3>Equipement ajouté avec succés</h3>";
         }
        }
        $demande=$pdo->prepare("SELECT equipement.*, sante.etat FROM equipement
        LEFT JOIN sante ON equipement.id_equipement=sante.id_equipement");
        /*le ON sert à relier 2 colonnes de tables différentes
        ici on appelle l'etat de l'équipement à tavers la table
        sante d'ou le LEFT JOIN aprés on ne peut mettre un select*/
        $demande->execute();
        echo"<div style='text-align: center;'><a href='form_ajout.php' class='decore'>+ Ajouter</a></div>";
        echo"<table>";
        echo"<tr>";
        echo"<th>Type</th>";
        echo"<th>Adrese MAC</th>";
        echo"<th>Adresse IP</th>";
        echo"<th>Localisation</th>";
        echo"<th>Statut</th>";
        echo"<th>Supression</th>";
        echo"</tr>";
     while($eq=$demande->fetch(PDO::FETCH_ASSOC)){
          echo"<tr>";
          echo"<td>".htmlspecialchars($eq['type_eq'])."</td>";
          echo"<td>".htmlspecialchars($eq['ad_mac'])."</td>";
          echo"<td>".htmlspecialchars($eq['ad_ip'])."</td>";
          echo"<td>".htmlspecialchars($eq['localisation_eq'])."</td>";
          $etat=(!empty($eq['etat']))?htmlspecialchars($eq['etat']):'attente...';
          //au cas ou il n'y aurai pas de statut   
          echo"<td><span class='formrond $etat'></span>".$etat."</td>";
          //class ne s'utilise pas directement sur td d ou le span
          echo"<td><button><a href='suppression.php?id=".$eq['id_equipement']."'
          onclick='return confirm(\"voulez-vous supprimer cet éqipement?\");'>Supprimer</a></button></td>";    
          /*oneclick est un écouteur en JS qui permet l'affichage du message de confirmation 
          de suppression que l'on voit souvent lorsqu'on veut supprimer qqchose 
          confirm permet d'afficher le message entre ces parenthéses puis la case ok et annuler  */ 
          echo"</tr>";
     }
    echo"</table>";
    }     
     }
?>
</html>