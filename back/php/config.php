<?php
    // Informations de connexion à la base de données
    $servername = 'localhost:3306'; // nom du serveur et numéro de port
    $username = 'root'; // nom d'utilisateur MySQL
    $password = ''; // mot de passe de l'utilisateur MySQL
    $dbname = 'serrano_bdd'; // nom de la base de données

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        
        // Configurer PDO pour afficher les erreurs SQL
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        //echo "Connexion réussie !";
    } 

    catch (PDOException $e) {
        echo "Erreur : ";    
        if ($e->getCode() == 1049) {
            echo "Base de données inconnue.";
        } elseif ($e->getCode() == 1045) {
            echo "Identifiant ou mot de passe incorrect.";
        } elseif ($e->getCode() == 2002) {
            echo "Impossible de se connecter au serveur de base de données.";
        } else {
            // Affiche le message d'erreur SQL
            echo $e->getMessage();
        }
    } 
?>