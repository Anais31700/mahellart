<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//pour definir le chemin vers le projet
define('WWW_URL', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));

//fichier qui contient toutes les données de configuration comme l'acces à la base de données
require_once("configuration.php");


//essaie de l'action sinon redirige vers l'erreur
try {

    //chargement automatique des fichiers contenant les objects necessaires dans le script
    require_once("libraries/autoload.php");

    //création de l'instance du controller et appel de la méthode principale
    \Application::process();
} catch (Exception $e) {
    // Si il y a eu la moindre erreur :
    \Renderer::showError([
        'code' => $e->getCode(),
        'message' => $e->getMessage()
    ]);
}
