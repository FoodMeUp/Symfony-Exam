<?php
namespace App\Repository;

use App\Entity\IngredientFamily;

interface IngredientFamilyRepository
{
    public function get(string $id): IngredientFamily;

    public function save(IngredientFamily $family): void;
}
