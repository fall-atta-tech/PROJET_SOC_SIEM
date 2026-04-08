<?php
   session_start();
    if(isset($_GET['id'],$_SESSION['verif'])){
        if($_SESSION['verif'] && $_GET['id']==1){
          $id=$_GET['id'];
          include'bd_connect.php';
          $del=$pdo->prepare("DELETE FROM equipement WHERE id_equipement=:id_eq");
          $del->execute(['id_eq'=>$id]);
          header("location:tableau_bord.php");
          exit();
        }      
    }
?>