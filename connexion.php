<?php
session_start();
if(isset($_POST['name'],$_POST['mdp'] ) ) {
    if( ( !empty($_POST['name']) ) && (!empty($_POST['mdp'] ) ) ) {        
        $nom=htmlspecialchars($_POST['name']);         
        //nous considérons que le mdp est déja haché lors de l'inscription 
        include'db_connect.php';
        $requete=$pdo->prepare("SELECT username,mdp,statut FROM administrateur WHERE username=:username");
        //$requete existe tant que le prepare() réussit même si elle ne contient rien
        //donc vaut mieus utiliser le $info   
        $requete->execute(['username'=>$nom]);
        $info=$requete->fetch(PDO::FETCH_ASSOC);
        if($info){            
            if(password_verify($_POST['mdp'],$info['mdp'])){
                if($info['statut']==1){
                    $_SESSION['verif']=true;
                    header("location:tableau_bord.php");
                    exit();
                }else{
                    header("location:login.php?erreur=0");
                }
            }else{
                header("location:login.php?erreur=1");
                exit();
            }
        }else{            
            header("location:login.php?erreur=1");            
        }
    }
}
?>