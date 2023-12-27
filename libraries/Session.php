<?php

/* CLASSE DE GESTION DE LA SESSION (Y COMPRIS LES MESSAGES D'ERREUR !) */
class Session
{
     
     public static function redirectIfNotConnected()
     {
         if (!self::isConnected()) {
             
             \Http::redirect(WWW_URL."index.php?controller=user&task=loginForm");
         }
     }
          
     public static function redirectIfNotAdmin()
     {
         //déjà s'il est pas connecté on le redirige
         self::redirectIfNotConnected();
         
         //s'il est connecté mais pas admin, on le déconnect
         if ($_SESSION['user']['admin']!=1) {
             \Http::redirect(WWW_URL."index.php?controller=user&task=out");
         }
     }
     

    public static function connect(array $user)
    {
        $_SESSION['user'] = $user;
    }
    
    public static function disconnect()
    {
        $_SESSION['user'] = null;
    }
    
    public static function isConnected(): bool
    {
        return !empty($_SESSION['user']);
    }

    public static function isAdmin(): bool
    {
        return isset($_SESSION['user']) && $_SESSION['user']['admin'] == 1;
    }
    
     public static function getFirstName(): string
    {
        return htmlspecialchars($_SESSION['user']['prenom']);
    }
    
    public static function getId(): int
    {
        return intval($_SESSION['user']['Id']);
    }
    
    public static function addFlash(string $type, string $message)
    {
        if (empty($_SESSION['messages'])) {
            $_SESSION['messages'] = [
                'error' => [],
                'success' => [],
            ];
        }
        $_SESSION['messages'][$type][] = $message;
    }

    public static function getFlashes(string $type): array
    {
        if (empty($_SESSION['messages'])) {
            return [];
        }

        $messages = $_SESSION['messages'][$type];

        $_SESSION['messages'][$type] = [];

        return $messages;
    }

    public static function hasFlashes(string $type): bool
    {
        if (empty($_SESSION['messages'])) {
            return false;
        }

        return !empty($_SESSION['messages'][$type]);
    }
    
    public static function setToken($token)
    {
        $_SESSION['token'] = $token;
    }
    
    public static function getToken()
    {
        if (isset($_SESSION['token']))
        {
          return $_SESSION['token'];  
        }
        
        return false; 
    }
    
    public static function deleteToken()
    {
        unset($_SESSION['token']);
    }

}
