<?php

declare (strict_types = 1);

use PHPUnit\Framework\TestCase;
use App\Player;
use App\Team;
use App\BasketballStats;
use App\HandStats;

class TuentiTest extends TestCase {

    /**
     * New Basketball Player
     */
    public function testAddBasketballPlayer() {
        $line = "player 1;nick1;4;Team A;G;10;2;7";
        $data = explode(';', $line);

        $player = new Player($data[0], $data[1], (int) $data[2], $data[4]);

        $this->assertNotNull($player);
    }

    /**
     * New Handball Player
     */
    public function testAddHandballPlayer() {
        $line = "player 1;nick1;4;Team A;G;0;20";
        $data = explode(';', $line);

        $player = new Player($data[0], $data[1], (int) $data[2], $data[4]);

        $this->assertNotNull($player);
    }

    /**
     * New Team
     */
    public function testNewTeam() {
        $team = new Team('Team A');
        $this->assertNotNull($team);
    }

    /**
     * Check rating points
     */ 
    public function testRatingScore() {
        $currentSport = 'basketball';
        $line = "player 1;nick1;4;Team A;G;10;2;7";
        $data = explode(';', $line);

        $player = new Player($data[0], $data[1], (int) $data[2], $data[4]);

        $stats = null;
        switch ($currentSport):
            case 'basketball':
                $stats = new BasketballStats((int) $data[5], (int) $data[6], (int) $data[7]);
                break;
            case 'handball':
                $position = $player->getPosition();

                $initalPoints = 0;
                if ($position == 'G') :
                    $initalPoints = 50;
                elseif ($position == 'F'):
                    $initalPoints = 20;
                endif;

                $stats = new HandballStats((int) $initalPoints, (int) $data[5], (int) $data[6]);
                break;
        endswitch;
        $player->setStats($stats);

        $this->assertNotNull($player->ratingPoints());
    }

}
