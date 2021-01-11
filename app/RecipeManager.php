<?php

namespace App;

use App\Models\Recipe;

class RecipeManager
{
    protected $storage;

    function __construct($storage)
    {
        $this->storage = $storage;
    }
    public function addRecipe(Recipe $recipe)
    {
        $id = $this->storage->store($recipe);
        return $this->getRecipe($id);
    }

    public function getRecipe(int $id)
    {
        return $this->storage->get($id);
    }

    public function updateRecipe(Recipe $recipe)
    {
        return $this->storage->update($recipe);
    }

    public function getRecipes()
    {
        return $this->storage->all();
    }
}