<?php

namespace Controllers;

class Themes extends Controller 
{
    protected $modelName = \Models\Themes::class;
   
    public function index() {
                
        //je controle que $_GET['id'] existe bien 
        if (isset($_GET['id']) && ctype_digit($_GET['id'])) 
        {
            //recupération du nom du thème
            $themes = $this->model->find(intval($_GET['id']));
                
            $prodModel = new \Models\Realisations();
                
            $prodList = $prodModel->findAllByRealisations_ID(intval($_GET['id']));
                
            //je rajoute le nom du thème et la liste des réalisations dans $this->tplVars
            $this->tplVars = $this->tplVars + [
                'themes_name' => $themes['name'],
                'prods' => $prodList
            ];
                
            //affichage
            \Renderer::show("realisations",$this->tplVars);
        }
        else {
            throw new \Exception('Impossible d\'afficher la page des réalisations');
        }

        
    }
}