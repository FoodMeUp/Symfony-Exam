<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
/**
 * Ingredients
 *
 * @ORM\Table(name="ingredients")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IngredientsRepository")
 */
class Ingredients
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="origfdcd", type="integer")
     */
    private $origfdcd;

    /**
     * @var string
     *
     * @ORM\Column(name="origfdnm", type="string", length=255)
     */
    private $origfdnm;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\IngredientsCategories", inversedBy="ingredients")
     */
    private $category;

    /**
     * @var array
     *
     * @ORM\Column(name="components", type="json_array")
     */
    private $components;

//    /**
//     * @var Collection|IngredientComponents[]
//     *
//     * @ORM\OneToMany(targetEntity="AppBundle\Entity\IngredientComponents", mappedBy="ingredient", cascade={"persist"})
//     */
//    private $components;
//
//    /**
//     * Constructor
//     */
//    public function __construct()
//    {
//        $this->components = new \Doctrine\Common\Collections\ArrayCollection();
//    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set origfdcd
     *
     * @param integer $origfdcd
     *
     * @return Ingredients
     */
    public function setOrigfdcd($origfdcd)
    {
        $this->origfdcd = $origfdcd;

        return $this;
    }

    /**
     * Get origfdcd
     *
     * @return integer
     */
    public function getOrigfdcd()
    {
        return $this->origfdcd;
    }

    /**
     * Set origfdnm
     *
     * @param string $origfdnm
     *
     * @return Ingredients
     */
    public function setOrigfdnm($origfdnm)
    {
        $this->origfdnm = $origfdnm;

        return $this;
    }

    /**
     * Get origfdnm
     *
     * @return string
     */
    public function getOrigfdnm()
    {
        return $this->origfdnm;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\IngredientsCategories $category
     *
     * @return Ingredients
     */
    public function setCategory(\AppBundle\Entity\IngredientsCategories $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\IngredientsCategories
     */
    public function getCategory()
    {
        return $this->category;
    }

//    /**
//     * Add component
//     *
//     * @param \AppBundle\Entity\IngredientComponents $component
//     *
//     * @return Ingredients
//     */
//    public function addComponent(\AppBundle\Entity\IngredientComponents $component)
//    {
//        $this->components[] = $component;
//
//        return $this;
//    }
//
//    /**
//     * Remove component
//     *
//     * @param \AppBundle\Entity\IngredientComponents $component
//     */
//    public function removeComponent(\AppBundle\Entity\IngredientComponents $component)
//    {
//        $this->components->removeElement($component);
//    }
//
//    /**
//     * Get components
//     *
//     * @return \Doctrine\Common\Collections\Collection
//     */
//    public function getComponents()
//    {
//        return $this->components;
//    }

    /**
     * Set components
     *
     * @param array $components
     *
     * @return Ingredients
     */
    public function setComponents($components)
    {
        $this->components = $components;

        return $this;
    }

    /**
     * Get components
     *
     * @return array
     */
    public function getComponents()
    {
        return $this->components;
    }
}
