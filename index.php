<?php

define('ABS_PATH', getcwd() . DIRECTORY_SEPARATOR);
define('DB_DIR', ABS_PATH . 'src' . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR);

require 'vendor/autoload.php';

use App\Player;
use App\Team;
use App\BasketballStats;
use App\HandballStats;

define('SPORTS', [
    'basketball' => 'player name;nickname;number;team name;position;scored points;rebounds;assists',
    'handball' => 'player name;nickname;number;team name;position;goals made;goals received',
]);

function main() {
    $handle = null;
    try {
        $dir = DB_DIR;
        if ($handle = opendir($dir)):
            while (false !== ($entry = readdir($handle))) :
                if ($entry != "." && $entry != "..") {
                    $file = $dir . $entry;

                    getMVPPlayer($file);
                }
            endwhile;
        endif;
    } catch (Exception $ex) {
        print_r($ex->getMessage());
    } finally {
        if (isset($handle)):
            closedir($handle);
        endif;
    }
}

main();

function getMVPPlayer($file): void {
    $mvps = [];

    $dbArray = file($file);

    // Validate Format
    $fileSport = mb_strtolower(trim($dbArray[0]), 'UTF-8');
    if (!array_key_exists($fileSport, SPORTS)):
        throw new Exception(sprintf("The sport %s is not recognized", ucFirst($fileSport)));
    endif;

    $currentSport = mb_strtolower(trim($dbArray[0]));
    unset($dbArray[0]);

    // If exists we validate the number of date per line
    $nDataPerLine = explode(';', SPORTS[$fileSport]);

    $teams = [];

    // Create stats
    foreach ($dbArray as $line):
        // Get data by line
        $data = explode(';', $line);

        // Validate data line format 
        if (count($data) != count($nDataPerLine)):
            throw new Exception("The number of data is not valid");
        endif;

        // Create a player
        $player = new Player($data[0], $data[1], (int) $data[2], $data[4]);

        // Create a stats
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

        // Create a team
        $team = null;
        if (count($teams) == 0 || !array_key_exists($data[3], $teams)):
            $team = new Team($data[3]);
            $teams[$data[3]] = $team;
        else:
            $team = $teams[$data[3]];
        endif;

        $team->addPlayer($player);
    endforeach;

    // Calc team total points
    $totalPoints = 0;
    $finalTeam = null;
    foreach ($teams as $team):
        if ($totalPoints == 0 || $team->totalPoints() > $totalPoints):
            $totalPoints = $team->totalPoints();
            $finalTeam = $team;
        endif;
    endforeach;

    $finalTeam->setWon(true);

    $mvpPlayer = $finalTeam->mvpPlayer();

    echo $mvpPlayer;
}
