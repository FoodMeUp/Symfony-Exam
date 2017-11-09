<?php
namespace App\Repository;

use Symfony\Bridge\Doctrine\RegistryInterface;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\NoResultException;

use App\Entity\Ingredient;
use App\Entity\IngredientFamily;

class IngredientDoctrineRepository implements IngredientRepository
{
    /** @var RegistryInterface */
    private $registry;

    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    public function get($id): Ingredient
    {
        $queryBuilder = $this->createQueryBuilder('i');

        $queryBuilder->where('i.id = :id');
        $queryBuilder->leftJoin(IngredientFamily::class, 'if');

        $query = $queryBuilder->getQuery();
        $query->setParameter('id', $id);

        try {
            return $query->getSingleResult();
        } catch (NoResultException $e) {
            throw new IngredientNotFound($id, $e);
        }

    }

    public function search(string $name): iterable
    {
        $queryBuilder = $this->createQueryBuilder('i');
        $queryBuilder->where('i.name LIKE :name');
        $queryBuilder->leftJoin(IngredientFamily::class, 'if');

        $query = $queryBuilder->getQuery();
        $query->setParameter('name', $name);

        yield from $query->getResult();
    }

    public function save(Ingredient $ingredient): void
    {
        $em = $this->registry->getEntityManager();

        $em->persist($ingredient);
        $em->flush($ingredient);
    }

    private function createQueryBuilder(string $alias, string $indexBy = null): QueryBuilder
    {
        $builder = new QueryBuilder($this->registry->getEntityManager());

        return $builder
            ->select($alias)
            ->from(Ingredient::class, $alias, $indexBy)
        ;
    }
}
