<?php

namespace App\Models\Traits;

trait UnguardedAttributesTrait
{
    /**
     * Set the model to unguard for all attributes
     */
    public static function initializeUnguardedAttributesTrait(): void
    {
        static::unguard();
    }
}