<?php

namespace Controllers;

class Contact extends Controller 
{
   //contruction du nom du modele à utiliser
   protected $modelName = \Models\Contact::class;
      
   public function index() 
   {
        //affichage
        \Renderer::show("contact",$this->tplVars);
        
    }
    
    public function create() 
    {
        //quels controle on doit faire avant de lancer une insertion dans la base ?
        
        //vérifier la présence des champs obligatoire
          
        if (empty($_POST['firstname']) ||
            empty($_POST['lastname']) ||
            empty($_POST['mail']) ||
            empty($_POST['objet']) ||
            empty($_POST['message'])) 
        {
            //au moins un des champs obligatoires non rempli
            \Session::addFlash('error', 'au moins un des champs obligatoires non rempli !');
            //rediriger l'utilisateur vers le formulaire
            \Http::redirectBack();
        }        
        
        //vérifier le format de l'email
        //utiliser filter_var('bob@example.com', FILTER_VALIDATE_EMAIL)
        if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
        {
            //l'email n'est pas au bon format
            \Session::addFlash('error', 'l\'email n\'est pas au bon format !');
            //rediriger l'utilisateur vers le formulaire
           \Http::redirectBack();
        }
        
        if ($this->model->create($_POST))
        {
            //le compte a bien été créé
            \Session::addFlash('success','Votre mail a bien été envoyé');
            
            
            //rediriger l'utilisateur vers la page d'accueil
            \Http::redirect(WWW_URL);
        }
        else {
            //l'insertion a échouée
            \Session::addFlash('error','l\'envoie du mail a échoué');
            //rediriger l'utilisateur vers le formulaire
            \Http::redirectBack();
        }    
    }
}