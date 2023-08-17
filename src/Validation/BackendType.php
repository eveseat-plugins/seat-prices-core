<?php

namespace RecursiveTree\Seat\PricesCore\Validation;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class BackendType implements ValidationRule
{

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure(string): PotentiallyTranslatedString $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $backends = array_keys(config('priceproviders.backends'));

        if(!in_array($value,$backends)) {
            $fail('pricescore::settings.unknown_price_provider_type')->translate(['type'=>$value]);
        }
    }
}