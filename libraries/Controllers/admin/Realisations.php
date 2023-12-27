<?php

namespace Controllers\Admin;

class Realisations extends \Controllers\Admin
{
    protected $modelName = \Models\Realisations::class;
   
    protected $nameCrud = "Realisations";
   
    protected $pageTitle = "Gestion des Realisations";
   
    public function index() 
    {
    //Le titre de la page
    $this->tplVars = $this->tplVars + [
        'page_title' => $this->pageTitle
    ];
            
    //La liste des réalisations
    $this->tplVars = $this->tplVars + [
        'list' => $this->model->findAllWithRealisations()
    ];
                
    //Affiche la liste des réalisations
        \Renderer::showAdmin(strtolower($this->nameCrud)."/list",$this->tplVars);   
    }
    
    public function create(array $data=[])
    {
        //Teste les champs
        if (empty($_POST['name_realisation']) ||
            empty($_POST['theme']) || 
            empty($_FILES['photo_principale']['name'])
            )
        {
        //si des champs sont vides
        \Session::addFlash('error', 'le(s) champ(s) obligatoire(s) n\'ont/n\'a pas été rempli(s)');
        //rediriger l'utilisateur vers le formulaire 
        \Http::redirectBack();
        }
       
        // Teste des thèmes
        if (!intval($_POST['theme']) >0)
        {
        \Session::addFlash('error', 'le thème n\a pas été défini');
        //rediriger l'utilisateur vers le formulaire 
        \Http::redirectBack(); 
        }
            
            //Upload de la photo de la réalisation
            //test sur le format du fichier
            $allowed_file_types = ['image/png'];
       
           //teste si c'est le bon type de fichier (png) 
            if (!in_array($_FILES['photo_principale']['type'], $allowed_file_types)) 
            {
              //si c'est le mauvais format de fichier  
              \Session::addFlash('error', 'ce n\'est pas le bon format de fichier');
                //rediriger l'utilisateur vers le formulaire 
                \Http::redirectBack();  
                
            }
            
            
            //teste si le nom de la réalisation existe déjà
            if($this->model->findByName($_POST['name_realisation']) > 0)
            {
               //si le nom existe déja  
              \Session::addFlash('error', 'Une réalisation a déja ce nom');
                //rediriger l'utilisateur vers le formulaire 
                \Http::redirectBack();  
            }
            
        //traiter le formulaire
        //preparation un tableau
        $data['name'] = $_POST['name_realisation'];
    	$data['Themes_Id'] = $_POST['theme'];
        
        //si on arrive ici on va pouvoir insérer et récupérer l'id
        $newId = $this->model->insert($data);
        
        if (!$newId >0) 
        {
            //l'insertion a échouée
            \Session::addFlash('error','l\'insertion de la réalisation a échouée');
            //rediriger l'utilisateur vers le formulaire
            \Http::redirectBack();
        }
        
        
        
        //Upload de la photo de la réalisation en la renommant
        $uploaddir = 'uploads/'.strtolower($this->nameCrud).'/';
        $uploadfile = $uploaddir.$newId.".png";
        
        if (!move_uploaded_file($_FILES['photo_principale']['tmp_name'], $uploadfile))
        {
            //erreur au moment de l\'upload
            \Session::addFlash('error', 'l\'upload est non valide');
            //rediriger l'utilisateur vers le formulaire 
            \Http::redirectBack();  
        }
        
        //mise à jour de la base de données
        $data['photoGallery'] = $newId.".png";
        $data['Id'] = $newId;
        
        
        
        parent::update($data);
    }
    
    //init de la liste des thèmes
    private function initSelectList() {
        //je recupère la liste des thèmes
        $ThemesModel = new \Models\Themes();
        $this->tplVars = $this->tplVars + ['themes' => $ThemesModel->findAll()];
        
    }
    
    public function newForm() 
    {
        //titre de la page
        $this->pageTitle = "Création d'une réalisation";
        
        //initialisation des selects list
        $this->initSelectList();
        
        parent::newForm();
    }
    
    public function editForm() 
    {
        //titre de la page
        $this->pageTitle = "Edition d'une réalisation";
        
        //initialisation des selects list
        $this->initSelectList();
        
        
        parent::editForm();
    }
    
    public function update(array $data=[])
    {
       //teste les champs
        if (
            empty($_POST['name_realisation']) ||
            empty($_POST['theme'])
            )
       {
           //si un ou des champs sont vides
           \Session::addFlash('error', 'le(s) champ(s) obligatoire(s) n\'ont/n\'a pas été rempli(s)');
            //rediriger l'utilisateur vers le formulaire 
            \Http::redirectBack();
       }
       
        //je traite le formulaire
        //preparation un tableau
        $data['name'] = $_POST['name_realisation'];
    	$data['Themes_Id'] = $_POST['theme'];
    	$data['Id'] = intval($_POST['id']);
    
        parent::update($data);
        
    }
    
    
    private function uploadFile(string $name_input, string $name_file)
    {
        //je test le format du fichier
        $allowed_file_types = ['image/png'];
        
        //je choisi le dossier d'upload
        $uploaddir = 'uploads/'.strtolower($this->nameCrud).'/';
        
           if (!in_array($_FILES[$name_input]['type'], $allowed_file_types)) 
            {
                \Session::addFlash('error', 'ce n\'est pas le bon format de fichier');
                \Http::redirectBack();  
                    
            }   
            //je finalise l'upload 
            $uploadfile = $uploaddir.$name_file;

        if (!move_uploaded_file($_FILES[$name_input]['tmp_name'], $uploadfile))
        {
            \Session::addFlash('error', 'l\'upload est non valide');
            \Http::redirectBack();  
        }
        
        return true;
    }  
}