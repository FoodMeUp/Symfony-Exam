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

    public function get(string $id): IngredientFamily
    {
        $queryBuilder = $this->createQueryBuilder('if');

        $queryBuilder->where('i.id = :id');

        $query = $queryBuilder->getQuery();
        $query->setParameter('id', $id);

        try {
            return $query->getSingleResult();
        } catch (NoResultException $e) {
            throw new IngredientFamilyNotFound($id, $e);
        }
    }
}
