<?php

namespace LaraSlim\Kernel\Providers;

use Illuminate\Validation\Factory;

abstract class BaseRequest
{
    /**
     * The data to be validated.
     *
     * @var array<string, mixed>
     */
    protected array $data = [];

    /**
     * Constructor to initialize the data.
     *
     * @param  array<string, mixed>  $data  The data to be validated.
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Validate the data against the defined rules.
     *
     * @return \Illuminate\Contracts\Validation\Validator The validator instance.
     */
    public function validate()
    {
        /** @phpstan-ignore function.notFound */
        $validator = app(Factory::class);

        $validation = $validator->make(
            $this->data,
            $this->rules(),
            $this->messages()
        );

        return $validation;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string> Array of validation rules where keys are field names and values are rules
     */
    abstract protected function rules(): array;

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string> Array of custom messages
     */
    protected function messages(): array
    {
        return [];
    }
}
