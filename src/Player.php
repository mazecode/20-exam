<?php

namespace App;

use App\Team;
use App\Stats;

class Player {

    private $name;
    private $nickname;
    private $number;
    private $position;
    private $stats;

    public function __construct(string $name, string $nickname, int $number, string $position) {
        $this->name = $name;
        $this->nickname = $nickname;
        $this->number = $number;
        $this->position = $position;
    }

    /**
     * Get the value of name
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName(string $name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of nickname
     */
    public function getNickname(): string {
        return $this->nickname;
    }

    /**
     * Set the value of nickname
     *
     * @return  self
     */
    public function setNickname(string $nickname) {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get the value of number
     */
    public function getNumber(): int {
        return $this->number;
    }

    /**
     * Set the value of number
     *
     * @return  self
     */
    public function setNumber(int $number) {
        $this->number = $number;

        return $this;
    }

      /**
     * Get the value of position
     */
    public function getPosition(): string {
        return $this->position;
    }

    /**
     * Set the value of position
     *
     * @return  self
     */
    public function setPosition(string $position) {
        $this->position = $position;

        return $this;
    }

    /**
     * Get the value of stas
     */
    public function getStats() {
        return $this->stats;
    }

    /**
     * Set the value of stas
     *
     * @return  self
     */
    public function setStats($stats) {
        $this->stats = $stats;

        return $this;
    }

    /**
     * One player may play in different teams and positions in different matches, 
     * but not in the same match
     *
     * @return bool
     */
    public function isPlaying(): bool {
        return false;
    }

    public function ratingPoints() : int {
        return $this->stats->ratingPoints($this->position);
    }
    
    public function totalPoint() : int {
        return $this->stats->getPointsRating();
    }
    
    public function __toString() {
        return "MVP Player: $this->name \t Rating Points: " . $this->totalPoint() . PHP_EOL;
    }
}
