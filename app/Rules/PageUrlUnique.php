<?php

namespace App\Rules;

use App\Models\Page;
use Illuminate\Contracts\Validation\Rule;

class PageUrlUnique implements Rule
{
    protected $subject;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Page::withAllTranslations()->where($attribute, '=', $value)->where('id', '!=', $this->subject)->count() == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('This URL is already in use');
    }
}
