<?php
namespace App\Repository;

use App\Entity\Ingredient;
use App\Entity\IngredientFamily;

interface IngredientRepository
{
    /**
     * Get a single ingredient through its uuid
     *
     * @throws IngredientNotFound
     */
    public function get($id): Ingredient;

    public function search(?IngredientFamily $family, string $name, string $sortBy = 'id'): iterable;

    public function save(Ingredient $ingredient): void;
}
