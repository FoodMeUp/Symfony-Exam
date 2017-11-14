<?php declare(strict_types=1);
/**
 * PHP version 7
 *
 * Created by PhpStorm.
 * User: alexandre_vinet
 * Date: 12/11/17
 * Time: 11:01
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
use JMS\Serializer\Annotation as Serializer;

/**
 * Class IngredientCategory
 *
 * @ORM\Entity()
 * @ORM\Table(indexes={
 *      @ORM\Index(name="ingredient_category_search_name", columns={"origgpfr"})
 *     })
 */
class IngredientCategory
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
     * @var float
     *
     * @ORM\Column(name="origgpcd", type="float")
     */
    private $origgpcd;

    /**
     * @var string
     *
     * @ORM\Column(name="origgpfr", type="string")
     */
    private $origgpfr;

    /**
     * @var Collection|Ingredient[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ingredient", mappedBy="category")
     *
     * @Serializer\Exclude()
     */
    private $ingredients;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
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
     * Set origgpcd
     *
     * @param float $origgpcd
     *
     * @return IngredientCategory
     */
    public function setOriggpcd($origgpcd): IngredientCategory
    {
        $this->origgpcd = $origgpcd;

        return $this;
    }

    /**
     * Get origgpcd
     *
     * @return float
     */
    public function getOriggpcd(): float
    {
        return $this->origgpcd;
    }

    /**
     * Set origgpfr
     *
     * @param string $origgpfr
     *
     * @return IngredientCategory
     */
    public function setOriggpfr($origgpfr): IngredientCategory
    {
        $this->origgpfr = $origgpfr;

        return $this;
    }

    /**
     * Get origgpfr
     *
     * @return string
     */
    public function getOriggpfr(): string
    {
        return $this->origgpfr;
    }

    /**
     * Add ingredient
     *
     * @param Ingredient $ingredient
     *
     * @return IngredientCategory
     */
    public function addIngredient(Ingredient $ingredient): IngredientCategory
    {
        $this->ingredients[] = $ingredient;

        return $this;
    }

    /**
     * Remove ingredient
     *
     * @param Ingredient $ingredient
     */
    public function removeIngredient(Ingredient $ingredient): void
    {
        $this->ingredients->removeElement($ingredient);
    }

    /**
     * Get ingredients
     *
     * @return Collection|Ingredient[]
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }
}
