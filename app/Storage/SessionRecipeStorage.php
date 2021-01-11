<?php

namespace App\Storage;

use App\Models\Recipe;

class SessionRecipeStorage{

    function store(Recipe $recipe){
        if(isset($_SESSION['recipes'])) $recipe->setId(count($_SESSION['recipes']));
        else $recipe->setId(0);
        array_push($_SESSION['recipes'], $recipe);
        $recipeId = count($_SESSION['recipes']) - 1;
        return $recipeId;
        
    }
    function update(Recipe $recipe){
        $currentRecipe = '';
        foreach ($_SESSION['recipes'] as $id => $sessionRecipe) {
            if($recipe->getId() == $sessionRecipe->getId()){
                $_SESSION['recipes'][$id] = [
                    "name" => $recipe->getName(),
                    "created_at" => $recipe->getCreatedAt(),
                    "description" => $recipe->getDescription(),
                    "persons" => $recipe->getPersons(),
                    "preparation_time" => $recipe->getPreparationTime()
                ]; 
                $currentRecipe = $_SESSION['recipes'][$id];
            }
        }
        return $currentRecipe;
    }
    function get($id){
        $currentRecipe = '';
        foreach ($_SESSION['recipes'] as $id => $sessionRecipe) {
            if($id == $sessionRecipe->getId()){
                $currentRecipe = $sessionRecipe;
            }
        }
        return $currentRecipe;
    }

    function all(){
        return $_SESSION['recipes'];
    }
}