<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Repositories\Product\ProductRepository;
use Illuminate\Contracts\Validation\DataAwareRule;

class VariantsAllowance implements DataAwareRule, ValidationRule
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

        if( count($selected) > 1 ){
            foreach ($product['parts'] as $part) {
                $variants = $part['variants'];
                foreach ($variants as $variant) {
                    foreach ($variant['variants'] as $relation) {
                        if ($relation['pivot']['affected_disabled'] && in_array($relation['pivot']['selected_variant_id'], $selected)) {
                            $disabled[] = $relation['pivot']['affected_variant_id'];
                        }
                    }
                }
            }
        }

        if( count( array_intersect($disabled, $selected) ) ){
            $fail('Invalid Selection: The combination you selected includes a disabled option and cannot be used. Please choose a different available combination.');
        }

    }
}
