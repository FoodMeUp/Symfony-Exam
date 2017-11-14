<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ingredient
 *
 * @ORM\Table(name="ingredient")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IngredientRepository")
 */
class Ingredient
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="IngredientFamily", inversedBy="ingredients")
     */
    private $family;

    /**
     * @var iterable
     *
     * @ORM\Column(type="json")
     */
    private $energies;

    /**
     * @var iterable
     *
     * @ORM\Column(type="json")
     */
    private $nutrients;

    /**
     * Ingredient constructor.
     * @param string $name
     * @param iterable $energies
     * @param iterable $nutrients
     * @param IngredientFamily $ingredientFamily
     */
    public function __construct(string $name, iterable $energies, iterable $nutrients, IngredientFamily $ingredientFamily)
    {
        $this->name = $name;
        $this->energies = $energies;
        $this->nutrients = $nutrients;
        $this->family = $ingredientFamily;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Get family
     *
     * @return IngredientFamily
     */
    public function getFamily() : IngredientFamily
    {
        return $this->family;
    }

    /**
     * Get energies
     * @return iterable
     */
    public function getEnergies() : iterable
    {
        return $this->energies;
    }

    /**
     * Get nutrients
     * @return iterable
     */
    public function getNutrients() : iterable
    {
        return $this->nutrients;
    }
}
