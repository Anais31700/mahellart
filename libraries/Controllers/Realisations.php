<?php

namespace Controllers;

class Realisations extends Controller
{
    //contruction du nom du modele à utiliser
    protected $modelName = \Models\Realisations::class;

    public function index()
    {
        //controler que $_GET['id'] existe bien 
        if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
            //je récupère les informations de la réalisation 
            $this->tplVars = $this->tplVars + [
                'prod' => $this->model->findRealisations(intval($_GET['id']))
            ];
        } else {
            throw new \Exception('Impossible d\'afficher la page réalisations !');
        }
    }

    public function like()
    {
        header('Content-Type: application/json');
        $userId = \Session::getId();
        $realisationId = $_POST['realisation_id'] ?? null;

        // Vérification de la validité de l'ID de la réalisation
        if (!$realisationId || !ctype_digit($realisationId)) {
            echo json_encode(['success' => false, 'error' => 'ID de réalisation invalide']);
            return;
        }

        $model = new \Models\Realisations();
        try {
            if ($model->like($userId, $realisationId)) {
                echo json_encode(['success' => true]);
            } else {
                throw new \Exception('Erreur lors de l\'ajout du like.');
            }
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function unlike()
    {
        header('Content-Type: application/json');
        $userId = \Session::getId();
        $realisationId = $_POST['realisation_id'] ?? null;

        // Vérification de la validité de l'ID de la réalisation
        if (!$realisationId || !ctype_digit($realisationId)) {
            echo json_encode(['success' => false, 'error' => 'ID de réalisation invalide']);
            return;
        }

        $model = new \Models\Realisations();
        try {
            if ($model->unlike($userId, $realisationId)) {
                echo json_encode(['success' => true]);
            } else {
                throw new \Exception('Erreur lors de la suppression du like.');
            }
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
