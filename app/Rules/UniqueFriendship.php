<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Camp;
use App\Friend;

class UniqueFriendship implements Rule
{
    protected $camperId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($camperId)
    {
        $this->camperId = $camperId;
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
        $matches = Friend::where('camper_id', $this->camperId)
            ->where('friend_id', $value)
            ->count();

        return $matches === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'They are already friends.';
    }
}
