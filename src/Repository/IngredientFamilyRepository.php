<?php
namespace App\Repository;

use App\Entity\IngredientFamily;

interface IngredientFamilyRepository
{
    public function save(IngredientFamily $family): void;
}
