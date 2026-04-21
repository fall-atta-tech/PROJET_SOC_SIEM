 <?php 
  session_start();
 if(isset($_POST['host'],$_POST['ip'],$_POST['mac'],$_POST['type'],$_POST['local'],$_SESSION['verif'])){
    if(!empty($_POST['host']) && !empty($_POST['ip']) && !empty($_POST['mac']) && !empty($_POST['type']) 
    && !empty($_POST['local']) && $_SESSION['verif']){
     include 'db_connect.php';
     $search=$pdo->prepare("SELECT statut FROM administrateur WHERE id_admin=:id");
     $search->execute([
      'id'=>$_SESSION['id_admin']
     ]);
     $add=$search->fetch(PDO::FETCH_ASSOC);
     if(($add['statut']=='Technicien')){
      header("location:form_ajout?erreur==3");
     }else{
       $host=$_POST['host'];
        $ip=$_POST['ip'];
        $mac=$_POST['mac']; 
        $type=$_POST['type'];
        $local=$_POST['local']; 
        $etat=$_POST['etat'];
        $pattern="/^([0-9A-F]{2}:){5}[0-9A-F]{2}$/i";      
        include 'db_connect.php';
        if(!(filter_var($ip,FILTER_VALIDATE_IP) && preg_match($pattern,$mac))){
            header("location:form_ajout.php?erreur=0");
            exit;
        }
        else{   
            try{//essaie d'executer le script
              $inserer=$pdo->prepare("INSERT INTO equipement (nom_eq,ad_ip,ad_mac,type_eq,localisation_eq,id_admin) 
              VALUES (:host,:ip,:mac,:typ,:loc,:id_admin)");
              $inserer->execute([
                'host'=>$host,-
                'ip'=>$ip,
                'mac'=>$mac,
                'typ'=>$type,
                'loc'=>$local 
                'id_admin'=>$_SESSION['id_admin']               
              ]);
              $id=$pdo->lastInsertId();
              //lastInsertId() est une fonction permettant de prélever l'id du dernier eq inserter
              try{
                $inserer=$pdo->prepare("INSERT INTO sante(etat,id_equipement) VALUES (:etat,:id_eq)");
              $inserer->execute([
                'etat'=>$etat,
                'id_eq'=>$id
              ]);
              $modif="Ajout de l'éqipement".$host."(IP: ".$ip.")";
              $prio='INFO';
              $inserer=$pdo->prepare("INSERT INTO journal_audit(modif,priorite,id_equipement,id_admin) VALUES (:modif,:prio,:id_eq,:id_admin)");
              $inserer->execute([
                'modif'=>$modif,
                'prio'=>$prio,
                'id_eq'=>$id,
                'id_admin'=>$_SESSION['id_admin']
              ]);
              }catch (PDOEXCEPTION $e) {
                header("location:form_ajout.php?erreur=2");
                exit;
              }
               header("location:tableau_bord.php?succes=0");
               exit;          
            }catch (PDOEXCEPTION $e) {           
            if(($e->getcode())==23000){
                header("location:form_ajout.php?erreur=1");
                exit;
            } else{
                header("location:form_ajout.php?erreur=2");
            }
            //23000 est le numéro de l'erreur du doublons
        }         
        }
     } 
    }    
              
    }
?>