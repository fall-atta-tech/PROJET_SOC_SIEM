<html>
  <meta http-equiv="refresh" content="30">
    <link rel='stylesheet' href='decor.css'>
 <?php
 session_start();
 try{
   include 'db_connect.php';
 $demande=$pdo->prepare("SELECT (modif,priorite,date_modif) FROM journal_audit ORDER BY date_modif DESC");
 $demande->execute();
 echo"<table>";
 echo"<tr><th>Priorité</th>";
 echo"<th>Date Evénement</th></tr>";
 while($message=$demande->fetch(PDO::FETCH_ASSOC)){
    $classe=htmlspecialchars($message['priorite']); 
    echo"<tr class='$classe'><td>".$classe."</td>";
    echo"<td>".htmlspecialchars($message['modif'])."</td>";
    echo"<td>".htmlspecialchars($message['date_modif'])."</td></tr>";
 }
 echo"</table>";
 //même si j'avais déja stockées l'host ds les page d'ajout et de supression il y aura tjrs un risque
 }catch (PDOEXCEPTION $e){
   echo"<h5>Erreur : Serveur en panne</h5>";
 } 
 ?>
</html>