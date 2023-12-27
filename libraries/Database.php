<?php

/* FABRIQUE DE CONNEXION A LA BASE DE DONNEES (SINGLETON) */
abstract class Database
{
    /**
     * L'instance de PDO qui servira à tout notre code
     *
     * @var PDO
     */
    private static $pdo;

    /**
     * Fabrication d'une connexion PDO en Singleton
     * -----------------------------------
     * Dans cette méthode, on va vérifier si elle a déjà été appelée et si un objet
     * PDO existe déjà dans la propriété statique $pdo.
     *
     * Si il n'y a pas encore de connexion à la base de données, on la créé en se servant
     * des paramètres du fichier de configuration.
     *
     * Dans tous les cas, on retourne l'objet PDO créé auparavant ou à l'instant.
     *
     * @return PDO
     */
    public static function getInstance(): PDO
    {
        if (empty(self::$pdo)) {
            $host = DB_HOST;
            $name = DB_NAME;
            $user = DB_USER;
            $password = DB_PASSWORD;

            self::$pdo = new PDO(
                "mysql:host=$host;dbname=$name;charset=utf8",
                $user,
                $password,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                ]
            );
        }

        return self::$pdo;
    }
}


