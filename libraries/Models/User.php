<?php

namespace Models;

class User extends Model
{
    protected $table = T_USERS;

    // Récupère une liste d'utilisateurs avec leur statut admin
    public function findAll_Id_Admin_Fn_Ln(): array
    {
        $query = $this->db->prepare("SELECT Id, nom, prenom, admin FROM $this->table");
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getRole(int $id): int
    {
        // Vérifier que l'utilisateur est admin ou non
        $query = $this->db->prepare("SELECT admin FROM $this->table WHERE Id = :id");
        $query->execute([':id' => $id]);
        $infosUser = $query->fetch(\PDO::FETCH_ASSOC);
        return intval($infosUser['admin']);
    }

    public function is_exist_user(string $mail)
    {
        // Vérifier si l'email existe déjà
        $query = $this->db->prepare("SELECT Id FROM $this->table WHERE mail LIKE :mail");
        $query->execute([':mail' => $mail]);
        return $query->fetch(\PDO::FETCH_ASSOC) != null;
    }

    private function cryptPassword($pass)
    {
        // Hachage du mot de passe
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    public function create(array $u): bool
    {
        if ($this->is_exist_user($u['mail'])) {
            return false; // L'email existe déjà
        }

        $insertUser = [
            'prenom' => $u['prenom'],
            'nom' => $u['nom'],
            'mail' => $u['mail'],
            'password' => $this->cryptPassword($u['password'])
        ];

        return $this->insert($insertUser) > 0;
    }

    public function verifEmailPwd(string $mail, string $pwd): bool
    {
        // Vérification de l'email et du mot de passe
        $query = $this->db->prepare("SELECT Id, prenom, password, admin FROM $this->table WHERE mail LIKE :mail LIMIT 0,1");
        $query->execute([':mail' => $mail]);
        $myUser = $query->fetch(\PDO::FETCH_ASSOC);
        if (!$myUser) return false;

        if (!password_verify($pwd, $myUser['password'])) return false;

        \Session::connect([
            'Id' => intval($myUser['Id']),
            'prenom' => htmlspecialchars($myUser['prenom']),
            'admin' => intval($myUser['admin'])
        ]);
        return true;
    }

    public function createAdmin($nom, $prenom, $mail, $password): bool
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $admin = 1; // Valeur pour indiquer que c'est un administrateur

        return $this->insert([
            'nom' => $nom,
            'prenom' => $prenom,
            'mail' => $mail,
            'password' => $passwordHash,
            'admin' => $admin
        ]) > 0;
    }

    public function findAllUsers(): array
    {
        $query = $this->db->query("SELECT Id, nom, prenom, mail, admin FROM $this->table");
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function deleteUser($id): bool
    {
        $query = $this->db->prepare("DELETE FROM $this->table WHERE Id = :id");
        return $query->execute(['id' => $id]);
    }

    public function updateAdminStatus($id, $isAdmin): bool
    {
        $query = $this->db->prepare("UPDATE $this->table SET admin = :admin WHERE Id = :id");
        return $query->execute(['admin' => $isAdmin, 'id' => $id]);
    }
}
