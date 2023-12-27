<?php

namespace Controllers;

class Home extends Controller 
{
    public function index() 
    {
        //affichage de la page d'accueil
        \Renderer::show("home",$this->tplVars);
    }
}