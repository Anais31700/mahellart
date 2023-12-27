<?php

namespace Controllers;

class User extends Controller 
{
    //contruction du nom du modele qui sera utilisé
    protected $modelName = \Models\User::class;
   
    public function loginForm() 
    {
      $myToken = new \Token();
        
      $this->tplVars = $this->tplVars + ['Token' => $myToken->encode(SECRETKEY)];
        
        //affichage de la page de connexion 
        \Renderer::show("login",$this->tplVars); 
    }
   
    //deconnexion
    public function out() 
    {
       \Session::disconnect();
       
       \Http::redirect(WWW_URL);  
    }
   
    public function login() 
    {
        //verifie que les champs mail et password sont remplis
        if (empty($_POST['mail']) || empty($_POST['token']) || empty($_POST['password']))
        {
            //au moins un champs est vide
            \Session::addFlash('error', 'Vous n\avez pas rempli les champs obligatoires');
            //redirige l'utilisateur vers le formulaire pour s'identifier
            \Http::redirectBack();
        }
       
        //teste le token
        $myToken = new \Token();
        
        if (!SECRETKEY == $myToken->decode($_POST['token']))
        {
            \Session::addFlash('error', 'le token a expiré');
            
            //détruit le token
            \Session::deleteToken();
            //redirige l'utilisateur vers le formulaire
            \Http::redirectBack();
        }
        
        //détruit le token
        \Session::deleteToken();
       
        //teste si le couple email/password existe bien
        if (!$this->model->verifEmailPwd($_POST['mail'], $_POST['password']))
        {
            //si l'identification est impossible
            \Session::addFlash('error', 'l\'identification est impossible');
            //redirige l'utilisateur vers le formulaire d'identification
            \Http::redirectBack();
        }
       
        //si l'identification a réussi 
        //et que l'utilisateur est Admin on le redirige vers le dashboard
        //sinon vers l'accueil du site
        if (\Session::isAdmin()) 
        {
            \Http::redirect(WWW_URL."index.php?controller=Admin\Dashboard&task=index"); 
        }
       
        \Http::redirect(WWW_URL);
    }
   
    public function index() 
    {
        //la création du token
        $myToken = new \Token();
        
        $this->tplVars = $this->tplVars + ['Token' => $myToken->encode(SECRETKEY)];
        
        //affichage nouvel utilisateur
        \Renderer::show("newUser",$this->tplVars);   
    }
    
    public function create() 
    {
        //je vérifie la présence des champs obligatoire s 
        if (empty($_POST['prenom']) ||
            empty($_POST['nom']) ||
            empty($_POST['mail']) ||
            empty($_POST['password']) ||
            empty($_POST['password2']) ||
            empty($_POST['token'])) 
        {
            //au moins un des champs n'est rempli
            \Session::addFlash('error', 'Vous n\avez pas rempli tout les champs obligatoires');
            //redirige l'utilisateur vers le formulaire
            \Http::redirectBack();
        }
        
        //tester le token
        $myToken = new \Token();
        
        if (!SECRETKEY == $myToken->decode($_POST['token']))
        {
            \Session::addFlash('error', 'le token a expiré');
            
            //détruit le token
            \Session::deleteToken();
            //rediriger l'utilisateur vers le formulaire
            \Http::redirectBack();
        }
        
        //détruit le token
        \Session::deleteToken();
        
        //je verife que le prenom et le nom ne sont pas numérique
        if (ctype_digit($_POST['prenom']) || ctype_digit($_POST['nom']))
        {
            //au moins le nom ou le prénom est numérique
            \Session::addFlash('error', 'le nom et le prénom ne peuvent pas être numérique');
            //redirige l'utilisateur vers le formulaire
            \Http::redirectBack();
        }
        
        //je vérifie le format de l'email
        if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
        {
            //si l'email n'est pas au bon format
            \Session::addFlash('error', 'l\'email n\'est pas au bon format');
            //rediriger l'utilisateur vers le formulaire
           \Http::redirectBack();
        }
        
        //je verifie que les 2 mots de passe sont identiques
        if ($_POST['password'] !== $_POST['password2'])
        {
            //les 2 mots de passe ne sont pas identiques
            \Session::addFlash('error','les 2 mots de passe ne sont pas identiques');
            //rediriger l'utilisateur vers le formulaire
            \Http::redirectBack();
        }
        
        //je verifie que le mot de passe est complexe
        if(preg_match("#[A-Z]#", $_POST['password']) 
            + preg_match("#[a-z]#", $_POST['password']) 
            + preg_match("#[0-9]#", $_POST['password']) != 3)
        {
            //si le mot de passe pas assez complexe
            \Session::addFlash('error','votre mot de passe n\'est pas assez complexe');
            //rediriger l'utilisateur vers le formulaire
            \Http::redirectBack();
        }
        
        //je vérifie si l'email existe déjà dans la BDD
        if($this->model->is_exist_user($_POST['mail']))
        {
            //si l'email existe déjà
            \Session::addFlash('error','l\'email existe déjà');
            //rediriger l'utilisateur vers le formulaire
            \Http::redirectBack();
        }
        
        //insertion du nouvel utilisateur
        if ($this->model->create($_POST))
        {
            //le compte a bien été créé
            \Session::addFlash('success','La création du compte réussie');
            //rediriger l'utilisateur vers la page d'accueil
            \Http::redirect(WWW_URL);
        }
        else {
            //la création du compte a échouée
            \Session::addFlash('error','La création du compte a échouée');
            //rediriger l'utilisateur vers le formulaire
            \Http::redirectBack();
        }    
    }
}