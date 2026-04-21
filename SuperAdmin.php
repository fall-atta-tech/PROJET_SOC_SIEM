<html>
    <link rel='stylesheet' href='decor.css'>
<?php
session_start();
if(isset($_SESSION['verif'],$_SESSION['id_admin'])){
    if($_SESSION['verif']){
        include 'db_connect.php';
        /*par mesure de sécurité je m'assure que l'utilisateur a les droits nécessaires 
        l'utilisateur est éjecter s'il n'est pas superadmin || s'il n'est pas approuvé  */
          $search=$pdo->prepare("SELECT statut,approbation FROM administrateur WHERE id_admin=:id");
          $search->execute([
          'id'=>$_SESSION['id_admin']
          ]);
          $add=$search->fetch(PDO::FETCH_ASSOC);
          if(($add['statut']=='Technicien')||($add['approbation']==0)){
          header("location:login.php?erreur==0");
          exit;
          }else{
            
        $demande=$pdo->prepare("SELECT * FROM administrateur WHERE id_admin!=:mon_id");
        /*le ON sert à relier 2 colonnes de tables différentes
        ici on appelle l'etat de l'équipement à tavers la table
        sante d'ou le LEFT JOIN aprés on ne peut mettre un select*/
        $demande->execute([
            'mon_id'=>$_SESSION['id_admin']
        ]);
        echo"<table>";
        echo"<tr>";
        echo"<th>Nom</th>";
        echo"<th>Prenom</th>";
        echo"<th>Username</th>";
        echo"<th>Role</th>";
        echo"<th>Etat</th>";
        echo"<th>Approuver</th>";
        echo"<th>Promouvoir</th>";
        echo"<th>Révoquer</th>";
        echo"</tr>";
     while($admin=$demande->fetch(PDO::FETCH_ASSOC)){
          $approbation=(($admin['approbation']==1)?'Approuvé(e)':'En attente...'); 
          echo"<tr>";
          echo"<td>".htmlspecialchars($admin['nom'])."</td>";
          echo"<td>".htmlspecialchars($admin['prenom'])."</td>";
          echo"<td>".htmlspecialchars($admin['username'])."</td>";
          echo"<td>".htmlspecialchars($admin['statut'])."</td>";
          echo"<td>".$approbation."</td>";
          //on récupére en même temps l'id de l'admin pour savoir ou effectuer l'action et l'action pour savoir laquelle effectuer
          echo"<td><a href='gestion_admin.php?id=$admin['id_admin']&action=approuver' class='.appro'>Approuver</a>";
          echo"<td><a href='gestion_admin.php?id=$admin['id_admin']&action=promouvoir' class='.promo'>Promouvoir</a>";
          echo"<td><a href='gestion_admin.php?id=$admin['id_admin']&action=revoquer' class='.revoc'>Révoquer</a>";
          echo"</tr>";
        }
          echo"</table>";
    }
}else{
    header("location:login.php?erreur==0");
    exit;
}
}
?>
</html>