<?php

namespace App;

use App\Interfaces\Stats;
use App\Player;

/**
 * @author Diego Feliú <diego.feliud@gmail.com>
 */
class HandballStats implements Stats {

    private $initialPoint;
    private $goalMade;
    private $goalReceived;
    private $pointsRating;

    public function __construct(int $initialPoint, int $goalMade, int $goalReceived) {
        $this->initialPoint = $initialPoint;
        $this->goalMade = $goalMade;
        $this->goalReceived = $goalReceived;
        $this->pointsRating = 0;
    }

    /**
     * Get the value of pointsRating
     */
    public function getPointsRating() : int {
        return $this->pointsRating;
    }

    /**
     * Set the value of pointsRating
     *
     * @return  self
     */
    public function setPointsRating(int $pointsRating) {
        $this->pointsRating = $pointsRating;

        return $this;
    }

    /**
     * Generate Rating point for a Player
     * 
     * Initial rating points Goal made Goal received
     *  Goalkeeper (G) 50 5 -2
     *  Field player (F) 20 1 -1
     */
    public function ratingPoints(string $position): int {
        $rating = 0;

        try {
            switch (mb_strtoupper(trim($position))):
                case 'G':
                    $rating = $this->calcGuard();
                    break;
                case 'F':
                    $rating = $this->calcForward();
                    break;
                default:
                    $rating = 0;
                    break;
            endswitch;
        } catch (Exception $ex) {
            throw new Exception("Error when trying calc rating points");
        }

        return $rating;
    }

    /**
     * Calculare points for Guard position 
     * 
     * @return int
     */
    private function calcGuard(): int {
        $goalMade = $this->goalMade * 5;
        $goalReceived = $this->goalReceived * -2;

        $this->pointsRating = $this->initialPoint + $goalMade + $goalReceived;
        
        return $this->pointsRating;
    }

    /**
     * Calculare points for Forward position 
     * 
     * @return int
     */
    private function calcForward(): int {
        $goalMade = $this->goalMade * 1;
        $goalReceived = $this->goalReceived * -1;

        $this->pointsRating = $this->initialPoint + $goalMade + $goalReceived;
        
        return $this->pointsRating;
    }
}
