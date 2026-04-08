<?php
SESSION_START();
if(isset($_POST['nom'],$_POST['prenom'],$_POST['username'],$_POST['mdp'])){
    if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['username']) && !empty($_POST['mdp'])){
        $nom=htmlspecialchars($_POST['nom']);
        $prenom=htmlspecialchars($_POST['prenom']);
        $username=htmlspecialchars($_POST['username']);
        $mdp=password_hash($_POST['mdp'],PASSWORD_DEFAULT);
        include'db_connect.php';
        try{//essaie d'executer le script
             $inserer=$pdo->prepare("INSERT INTO administrateur (nom,prenom,username,mdp) 
        VALUES (:nom,:prenom,:username,:mdp)");
          $inserer->execute([
            'nom'=>$nom,
            'prenom'=>$prenom,
            'username'=>$username,
            'mdp'=>$mdp
          ]);
          header('location:login.php?succes=1');
          exit();
        }catch (PDOEXCEPTION $e) {           
            if(($e->getcode())==23000){
                header("location:inscription.php?erreur=1");
            } else{
                header("location:inscription.php?erreur=2");
            }
        }      
    }/*le catch s'éxécute lorsque le code rencontre des erreurs et 
    celles ci sont stockées dans la variables $e qui est une instanciation 
    de l'objet PDOEXCEPTION la fonction getcode permet de récupérer le numéro
    de l'erreur le 23000 est le numéro de l'erreur du doublons */
}
?>