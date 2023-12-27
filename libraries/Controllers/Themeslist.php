<?php

namespace Controllers;

class Themeslist extends Controller 
{
    public function index() {
        
    //je récupère la liste des thèmes
    //creation de l'instance du model
    $ThemesModel = new \Models\Themes();
            
    $this->tplVars = $this->tplVars + ['themes' => $ThemesModel->findAll()];    

    //affichage de la liste des thèmes
    \Renderer::show("themelist",$this->tplVars);
        
    }
}