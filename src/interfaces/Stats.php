<?php

namespace App\Interfaces;

/**
 * @author Diego Feliú <diego.feliud@gmail.com>
 */
interface Stats {
    /**
     * Get rating points per player
     */
    public function ratingPoints(string $position): int;
}
