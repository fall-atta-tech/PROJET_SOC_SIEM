<?php
   session_start();
   if (isset($_SESSION['last_move']) && (time() - $_SESSION['last_move']) < 1800){
     if(isset($_GET['id'],$_SESSION['verif'])){
        if($_SESSION['verif']){
          include 'db_connect.php';
          $search=$pdo->prepare("SELECT statut FROM administrateur WHERE id_admin=:id");
          $search->execute([
          'id'=>$_SESSION['id_admin']
          ]);
          $add=$search->fetch(PDO::FETCH_ASSOC);
          if(($add['statut']=='Technicien')){
          header("location:tableau_bord.php?erreur==0");
          }else{
              try{
               $id_supp=$_GET['id'];          
               include'db_connect.php';
               $recherche=$pdo->prepare("SELECT * FROM equipement WHERE id_equipement=:id_eq");
               $recherche->execute([
                 'id_eq'=>$id_supp
                ]);
               $eq=$recherche->fetch(PDO::FETCH_ASSOC);
               $modif="ALERTE : supression définitive de ".$eq['nom_eq']." ( type : "
               .$eq['type_eq']." ) par l'administrateur ".$_SESSION['prenom']." ".$_SESSION['nom']; 
               $prio='HAUTE';
               $inserer=$pdo->prepare("INSERT INTO journal_audit(modif,priorite,id_equipement,id_admin)
               VALUES (:modif,:priorite,:id_equipement,:id_admin)");
               $inserer->execute([
                 'modif'=>$modif,
                 'priorite'=>$prio,
                 'id_equipement'=>$id_supp,
                 'id_admin'=>$_SESSION['id_admin']
                ]);         
               $del=$pdo->prepare("DELETE FROM equipement WHERE id_equipement=:id_eq");
               $del->execute(['id_eq'=>$id_supp]);
               $_SESSION['last_move'] = time();
               header("location:tableau_bord.php?succes=1");
               exit();
          } catch (PDOEXCEPTION $e){
            header("location:tableau_bord.php?erreur=1");
          }
        }      
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