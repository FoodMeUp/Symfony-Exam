<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
/**
 * IngredientsCategories
 *
 * @ORM\Table(name="ingredients_categories")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IngredientsCategoriesRepository")
 */
class IngredientsCategories
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
     * @var float
     *
     * @ORM\Column(name="origgpcd", type="float")
     */
    private $origgpcd;

    /**
     * @var string
     *
     * @ORM\Column(name="origgpfr", type="string", length=255)
     */
    private $origgpfr;

    /**
     * @var Collection|Ingredients[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ingredients", mappedBy="category")
     */
    private $ingredients;


    /**
     *  Constructor
     */
    public function __construct()
    {
         $this->ingredients = new ArrayCollection();
    }

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
     * Set origgpcd
     *
     * @param float $origgpcd
     *
     * @return IngredientsCategories
     */
    public function setOriggpcd($origgpcd)
    {
        $this->origgpcd = $origgpcd;

        return $this;
    }

    /**
     * Get origgpcd
     *
     * @return float
     */
    public function getOriggpcd()
    {
        return $this->origgpcd;
    }

    /**
     * Set origgpfr
     *
     * @param string $origgpfr
     *
     * @return IngredientsCategories
     */
    public function setOriggpfr($origgpfr)
    {
        $this->origgpfr = $origgpfr;

        return $this;
    }

    /**
     * Get origgpfr
     *
     * @return string
     */
    public function getOriggpfr()
    {
        return $this->origgpfr;
    }

    /**
     * Add ingredient
     *
     * @param \AppBundle\Entity\Ingredients $ingredient
     *
     * @return IngredientsCategories
     */
    public function addIngredient(\AppBundle\Entity\Ingredients $ingredient)
    {
        $this->ingredients[] = $ingredient;

        return $this;
    }

    /**
     * Remove ingredient
     *
     * @param \AppBundle\Entity\Ingredients $ingredient
     */
    public function removeIngredient(\AppBundle\Entity\Ingredients $ingredient)
    {
        $this->ingredients->removeElement($ingredient);
    }

    /**
     * Get ingredients
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }
}
