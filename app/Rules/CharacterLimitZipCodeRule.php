<?php

namespace App\Rules;

use App\Services\ZipCodeService;
use Illuminate\Contracts\Validation\Rule;

class CharacterLimitZipCodeRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return strlen($value) === 8;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Zip code need 8 characters';
    }
}
