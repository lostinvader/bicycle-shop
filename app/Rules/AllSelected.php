<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\DataAwareRule;
use App\Repositories\Product\ProductRepository;

class AllSelected implements DataAwareRule,ValidationRule
{
    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];
  
    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $product = resolve(ProductRepository::class)->findById($this->data['id'], 'parts.variants.variants');

        $disabled = [];
        $selected = array_filter($value, 'strlen');

        if( count($selected) != count($product['parts']) ){
            $fail('Invalid Selection: Please select all required parts before proceeding with your purchase.');
        }

    }
}
