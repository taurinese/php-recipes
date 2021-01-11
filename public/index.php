<?php

use App\Models\Recipe;
use App\Storage\MySqlDatabaseRecipeStorage;
use App\Storage\SessionRecipeStorage;
use App\RecipeManager;
use Dotenv\Dotenv;
require(__DIR__ . "/../vendor/autoload.php");


session_start();
/* $_SESSION = []; */
if(!isset($_SESSION['recipes'])) $_SESSION['recipes'] = array();

$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();


try {
    $db = new PDO("{$_ENV['DB_CONNECTION']}:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8", "{$_ENV['DB_USER']}", "{$_ENV['DB_PASSWORD']}", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); //affichage des erreurs
} catch (Exception $e) {
    die($e->getMessage());
}

$storage = new MySqlDatabaseRecipeStorage($db);
$session = new SessionRecipeStorage();


/* $recipe = new Recipe;
$recipe->setCreatedAt(new DateTime());
$recipe->setName('Fondant au chocolat mi-cuit');
$recipe->setDescription('La recette du fameux fondant au chocolat micuit.');
$recipe->setPersons(4);
$recipe->setPreparationTime(40); // En minutes

$session->store($recipe);
print_r($_SESSION);
$_SESSION = []; */

$recipe = new Recipe();
/*
// MYSQL
// Get all recipes
$storage = new MySqlDatabaseRecipeStorage($db);
print_r($storage->all());
// Create a recipe
$recipe->setCreatedAt(new DateTime())
 ->setName('Fondant au chocolat mi-cuit')
 ->setDescription('La recette du fameux fondant au chocolat micuit.')
 ->setPersons(4)
 ->setPreparationTime(40); 
$recipeId = $storage->store($recipe);
print_r($storage->get($recipeId));
// Update a recipe
$recipe = $storage->get(4);
$recipe->setName('Test');
var_dump($recipe);
$storage->update($recipe); */


// Session
// Get all recipes
$storage = new SessionRecipeStorage();
$manager = new RecipeManager($storage);
var_dump($storage->all());
// Create a recipe
$recipe->setCreatedAt(new DateTime())
 ->setName('Fondant au chocolat mi-cuit')
 ->setDescription('La recette du fameux fondant au chocolat micuit.')
 ->setPersons(4)
 ->setPreparationTime(40);
$addedRecipe = $manager->addRecipe($recipe);
// Update (and get)
$recipe = $manager->getRecipe(0);
$recipe->setPreparationTime(60);
$manager->updateRecipe($recipe);
// Recipes
$recipes = $manager->getRecipes();
print_r($recipes);





//echo $recipe->getCreatedAt()->format('d/m/Y H:i');


