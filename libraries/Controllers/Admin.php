<?php

namespace Controllers;


class Admin extends Controller
{
    protected $nameCrud;

    protected $pageTitle;

    public function __construct()
    {
        //je teste si l'utilisateur est bien admin
        \Session::redirectIfNotAdmin();

        //Appel du constructeur du parent
        parent::__construct();

        // Vérifie si l'utilisateur est administrateur
        if (!\Session::isAdmin()) {
            // Redirige vers la page de connexion ou une page d'erreur
            \Http::redirect(WWW_URL . "index.php?controller=user&task=loginForm");
        }

        //Envoye le nom du crud dans le template
        $this->tplVars = $this->tplVars + [
            'crud' => $this->nameCrud
        ];
    }

    public function index()
    {
        //Le titre de la page
        $this->tplVars = $this->tplVars + [
            'page_title' => $this->pageTitle
        ];

        //La liste des données
        $this->tplVars = $this->tplVars + [
            'list' => $this->model->findAll()
        ];

        //Affichage de la liste 
        \Renderer::showAdmin(strtolower($this->nameCrud) . "/list", $this->tplVars);
    }

    public function newForm()
    {
        //Le titre de la page
        $this->tplVars = $this->tplVars + [
            'page_title' => $this->pageTitle
        ];

        //Affiche la liste
        \Renderer::showAdmin(strtolower($this->nameCrud) . "/new", $this->tplVars);
    }

    public function create(array $data)
    {
        //si on arrive ici on va pouvoir insérer 
        if ($this->model->insert($data) > 0) {
            //le compte a bien été créé
            \Session::addFlash('success', 'la création a réussie');

            \Http::redirect(WWW_URL . "index.php?controller=admin\\" . $this->nameCrud . "&task=index");
        } else {
            //l'insertion a échouée
            \Session::addFlash('error', 'l\'insertion a échouée');
            //rediriger l'utilisateur vers le formulaire
            \Http::redirectBack();
        }
    }


    public function editForm()
    {
        //Controle que $_GET['id'] existe bien 
        if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
            //transmettre à $this->tplVars ces informations
            $this->tplVars = $this->tplVars + [
                'form' => $this->model->find(intval($_GET['id']))
            ];

            //Le titre de la page
            $this->tplVars = $this->tplVars + [
                'page_title' => $this->pageTitle
            ];

            //afficher la liste
            \Renderer::showAdmin(strtolower($this->nameCrud) . "/edit", $this->tplVars);
        } else {
            throw new \Exception('Impossible d\'afficher la page');
        }
    }

    public function update(array $data)
    {

        //si on arrive ici on va pouvoir insérer
        $this->model->update($data);
        \Http::redirect(WWW_URL . "index.php?controller=admin\\" . $this->nameCrud . "&task=index");
    }

    public function delete()
    {
        //Controle que $_GET['id'] existe bien 
        if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
            $this->model->delete(intval($_GET['id']));

            //si fichier dans uploads, on le supprime
            if (file_exists("uploads/" . strtolower($this->nameCrud) . "/" . intval($_GET['id']) . ".png")) {
                unlink("uploads/" . strtolower($this->nameCrud) . "/" . intval($_GET['id']) . ".png");
            }

            \Session::addFlash('success', 'La suppression a réussie');

            \Http::redirect(WWW_URL . "index.php?controller=admin\\" . $this->nameCrud . "&task=index");
        } else {
            throw new \Exception('Impossible de supprimer');
        }
    }

    public function addAdmin()
    {
        // Traitement des données du formulaire
        // Validation et nettoyage les données reçues
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $mail = $_POST['mail'];
        $password = $_POST['password'];

        $userModel = new \Models\User();
        if ($userModel->createAdmin($nom, $prenom, $mail, $password)) {
            // Ajouter un message de succès
            \Session::addFlash('success', 'Administrateur ajouté avec succès.');
            // Rediriger vers le tableau de bord admin ou une autre page appropriée
            \Http::redirect(WWW_URL . "index.php?controller=Admin\Dashboard&task=index");
        } else {
            // Ajouter un message d'erreur
            \Session::addFlash('error', 'Erreur lors de l\'ajout de l\'administrateur.');
            // Rediriger vers le formulaire d'ajout d'administrateur
            \Http::redirect(WWW_URL . "index.php?controller=Admin&task=addAdminForm");
        }
    }

    public function addAdminForm()
    {
        // Assurez-vous que seul un administrateur peut accéder à ce formulaire
        if (!\Session::isAdmin()) {
            \Http::redirect(WWW_URL . "index.php?controller=user&task=loginForm");
            return;
        }

        // Afficher le formulaire d'ajout d'administrateur
        \Renderer::showAdmin("addAdmin", $this->tplVars);
    }

    public function listUsers()
    {
        $userModel = new \Models\User();
        $users = $userModel->findAllUsers();
        $this->tplVars = $this->tplVars + ['users' => $users];
        \Renderer::showAdmin("listUsers", $this->tplVars);
    }

    public function deleteUser()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $userModel = new \Models\User();
            if ($userModel->deleteUser($id)) {
                \Session::addFlash('success', 'Utilisateur supprimé avec succès.');
            } else {
                \Session::addFlash('error', 'Erreur lors de la suppression.');
            }
        }
        \Http::redirect(WWW_URL . "index.php?controller=Admin&task=listUsers");
    }


    public function changeAdminStatus()
    {
        $id = $_GET['id'] ?? null;
        $status = $_GET['status'] ?? null;
        if ($id && $status !== null) {
            $userModel = new \Models\User();
            if ($userModel->updateAdminStatus($id, $status)) {
                \Session::addFlash('success', 'Statut modifié avec succès.');
            } else {
                \Session::addFlash('error', 'Erreur lors de la modification du statut.');
            }
        }
        \Http::redirect(WWW_URL . "index.php?controller=Admin&task=listUsers");
    }
}
