<?php
session_start();
if(isset($_POST['name'],$_POST['mdp'] ) ) {
    if( ( !empty($_POST['name']) ) && (!empty($_POST['mdp'] ) ) ) {        
        $nom=$_POST['name'];         
        //nous considérons que le mdp est déja haché lors de l'inscription 
        include 'db_connect.php';
        $requete=$pdo->prepare("SELECT * FROM administrateur WHERE username=:username");
        //$requete existe tant que le prepare() réussit même si elle ne contient rien
        //donc vaut mieus utiliser le $info   
        $requete->execute([
            'username'=>$nom
        ]);
        $info=$requete->fetch(PDO::FETCH_ASSOC);
        if($info){            
            if(password_verify($_POST['mdp'],$info['mdp'])){
                if($info['approbation']==1){
                    $_SESSION['verif']=true;
                    $_SESSION['last_move'] = time();
                    $_SESSION['id_admin']=$info['id_admin'];
                    $_SESSION['nom']=$info['nom'];
                    $_SESSION['prenom']=$info['prenom'];
                    header("location:tableau_bord.php");
                    exit();
                }else{
                    header("location:login.php?erreur=0");
                    exit();
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