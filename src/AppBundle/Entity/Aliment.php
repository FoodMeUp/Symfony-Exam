<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aliment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\AlimentRepository")
 */
class Aliment
{

    /**
     * @var integer
     *
     * @ORM\Column(name="code", type="integer")
     * @ORM\Id
     */
    protected $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="groupName", type="string", nullable=true)
     */
    protected $groupName;

    /**
     * @var string
     *
     * @ORM\Column(name="sousGroupName", type="string", nullable=true)
     */
    protected $sousGroupName;

    /**
     * @var integer
     *
     * @ORM\Column(name="eau", type="integer", nullable=true)
     */
    protected $eau;

    /**
     * @var integer
     *
     * @ORM\Column(name="proteine", type="integer", nullable=true)
     */
    protected $proteine;

    /**
     * @var integer
     *
     * @ORM\Column(name="glucide", type="integer", nullable=true)
     */
    protected $glucide;

    /**
     * @var integer
     *
     * @ORM\Column(name="lipide", type="integer", nullable=true)
     */
    protected $lipide;

    /**
     * @var integer
     *
     * @ORM\Column(name="sucre", type="integer", nullable=true)
     */
    protected $sucre;

    /**
     * @var integer
     *
     * @ORM\Column(name="amidon", type="integer", nullable=true)
     */
    protected $amidon;

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param int $code
     *
     * @return Aliment
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Aliment
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     *
     * @return Aliment
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;

        return $this;
    }

    /**
     * @return string
     */
    public function getSousGroupName()
    {
        return $this->sousGroupName;
    }

    /**
     * @param string $sousGroupName
     *
     * @return Aliment
     */
    public function setSousGroupName($sousGroupName)
    {
        $this->sousGroupName = $sousGroupName;

        return $this;
    }

    /**
     * @return int
     */
    public function getEau()
    {
        return $this->eau;
    }

    /**
     * @param int $eau
     *
     * @return Aliment
     */
    public function setEau($eau)
    {
        $this->eau = $eau;

        return $this;
    }

    /**
     * @return int
     */
    public function getProteine()
    {
        return $this->proteine;
    }

    /**
     * @param int $proteine
     *
     * @return Aliment
     */
    public function setProteine($proteine)
    {
        $this->proteine = $proteine;

        return $this;
    }

    /**
     * @return int
     */
    public function getGlucide()
    {
        return $this->glucide;
    }

    /**
     * @param int $glucide
     *
     * @return Aliment
     */
    public function setGlucide($glucide)
    {
        $this->glucide = $glucide;

        return $this;
    }

    /**
     * @return int
     */
    public function getLipide()
    {
        return $this->lipide;
    }

    /**
     * @param int $lipide
     *
     * @return Aliment
     */
    public function setLipide($lipide)
    {
        $this->lipide = $lipide;

        return $this;
    }

    /**
     * @return int
     */
    public function getSucre()
    {
        return $this->sucre;
    }

    /**
     * @param int $sucre
     *
     * @return Aliment
     */
    public function setSucre($sucre)
    {
        $this->sucre = $sucre;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmidon()
    {
        return $this->amidon;
    }

    /**
     * @param int $amidon
     *
     * @return Aliment
     */
    public function setAmidon($amidon)
    {
        $this->amidon = $amidon;

        return $this;
    }
}
