<?php
   session_start();
?>
<html>
    <link rel='stylesheet' href='decor.css'>
<?php
//le timestamp est tjrs en seconde d'ou le 1800  
if (isset($_SESSION['last_move']) && (time() - $_SESSION['last_move']) < 1800){
    if(isset($_SESSION['verif'],$_SESSION['id_admin'])){
    if($_SESSION['verif']){       
        try{
          include 'db_connect.php';
          /*par mesure de sécurité je m'assure que l'utilisateur a les droits nécessaires 
          l'utilisateur est éjecter s'il n'est pas superadmin || s'il n'est pas approuvé
          et à chaque modification apportée avec update j'en informe le journal audit avec insert */
          $search=$pdo->prepare("SELECT statut,approbation FROM administrateur WHERE id_admin=:id");
          $search->execute([
          'id'=>$_SESSION['id_admin']
          ]);
          $add=$search->fetch(PDO::FETCH_ASSOC);
          if(($add['statut']=='Technicien')||($add['approbation']==0)){
          header("location:login.php?erreur==0");
          exit;
          }else{
            if(isset($_GET['id'],$_GET['action'])){
                if($_GET['action']=='approuver'){
                    $mis_a_jour=$pdo->prepare("UPDATE administrateur SET approbation=:appro WHERE id_admin=:id");
                    $mis_a_jour->execute([
                        'appro'=>1,
                        'id'=>$_GET['id']
                    ]);
                    $recherche=$pdo->prepare("SELECT * FROM administrateur WHERE id_admin=:id");
                    $recherche->execute([
                        'id'=>$_GET['id']
                    ]);
                    $_SESSION['last_move'] = time();
                    $infos=$recherche->fetch(PDO::FETCH_ASSOC);
                    $modif=$_SESSION['prenom']." ".$_SESSION['nom']." a approuvé le compte de ".$infos['prenom']." ".$infos['nom'];                    
                    $prio='INFO'; 
                    $inserer=$pdo->prepare("INSERT INTO journal_audit(modif,priorite,id_admin) VALUES (:modif,:prio,:id_admin)");
                    $inserer->execute([
                      'modif'=>$modif,
                      'prio'=>$prio,
                      'id_admin'=>$_SESSION['id_admin']
                   ]);
                    header("location:SuperAdmin?succes=0");
                    exit;
                }else if($_GET['action']=='promouvoir'){
                    $mis_a_jour=$pdo->prepare("UPDATE administrateur SET statut=:promo WHERE id_admin=:id");
                    $mis_a_jour->execute([
                        'promo'=>'SuperAdmin',
                        'id'=>$_GET['id']
                    ]);
                    $recherche=$pdo->prepare("SELECT * FROM administrateur WHERE id_admin=:id");
                    $recherche->execute([
                        'id'=>$_GET['id']
                    ]);
                    $_SESSION['last_move'] = time();
                    $infos=$recherche->fetch(PDO::FETCH_ASSOC);
                    $modif=$_SESSION['prenom']." ".$_SESSION['nom']." a promu ".$infos['prenom']." ".$infos['nom']." au statut de SuperAdmin";
                    $prio='INFO'; 
                    $inserer=$pdo->prepare("INSERT INTO journal_audit(modif,priorite,id_admin) VALUES (:modif,:prio,:id_admin)");
                    $inserer->execute([
                      'modif'=>$modif,
                      'prio'=>$prio,
                      'id_admin'=>$_SESSION['id_admin']
                   ]);
                    header("location:SuperAdmin?succes=1");
                    exit;
                }else if($_GET['action']=='revoquer'){
                    $mis_a_jour=$pdo->prepare("UPDATE administrateur SET approbation=:rev WHERE id_admin=:id");
                    $mis_a_jour->execute([
                        'rev'=>0,
                        'id'=>$_GET['id']
                    ]);
                    $_SESSION['last_move'] = time();
                    $recherche=$pdo->prepare("SELECT * FROM administrateur WHERE id_admin=:id");
                    $recherche->execute([
                        'id'=>$_GET['id']
                    ]);
                    $infos=$recherche->fetch(PDO::FETCH_ASSOC);
                    $modif=$_SESSION['prenom']." ".$_SESSION['nom']." a révoqué le compte de ".$infos['prenom']." ".$infos['nom'];                    
                    $prio='HAUTE'; 
                    $inserer=$pdo->prepare("INSERT INTO journal_audit(modif,priorite,id_admin) VALUES (:modif,:prio,:id_admin)");
                    $inserer->execute([
                      'modif'=>$modif,
                      'prio'=>$prio,
                      'id_admin'=>$_SESSION['id_admin']
                   ]);
                    header("location:SuperAdmin.php?succes=2");
                    exit;
                } 
            }       
        }
    }catch (PDOEXCEPTION $e){
            header("location:SuperAdmin.php?erreur=0");
            exit;
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