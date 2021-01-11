<?php

namespace App\Storage;

use App\Models\Recipe;

class MySqlDatabaseRecipeStorage{
    protected $db;

    function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    function store(Recipe $recipe){
        $query = $this->db->prepare('INSERT INTO recipes (name, created_at, description, persons, preparation_time) VALUES (:name, :created_at, :description, :persons, :preparation_time)');
        $query->execute([
            "name" => $recipe->getName(),
            "created_at" => $recipe->getCreatedAt()->format('Y-m-d H:i:s'),
            "description" => $recipe->getDescription(),
            "persons" => $recipe->getPersons(),
            "preparation_time" => $recipe->getPreparationTime()
        ]);
        return $this->db->lastInsertId();
        
    }
    function update(Recipe $recipe){
        $query = $this->db->prepare('UPDATE recipes SET name = :name, created_at = :created_at, description = :description, persons = :persons, preparation_time = :preparation_time WHERE id = :id');
        return $query->execute([
            "id" => $recipe->getId(),
            "name" => $recipe->getName(),
            "created_at" => $recipe->getCreatedAt(),
            "description" => $recipe->getDescription(),
            "persons" => $recipe->getPersons(),
            "preparation_time" => $recipe->getPreparationTime()
        ]);
    }
    function get($id){
        $query = $this->db->prepare('SELECT * FROM recipes WHERE id = :id');
        $query->execute([
            "id" => $id
        ]);
        $query->setFetchMode(\PDO::FETCH_CLASS, "App\Models\Recipe");
        return $query->fetch();
    }

    function all(){
        $query = $this->db->query('SELECT * FROM recipes');
        return $query->fetchAll(\PDO::FETCH_CLASS, "App\Models\Recipe");
    }
}