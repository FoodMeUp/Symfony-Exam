<?php declare(strict_types=1);
/**
 * PHP version 7
 *
 * Created by PhpStorm.
 * User: alexandre_vinet
 * Date: 12/11/17
 * Time: 11:09
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

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class IngredientComponent
 *
 * @ORM\Entity()
 * @ORM\Table()
 */
class IngredientComponent
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
     * @ORM\Column(name="value", type="float", options={"unsigned"=true}, nullable=true)
     */
    private $value;

    /**
     * < >
     *
     * @var string
     *
     * @ORM\Column(name="operator", type="string",  nullable=true)
     */
    private $operator;

    /**
     * @var bool
     *
     * @ORM\Column(name="traces", type="boolean", nullable=true)
     */
    private $traces;

    /**
     * @var IngredientComponentType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\IngredientComponentType", inversedBy="ingredientComponents", cascade={"persist"})
     */
    private $type;

    /**
     * @var Ingredient
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ingredient", inversedBy="components")
     *
     * @Serializer\Exclude()
     */
    private $ingredient;

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
     * Set value
     *
     * @param float $value
     *
     * @return IngredientComponent
     */
    public function setValue(float $value): IngredientComponent
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * Set operator
     *
     * @param string $operator
     *
     * @return IngredientComponent
     */
    public function setOperator(string $operator): IngredientComponent
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * Get operator
     *
     * @return string
     */
    public function getOperator(): string
    {
        return $this->operator;
    }

    /**
     * Set traces
     *
     * @param bool $traces
     *
     * @return IngredientComponent
     */
    public function setTraces(bool $traces): IngredientComponent
    {
        $this->traces = $traces;

        return $this;
    }

    /**
     * Get traces
     *
     * @return bool
     */
    public function isTraces(): bool
    {
        return $this->traces;
    }

    /**
     * Set type
     *
     * @param IngredientComponentType $type
     *
     * @return IngredientComponent
     */
    public function setType(IngredientComponentType $type = null): IngredientComponent
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return IngredientComponentType
     */
    public function getType(): IngredientComponentType
    {
        return $this->type;
    }

    /**
     * Set ingredient
     *
     * @param Ingredient $ingredient
     *
     * @return IngredientComponent
     */
    public function setIngredient(Ingredient $ingredient = null): IngredientComponent
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * Get ingredient
     *
     * @return Ingredient
     */
    public function getIngredient(): Ingredient
    {
        return $this->ingredient;
    }
}
