<?php

namespace VichOne\ThaiAddress\Traits;

use VichOne\ThaiAddress\Models\Address;

trait HasAddresses
{
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }
}
