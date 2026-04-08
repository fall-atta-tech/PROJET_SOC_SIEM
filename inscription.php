<html>
    <header>
       <title>Inscription</title> 
       <link rel=stylesheet href='styler.css'>
    </header>
    <body>
        <head>
            <h1>SOC</h1>
            <p>Inscrivez-vous pour accéder au tableau de bord</p>
        </head>
        <main>   
            <?php
            if(isset($_GET['erreur'])){
               if($_GET['erreur']==1){
                  echo"<h4>Ce nom d'utilisateur est déja utilisé</h4>";
               }else if($_GET['erreur']==2){
                  echo"<h5>Erreur serveur en panne</h5>";
               }
            }
            ?>         
            <form method='post' action='traitement_inscription.php'>
                <div>
                   <label for='prenom'>Prenom</label>
                   <input type='text' name='prenom' id='prenom' required> 
                </div >
                <div>
                   <label for='nom'>Nom</label>
                   <input type='text' name='nom' id='nom' required> 
                </div >
                <div>
                   <label for='username'>Identifiant</label>
                   <input type='text' name='username' id='username' required> 
                </div >
                <div>
                   <label for='mdp'>Mot de passe</label>
                   <input type='password' name='mdp' id='mdp' required>
                </div>
                <div>
                   <button type='submit'>S'inscrire</button>
                </div>
            </form>
        </main>
    </body>
</html>
