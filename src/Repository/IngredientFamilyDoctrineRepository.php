<?php
namespace App\Repository;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\IngredientFamily;

class IngredientFamilyDoctrineRepository implements IngredientFamilyRepository
{
    /** @var RegistryInterface */
    private $registry;

    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    public function save(IngredientFamily $family): void
    {
        $em = $this->registry->getEntityManager();

        $em->persist($family);
        $em->flush($family);
    }
}
