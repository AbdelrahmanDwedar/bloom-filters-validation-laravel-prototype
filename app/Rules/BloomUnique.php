<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Redis;
use App\Models\User;

class BloomUnique implements ValidationRule
{
    protected $filterName;

    public function __construct(string $filterName)
    {
        $this->filterName = $filterName;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Redis::executeRaw(['BF.EXISTS', $this->filterName, $value])) {
            // Check database only if Bloom filter indicates possible existence
            if (User::where($this->filterName, $value)->exists()) {
                $fail('The :attribute has already been taken.');
            }
        }
    }
}
