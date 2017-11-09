<?php
namespace App\Repository;

use Exception;
use RuntimeException;

class IngredientNotFound extends RuntimeException
{
    private $id;

    public function __construct($id, Exception $previous = null)
    {
        parent::__construct("The ingredient {$id} was not found.", 0, $previous);

        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
