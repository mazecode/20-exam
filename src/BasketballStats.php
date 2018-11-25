<?php

namespace App;

use App\Interfaces\Stats;
use App\Player;

/**
 * @author Diego Feliú <diego.feliud@gmail.com>
 */
class BasketballStats implements Stats {

    private $score;
    private $rebounds;
    private $assist;
    private $pointsRating;

    public function __construct(int $score, int $rebounds, int $assist) {
        $this->score = $score;
        $this->rebounds = $rebounds;
        $this->assist = $assist;
        $this->pointsRating = 0;
    }

    /**
     * Get the value of pointsRating
     */
    public function getPointsRating(): int {
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
     * Generate Rating point for a player
     * 
     * Scored point Rebound Assist
     *  Guard (G) 2 3 1
     *  Forward (F) 2 2 2
     *  Center (C) 2 1 3
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
                case 'C':
                    $rating = $this->calcCenter();
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
        $score = $this->score * 2;
        $rebounds = $this->rebounds * 3;
        $assist = $this->assist * 1;

        $this->pointsRating = $score + $rebounds + $assist;

        return $this->pointsRating;
    }

    /**
     * Calculare points for Forward position 
     * 
     * @return int
     */
    private function calcForward(): int {
        $score = $this->score * 2;
        $rebounds = $this->rebounds * 3;
        $assist = $this->assist * 1;

        $this->pointsRating = $score + $rebounds + $assist;

        return $this->pointsRating;
    }

    /**
     * Calculare points for Center position 
     * 
     * @return int
     */
    private function calcCenter(): int {
        $score = $this->score * 2;
        $rebounds = $this->rebounds * 1;
        $assist = $this->assist * 3;

        $this->pointsRating = $score + $rebounds + $assist;

        return $this->pointsRating;
    }

}
