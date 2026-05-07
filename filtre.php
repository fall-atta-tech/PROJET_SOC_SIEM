<html>
  <link rel='stylesheet' href='decor.css'>
  <?php
  /*session_start déja utilisé sur la page historique avec include en utiliser encore ici provoquerait des erreurs*/
   if (isset($_SESSION['last_move']) && (time() - $_SESSION['last_move']) < 1800){
    if(isset($_SESSION['verif'],$_SESSION['id_admin'])){
    if($_SESSION['verif']){
      echo"<form method='get' action='historique.php'>      
      <label for='filtre'>FILTRES</label>
      <select id='filtre' name='prio'>      
       <option value='logs'>TOUS LES LOGS</option>
       <option value='haute'>Priorité HAUTE</option> 
       <option value='info'>Priorité INFO</option>
      </select> 
      <button type='submit'>envoyer</button>             
      </form>";
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