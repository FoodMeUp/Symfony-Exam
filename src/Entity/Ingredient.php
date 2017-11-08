<?php
namespace App\Entity;

use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Ingredient
{
    /**
     * @var Uuid
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     *
     * @ORM\Column(type="uuid")
     */
    private $id;

    /** @ORM\Column(type="string") */
    private $name;

    /**
     * @var iterable
     * @ORM\Column(type="json")
     */
    private $energies = [];

    /**
     * @var iterable
     * @ORM\Column(type="json")
     */
    private $nutrients = [];

    /** @ORM\ManyToOne(targetEntity="IngredientFamily", inversedBy="ingredients") */
    private $family;

    public function __construct(IngredientFamily $family, string $name, iterable $energies, iterable $nutrients)
    {
        $this->name = $name;
        $this->family = $family;
        $this->energies = $energies;
        $this->nutrients = $nutrients;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEnergies(): iterable
    {
        return $this->energies;
    }

    public function getNutrients(): iterable
    {
        return $this->nutrients;
    }

    public function getFamily(): IngredientFamily
    {
        return $this->family;
    }
}
