<?php

namespace Models;

class Contact extends Model
{
    //contient le nom de la table principale
    protected $table = T_CONTACTS;

    /*
    Id, Admin, FirstName et LastName
    */
    public function findAll(): array
    {
        $query = $this->db->prepare("SELECT Id, lastname, firstname, mail, objet, message, created_at FROM $this->table");
        
        $query->execute();
        

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    //création d'un utilisateur
    public function create(array $c):bool
    {
        $mail = [];
        
        $mail['lastname'] = $c['lastname'];
        $mail['firstname'] = $c['firstname'];
        $mail['mail'] = $c['mail'];
        $mail['objet'] = $c['objet'];
        $mail['message'] = $c['message'];
        
        if ($this->insert($mail) >0) {
            //l'insertion a réussi
            return true;
        }
        else {
            //il y a une erreur
            return false;
        }
    }
    
}

?>