<?php

declare(strict_types = 1);

namespace App\Factory;

use Valitron\Validator;

final class ValidatorFactory
{
    public string $name;

    private array $rules;

    public function __construct(string $name, array $rules)
    {
        $this->name = $name;

        $this->rules = $rules;
    }

    public function new(array $data): ?Validator
    {
        $validator = new Validator($data);

        $validator->rules($this->rules);

        return $validator;
    }
}