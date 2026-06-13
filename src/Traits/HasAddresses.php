<?php

namespace Wichai\ThaiAddress\Traits;

use Wichai\ThaiAddress\Models\Address;

trait HasAddresses
{
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }
}
