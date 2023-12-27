<?php

namespace Models;

class Realisations extends Model
{
    //contient le nom de la table principale
    protected $table = T_REALISATIONS;


    //Récupère la liste des données des réalisations
    public function findAllByRealisations_ID(int $id)
    {
        $query = $this->db->prepare("SELECT * FROM $this->table WHERE Themes_Id = :id");

        $query->execute([
            ':id' => $id,
        ]);

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    //Récupère la liste des données avec le thème pour chaque réalisation
    public function findAllWithRealisations()
    {
        $query = $this->db->prepare("
        SELECT $this->table.Id, $this->table.name, " . T_THEMES . ".name AS Themes  
        FROM $this->table
        INNER JOIN " . T_THEMES . " 
        ON " . T_THEMES . ".Id = $this->table.Themes_Id");

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Retrouve un enregistrement grâce à son nom
    public function findByName(string $name): int
    {
        $query = $this->db->prepare("SELECT COUNT(*) AS Nb FROM $this->table WHERE name LIKE :name LIMIT 0,1");

        $query->execute([
            ':name' => $name,
        ]);

        $count = $query->fetch(\PDO::FETCH_ASSOC);

        return intval($count['Nb']);
    }

    public function like($userId, $realisationId)
    {
        // Vérifier si l'utilisateur a déjà liké cette réalisation
        $checkQuery = $this->db->prepare("SELECT COUNT(*) AS count FROM user_likes WHERE user_id = :user_id AND realisation_id = :realisation_id");
        $checkQuery->execute(['user_id' => $userId, 'realisation_id' => $realisationId]);
        $result = $checkQuery->fetch(\PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            // L'utilisateur a déjà liké cette réalisation, ne rien faire
            return false;
        }

        // Si non, insérer le like
        $query = $this->db->prepare("INSERT INTO user_likes (user_id, realisation_id) VALUES (:user_id, :realisation_id)");
        return $query->execute(['user_id' => $userId, 'realisation_id' => $realisationId]);
    }


    public function unlike($userId, $realisationId)
    {
        $query = $this->db->prepare("DELETE FROM user_likes WHERE user_id = :user_id AND realisation_id = :realisation_id");
        return $query->execute(['user_id' => $userId, 'realisation_id' => $realisationId]);
    }

    public function isLikedByUser($userId, $realisationId)
    {
        $query = $this->db->prepare("SELECT COUNT(*) AS count FROM user_likes WHERE user_id = :user_id AND realisation_id = :realisation_id");
        $query->execute(['user_id' => $userId, 'realisation_id' => $realisationId]);
        $result = $query->fetch(\PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    public function countLikes($realisationId)
    {
        $query = $this->db->prepare("SELECT COUNT(*) AS count FROM user_likes WHERE realisation_id = :realisation_id");
        $query->execute(['realisation_id' => $realisationId]);
        $result = $query->fetch(\PDO::FETCH_ASSOC);
        return $result['count'];
    }
}
