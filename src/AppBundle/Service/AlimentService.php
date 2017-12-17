<?php

namespace AppBundle\Service;

use AppBundle\Entity\Aliment;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\CacheItemPoolInterface;

class AlimentService extends AbstractService
{
    /**
     * AlimentService constructor.
     *
     * @param CacheItemPoolInterface $cache
     * @param EntityManagerInterface $em
     */
    public function __construct(CacheItemPoolInterface $cache, EntityManagerInterface $em)
    {
        parent::__construct($cache, $em);
    }

    /**
     * @param int $code
     *
     * @return Aliment
     */
    public function getOne(int $code): Aliment
    {
        return $this->callRepoMethod(Aliment::class, 'getOne', $code);
    }

    /**
     * @param $string
     *
     * @return array|mixed
     */
    public function get(string $string): array
    {
        return $this->callRepoMethod(Aliment::class, 'get', $string);
    }
}
