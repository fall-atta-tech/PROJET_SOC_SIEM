<?php 
  session_start();
 if(isset($_POST['host'],$_POST['ip'],$_POST['mac'],$_POST['type'],$_POST['local']) && $_SESSION['verif']){
    if(!empty($_POST['host']) && !empty($_POST['ip']) && !empty($_POST['mac']) && !empty($_POST['type']) && !empty($_POST['local'])){
        $host=htmlspecialchars($_POST['host']);
        $ad_ip=htmlspecialchars($_POST['ip']);
        $mac=htmlspecialchars($_POST['mac']); 
        $type=htmlspecialchars($_POST['typ']);
        $local=htmlspecialchars($_POST['local']);       
        include'db_connect.php';
        try{//essaie d'executer le script
             $inserer=$pdo->prepare("INSERT INTO equipement (nom_eq,ad_ip,ad_mac,type_eq,localisation_eq) 
             VALUES (:host,:ip,:mac,:typ,:loc)");
             $inserer->execute([
                'host'=>$host
                'ip'=>$ad_ip
                'mac'=>$mac
                'typ'=>$type
                'loc'=>$local                
             ]);             
            }catch (PDOEXCEPTION $e) {           
            if(($e->getcode())==23000){
                header("location:form_ajout.php?erreur=1");
            } else{
                header("location:form_ajout.php?erreur=2");

            }
            //23000 est le numéro de l'erreur du doublons
        }      
    }
}
?>