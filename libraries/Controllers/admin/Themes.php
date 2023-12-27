<?php

namespace Controllers\Admin;

class Themes extends \Controllers\Admin
{
   protected $modelName = \Models\Themes::class;
   
   protected $nameCrud = "Themes";
   
   protected $pageTitle = "Gestion des Themes";
    
    
    
    public function create(array $data=[])
    {
        //tester les champs
        if (empty($_POST['name_theme']))
        {
        //si un des champs est vide
        \Session::addFlash('error', 'le(s) champ(s) obligatoire(s) n\'ont/n\'a pas été rempli(s)');
        //rediriger l'utilisateur vers le formulaire 
        \Http::redirectBack();
        }
        
        //je traite le formulaire
        $data['name'] = $_POST['name_theme'];
        //si on arrive ici on peut insérer 
        parent::create($data);
    }
    
    public function newForm() 
    {
        //titre de la page
        $this->pageTitle = "Création d'un theme";
        
        parent::newForm();
    }
    
    public function update(array $data=[])
    {
        //je teste les champs du nom du thème et de l'Id
        if (empty($_POST['name_theme']) || empty($_POST['id']))
        {
        //au moins un des 3 champs est vide
        \Session::addFlash('error', 'le(s) champ(s) obligatoire(s) n\'ont/n\'a pas été rempli(s)');
        //rediriger l'utilisateur vers le formulaire 
        \Http::redirectBack();
        }
        
        //traite le formulaire
        $data['name'] = $_POST['name_theme'];
        $data['Id'] = intval($_POST['id']);
        //si on arrive ici on peut insérer le nouveau thème
        parent::update($data);   
    }  
}