<html>
    <header>
       <title>Connexion</title> 
       <link rel=stylesheet href='styler.css'>
    </header>
    <body>
        <head>
            <h1>SOC</h1>
            <p>Connectez-vous pour accéder au tableau de bord</p>
        </head>
        <main>
            <?php
            if(isset($_GET['erreur'])){
                if($_GET['erreur']==0){
                    echo"<h4>Accés Refusé.Veuillez attendre l'approbation de l'administrateur</h4>";
                }else if($_GET['erreur']==1){
                    echo"<h5>Accés Refusé.Vérifier vos informations</h5>";
                }                
            }else if(isset($_GET['succes']) && $_GET['succes']==1){
                echo"<h3>Bienvenue cher(e) collégue</h3>";
            }
            ?>
            <form method='post' action='connexion.php'>
                <div>
                   <label for='name'>Identifiant</label>
                   <input type='text' name='name' id='name' required> 
                </div >
                <div>
                   <label for='mdp'>Mot de passe</label>
                   <input type='password' name='mdp' id='mdp' required>
                </div>
                <div>
                   <button type='submit'>Connexion</button>
                </div>
                <a href='inscription.php'>S'inscrire</a>
            </form>
        </main>
    </body>
</html>