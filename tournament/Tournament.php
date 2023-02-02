<?php

/*
 * By adding type hints and enabling strict type checking, code can become
 * easier to read, self-documenting and reduce the number of potential bugs.
 * By default, type declarations are non-strict, which means they will attempt
 * to change the original type to match the type specified by the
 * type-declaration.
 *
 * In other words, if you pass a string to a function requiring a float,
 * it will attempt to convert the string value to a float.
 *
 * To enable strict mode, a single declare directive must be placed at the top
 * of the file.
 * This means that the strictness of typing is configured on a per-file basis.
 * This directive not only affects the type declarations of parameters, but also
 * a function's return type.
 *
 * For more info review the Concept on strict type checking in the PHP track
 * <link>.
 *
 * To disable strict typing, comment out the directive below.
 */

declare(strict_types = 1);

class Tournament {

    private array $teams = [];

    public function __construct() {}

    public function tally(string $scores) : string {
        $this->parseScores($scores);
        return $this->formatTeams();
    }

    private function parseScores(string $scores) : void {
        foreach (explode("\n", $scores) as $score) {
            $score = explode(';', $score);
            if (count($score) !== 3) {
                continue;
            }

            $teamOne = $score[0];
            $teamTwo = $score[1];
            $score = $score[2];

            $this->addTeam($teamOne);
            $this->addTeam($teamTwo);

            if ($score === 'win') {
                $this->win($teamOne);
                $this->loss($teamTwo);
            } else if ($score === 'loss') {
                $this->loss($teamOne);
                $this->win($teamTwo);
            } else if ($score === 'draw') {
                $this->draw($teamOne, $teamTwo);
            }
        }
    }

    private function addTeam(string $name) : void {
        if (array_key_exists($name, $this->teams)) {
            $this->teams[$name]['matches']++;
        } else {
            $this->teams[$name] = [
                'name' => $name,
                'matches' => 1,
                'wins' => 0,
                'draws' => 0,
                'losses' => 0,
                'points' => 0,
            ];
        }
    }

    private function win(string $team) : void {
        $this->teams[$team]['wins']++;
        $this->teams[$team]['points'] += 3;
    }

    private function loss(string $team) : void {
        $this->teams[$team]['losses']++;
    }

    private function draw(string $teamOne, string $teamTwo) : void {
        $this->teams[$teamOne]['draws'] += 1;
        $this->teams[$teamOne]['points'] += 1;
        $this->teams[$teamTwo]['draws'] += 1;
        $this->teams[$teamTwo]['points'] += 1;
    }

    private function sortTeams() : array {
        $sortedTeams = $this->teams;
        usort($sortedTeams, function ($teamOne, $teamTwo) {
            if ($teamOne['points'] === $teamTwo['points']) {
                return $teamOne['name'] <=> $teamTwo['name'];
            }
            return $teamTwo['points'] <=> $teamOne['points'];
        });
        return $sortedTeams;
    }

    private function formatTeams() : string {
        $output = 'Team                           | MP |  W |  D |  L |  P';
        foreach ($this->sortTeams() as $team) {
            $output .= "\n";
            $output .= $this->formatTeam($team);
        }
        return $output;
    }

    private function formatTeam(array $team) : string {
        $output = $team['name'];
        $output .= str_repeat(' ', 31 - strlen($team['name']));
        $output .= '|  '.$team['matches'];
        $output .= ' |  '.$team['wins'];
        $output .= ' |  '.$team['draws'];
        $output .= ' |  '.$team['losses'];
        $output .= ' |  '.$team['points'];
        return $output;
    }
}
