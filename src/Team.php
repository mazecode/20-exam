<?php

namespace App;

use App\Player;

/**
 * @author Diego Feliú <diego.feliud@gmail.com>
 */
class Team
{

    private $name;
    private $players;
    private $won;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->players = [];
        $this->won = false;
    }

    /**
     * Get the value of name
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of players
     */
    public function getPlayers() : array
    {
        return $this->players;
    }

    /**
     * Set the value of players
     *
     * @return  self
     */
    public function setPlayers(array $players)
    {
        $this->players = $players;

        return $this;
    }

    /**
     * Get the value of won
     */
    public function getWon() : bool
    {
        return $this->won;
    }

    /**
     * Set the value of won
     *
     * @return  self
     */
    public function setWon(bool $won)
    {
        $this->won = $won;

        return $this;
    }

    /**
     * Add player to team
     * 
     * @param Player $player
     */
    public function addPlayer(Player $player) : void
    {
        array_push($this->players, $player);
    }

    /**
     * Get total points
     * 
     * @return int
     */
    public function totalPoints() : int
    {
        $totalPoints = 0;

        foreach ($this->players as $player) :
            $totalPoints += $player->ratingPoints();
        endforeach;

        return $totalPoints;
    }

    /**
     * Obtain MVP Player
     * 
     * @return type
     */
    public function mvpPlayer() : Player
    {
        $mpv = null;
        $maxPoints = 0;

        foreach ($this->players as $player) :
            $points = $player->totalPoint();

        if ($this->won) :
            $points += 10;
        endif;

        if ($maxPoints == 0 || $points > $maxPoints) :
            $mpv = $player;
        endif;
        endforeach;

        return $mpv;
    }

    public function __toString() : string
    {
        return $this->name;
    }

}
