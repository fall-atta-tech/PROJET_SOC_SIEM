<style>
    .deco{
        display:flex;
        justify-content:center;
        font-weight:bold;
    }
</style>
<?php
$tab=parse_ini_file('.env');//cette fonction permet de transformer les éléments de .env en tableau associatif
$host=$tab['host'];
$dbname=$tab['dbname'];
$user=$tab['user'];
$pass=$tab['pass'];
try {
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4",$user,$pass);
$pdo->setAttribute(pdo::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
echo "<div class='deco'>Saytou-Net:connexion au SIEM établie</div>";
}catch (PDOException $e) {
    echo "Saytou-Net : le serveur de logs est innacessible.";
}
/*PDO par défaut PDO renvoie false dés qu'il ya erreur : il est silencieux
setAttribute sert à changer ce comportement permettant la signalisation dés qu'il 
y a erreur PDO::ATTR_ERRMODE :ici, c'est le "Mode de rapport d'erreur"
PDO::ERRMODE_EXCEPTION : C'est la valeur que tu choisis. 
En choisissant "EXCEPTION",on demandes à PDO de lancer une PDOException dès qu'une erreur survient.
sans try catch même si l'erreur est trouvée elle ne sera pas signaléenn*/
?>