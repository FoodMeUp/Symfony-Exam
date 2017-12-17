<?php

namespace AppBundle\Service;

use AppBundle\Entity\Repository\AlimentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\CacheItemPoolInterface;

class AbstractService
{
    /** @var  CacheItemPoolInterface */
    protected $cache;

    /** @var  EntityManagerInterface */
    protected $em;

    /**
     * AbstractService constructor.
     *
     * @param CacheItemPoolInterface $cache
     * @param EntityManagerInterface $em
     */
    public function __construct(CacheItemPoolInterface $cache, EntityManagerInterface $em)
    {
        $this->cache = $cache;
        $this->em = $em;
    }

    /**
     * Call specific method from specific repository and cache it if necessary.
     *
     * @param string $repository
     * @param string $method
     * @param string $string
     *
     * @return mixed
     */
    public function callRepoMethod(string $repository, string $method, string $string)
    {
        $objectCached = $this->cache->getItem($string);

        if (!$objectCached->isHit()) {
            $date = new \DateTime();
            $date->add(new \DateInterval('P1D'));

            $repo = $this->em->getRepository($repository);

            if (!method_exists(AlimentRepository::class, $method)) {
                return [];
            }

            $data = $repo->$method($string);

            $objectCached->set($data);
            $objectCached->expiresAt($date);
            $this->cache->save($objectCached);
        } else {
            $data = $objectCached->get();
        }

        return $data;
    }
}
