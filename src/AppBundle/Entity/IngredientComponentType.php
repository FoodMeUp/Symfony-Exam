<?php declare(strict_types=1);
/**
 * PHP version 7
 *
 * Created by PhpStorm.
 * User: alexandre_vinet
 * Date: 12/11/17
 * Time: 11:10
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
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class IngredientComponentType
 *
 * @ORM\Entity()
 */
class IngredientComponentType
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
     * @var string
     *
     * @ORM\Column(name="label", type="string", unique=true)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", unique=true)
     *
     * @Gedmo\Slug(fields={"label"})
     */
    private $slug;

    /**
     * @var Collection|IngredientComponent[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\IngredientComponent", mappedBy="type")
     *
     * @Serializer\Exclude()
     */
    private $ingredientComponents;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ingredientComponents = new ArrayCollection();
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
     * Set label
     *
     * @param string $label
     *
     * @return IngredientComponentType
     */
    public function setLabel(string $label): IngredientComponentType
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return IngredientComponentType
     */
    public function setSlug(string $slug): IngredientComponentType
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Add ingredientComponent
     *
     * @param IngredientComponent $ingredientComponent
     *
     * @return IngredientComponentType
     */
    public function addIngredientComponent(IngredientComponent $ingredientComponent): IngredientComponentType
    {
        $this->ingredientComponents[] = $ingredientComponent;

        return $this;
    }

    /**
     * Remove ingredientComponent
     *
     * @param IngredientComponent $ingredientComponent
     */
    public function removeIngredientComponent(IngredientComponent $ingredientComponent): void
    {
        $this->ingredientComponents->removeElement($ingredientComponent);
    }

    /**
     * Get ingredientComponents
     *
     * @return Collection|IngredientComponent[]
     */
    public function getIngredientComponents(): Collection
    {
        return $this->ingredientComponents;
    }
}
