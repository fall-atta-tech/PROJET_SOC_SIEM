<html>
    <header>
       <title>Inscription</title> 
       <link rel=stylesheet href='styler.css'>
    </header>
    <body>
        <head>
            <h1>SOC</h1>            
        </head>
        <main>   
            <?php
              if(isset($_GET['erreur'])){
                if($_GET['erreur']==0){
                    echo"<h4>Format d'adresse IP ou MAC invalide</h4>";
                }else if($_GET['erreur']==1){
                     echo"<h4>Cet équipement existe déja</h4>";
                }else if($_GET['erreur']==2){
                     echo"<h5>Erreur serveur en panne</h5>";
                }else if($_GET['erreur']==3){
                  echo"<h4>Vous ne disposez pas des droits nécessaires pour effectuer cette action</h4>";
                }               
                }
            ?>         
            <form method='post' action='ajout.php'>
                <div>
                   <label for='host'>Hostname</label>
                   <input type='text' name='host' id='host' required> 
                </div >
                <div>
                   <label for='type'>Type d'équipement</label>
                   <input type='text' name='type' id='type' required> 
                </div >
                <div>
                   <label for='ip'>Adresse IP</label>
                   <input type='text' name='ip' id='ip' required> 
                </div >
                <div>
                   <label for='mac'>Adresse MAC</label>
                   <input type='text' name='mac' id='mac' required>
                </div>
                <div>
                   <label for='local'>Localisation</label>
                   <input type='text' name='local' id='local' required> 
                </div >
                <div>
                   <label for='etat'>Etat</label>
                   <input type='text' name='etat' id='etat' required> 
                </div >                
                <div>
                   <button type='submit'>Ajouter</button>
                </div>                
            </form>
        </main>
    </body>
</html>
