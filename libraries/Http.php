<?php

/* CLASSE QUI PERMET DE GERER LE PROTOCOLE HTTP */
class Http
{
    /**
     * Permet de rediriger l'utilisateur vers une URL
     *
     * @param string $url
     * @return void
     */
    public static function redirect(string $url)
    {
        header("Location: $url");
        exit();
    }

    /**
     * Permet de rediriger vers la page précédente
     *
     * @return void
     */
    public static function redirectBack()
    {
         if (empty($_SERVER['HTTP_REFERER']))
         {
            self::redirect(WWW_URL); 
         }
        self::redirect($_SERVER['HTTP_REFERER']);
    }

}
