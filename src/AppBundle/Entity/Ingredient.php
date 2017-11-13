<?php declare(strict_types=1);
/**
 * PHP version 7
 *
 * Created by PhpStorm.
 * User: alexandre_vinet
 * Date: 09/11/17
 * Time: 09:06
 *
 * @category   Symfony-Exam
 *
 * @package    AppBundle
 *
 * @subpackage AppBundle\Entity
 *
 * @author     Alexandre Vinet <contact@alexandrevinet.fr>
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Ingredient
 *
 * @ORM\Entity()
 * @ORM\Table()
 */
class Ingredient
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned"=true})
     * @ORM\Id()
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
     * @ORM\Column(name="origfdnm", type="string")
     */
    private $origfdnm;

    /**
     * @var IngredientCategory
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\IngredientCategory", inversedBy="ingredients")
     */
    private $category;

    /**
     * @var Collection|IngredientComponent[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\IngredientComponent", mappedBy="ingredient", cascade={"persist"})
     */
    private $components;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->components = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set origfdcd
     *
     * @param int $origfdcd
     *
     * @return Ingredient
     */
    public function setOrigfdcd(int $origfdcd): Ingredient
    {
        $this->origfdcd = $origfdcd;

        return $this;
    }

    /**
     * Get origfdcd
     *
     * @return int
     */
    public function getOrigfdcd(): int
    {
        return $this->origfdcd;
    }

    /**
     * Set origfdnm
     *
     * @param string $origfdnm
     *
     * @return Ingredient
     */
    public function setOrigfdnm(string $origfdnm): Ingredient
    {
        $this->origfdnm = $origfdnm;

        return $this;
    }

    /**
     * Get origfdnm
     *
     * @return string
     */
    public function getOrigfdnm(): string
    {
        return $this->origfdnm;
    }

    /**
     * Set category
     *
     * @param IngredientCategory $category
     *
     * @return Ingredient
     */
    public function setCategory(IngredientCategory $category = null): Ingredient
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return IngredientCategory
     */
    public function getCategory(): IngredientCategory
    {
        return $this->category;
    }

    /**
     * Add component
     *
     * @param IngredientComponent $component
     *
     * @return Ingredient
     */
    public function addComponent(IngredientComponent $component): Ingredient
    {
        $this->components[] = $component;
        $component->setIngredient($this);

        return $this;
    }

    /**
     * Remove component
     *
     * @param IngredientComponent $component
     */
    public function removeComponent(IngredientComponent $component): void
    {
        $this->components->removeElement($component);
        $component->setIngredient();
    }

    /**
     * Get components
     *
     * @return Collection|IngredientComponent[]
     */
    public function getComponents(): Collection
    {
        return $this->components;
    }
}
