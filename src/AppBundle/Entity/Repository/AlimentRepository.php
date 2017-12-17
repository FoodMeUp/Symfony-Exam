<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class AlimentRepository extends EntityRepository
{
    /**
     * Get one aliment by a code.
     *
     * @param $code
     *
     * @return null|object
     */
    public function getOne($code)
    {
        return $this->findOneBy(['code' => $code]);
    }

    /**
     * Get list of aliments based on string param.
     *
     * @param $string
     *
     * @return array
     */
    public function get($string)
    {
        $qb = $this->createQueryBuilder('a');

        return $qb
            ->where('a.name LIKE :name')
            ->setParameter('name', '%' . $string . '%')
            ->getQuery()
            ->getResult()
        ;
    }
}
