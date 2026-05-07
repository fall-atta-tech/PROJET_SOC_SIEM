<?php
session_start();
?>
<html>
  <meta http-equiv="refresh" content="30">
  <link rel='stylesheet' href='decor.css'> 
<?php
  include'filtre.php';
 if (isset($_SESSION['last_move']) && (time() - $_SESSION['last_move']) < 1800){
   if(isset($_SESSION['verif'],$_SESSION['id_admin'])){
    if($_SESSION['verif']){
      include 'db_connect.php';
      $search=$pdo->prepare("SELECT statut,approbation FROM administrateur WHERE id_admin=:id");
      $search->execute([
       'id'=>$_SESSION['id_admin']
      ]);
      $add=$search->fetch(PDO::FETCH_ASSOC);
      if($add['approbation']==0){        
        header("location:login.php?erreur=0");
        exit; 
      }else if($add['statut']=='Technicien'){
        header("location:tableau_bord.php?erreur=0");
        exit;         
      }else{        
          try{ 
             $demande=$pdo->prepare("SELECT * FROM journal_audit ORDER BY date_modif DESC");
             $demande->execute();              
            if(isset($_GET['prio'])){
              if($_GET['prio']!='logs'){
                $demande=$pdo->prepare("SELECT * FROM journal_audit WHERE priorite=:prio ORDER BY date_modif DESC");
                $demande->execute([
                 'prio'=>$_GET['prio']
                ]);              
              }else if($_GET['prio']='logs'){
               $demande=$pdo->prepare("SELECT * FROM journal_audit ORDER BY date_modif DESC");
               $demande->execute();
              }
            }            
          }catch (PDOEXCEPTION $e){
            echo"Erreur détectée : ".$e->getMessage(); 
          }
          echo"<table>";
          echo"<tr><th>Priorité</th>";
          echo"<th>Evénement</th>"; 
          echo"<th>Date</th></tr>";          
          while($message=$demande->fetch(PDO::FETCH_ASSOC)){
            $classe=htmlspecialchars($message['priorite']); 
            echo"<tr class='".$classe."'><td>".$classe."</td>";
            echo"<td>".htmlspecialchars($message['modif'])."</td>";
            echo"<td>".htmlspecialchars($message['date_modif'])."</td></tr>";
          }
          echo"</table>";       
        }         
      }else{
        header("location:login.php?erreur==0");
        exit;
      }
     }else{
      header("location:login.php?erreur==0");
      exit;
     }
  }else{
  header("location:deconnexion.php");
  exit;
 }
?>
</html>