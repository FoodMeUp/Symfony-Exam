<?php
namespace App\Entity;

use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/** @ORM\Entity */
class Ingredient
{
    /**
     * @var Uuid
     *
     * @Groups({"all"})
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     *
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @Groups({"all"})
     * @ORM\Column(type="string") */
    private $name;

    /**
     * @var iterable
     *
     * @Groups({"all"})
     * @ORM\Column(type="json")
     */
    private $energies = [];

    /**
     * @var iterable
     *
     * @Groups({"all"})
     * @ORM\Column(type="json")
     */
    private $nutrients = [];

    /**
     * @Groups({"all"})
     * @ORM\ManyToOne(targetEntity="IngredientFamily", inversedBy="ingredients")
     */
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
