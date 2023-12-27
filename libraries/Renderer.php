<?php
/* class traitant le rendu html de la page en fonction du contenu dynamique et du template */

class Renderer {
    
    public static function show(string $template, array $tplVars = [])
    {
        ob_start();
        
        require("libraries/templates/partials/$template.phtml");
        $pageContent = ob_get_clean();
        
        require('libraries/templates/layout.phtml');

    }
    
    public static function showAdmin(string $template, array $tplVars = [])
    {
        ob_start();
        
        require("libraries/templates/partials/admin/$template.phtml");
        $pageContent = ob_get_clean();
        
        require('libraries/templates/layoutAdmin.phtml');

    }
    
    public static function showError(array $tplVars = [])
    {

        require("libraries/templates/partials/error.phtml");

    }
    
    
}