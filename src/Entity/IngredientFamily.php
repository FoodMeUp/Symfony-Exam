<?php
namespace App\Entity;

use Ramsey\Uuid\Uuid;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/** @ORM\Entity */
class IngredientFamily
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

    /** @ORM\OneToMany(targetEntity="Ingredient", mappedBy="family", cascade={"persist", "remove"}) */
    private $ingredients;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->ingredients = new ArrayCollection;
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }
}
