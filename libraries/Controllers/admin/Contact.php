<?php

namespace Controllers\Admin;

class Contact extends \Controllers\Admin
{
   protected $modelName = \Models\Contact::class;
   
   protected $nameCrud = "Contact";
   
   protected $pageTitle = "Gestion des mails";
   
   public function index() {
           
           //titre de la page
            $this->tplVars = $this->tplVars + [
                'page_title' => $this->pageTitle
            ];
            
            //liste des données
            $this->tplVars = $this->tplVars + [
                'list' => $this->model->findAll()
            ];
                
            //afficher la liste 
            \Renderer::showAdmin(strtolower($this->nameCrud)."/list",$this->tplVars);

        
    }
    
}