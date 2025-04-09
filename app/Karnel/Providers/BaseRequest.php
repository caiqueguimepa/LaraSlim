<?php

namespace LaraSlim\Karnel\Providers;

use Illuminate\Validation\Factory;

abstract class BaseRequest
{
    protected array $data = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function validate()
    {
        $validator = app(Factory::class);

        $validation = $validator->make(
            $this->data,
            $this->rules(),
            $this->messages()
        );

        return $validation;
    }

    abstract protected function rules(): array;

    protected function messages(): array
    {
        return [];
    }
}