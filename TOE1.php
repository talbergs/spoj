<?php

/**
 * https://www.spoj.com/problems/TOE1/
 */

fscanf(STDIN, '%d', $testCases);

while ($testCases --) {
    $game = prepped_game();
    echo is_valid($game) ? "yes\n" : "no\n";
}

function prepped_game()
{
    $rows = [];
    fscanf(STDIN, '%3s', $rows[]);
    fscanf(STDIN, '%3s', $rows[]);
    fscanf(STDIN, '%3s', $rows[]);
    fgets(STDIN);
    $rows = array_map('str_split', $rows);
    array_walk_recursive($rows, function($a) use (&$game) {
        $game[] = $a;
    });

    $gameState = [];
    $gameSpecs = ['.' => 0, 'X' => 0, 'O' => 0];

    foreach ($game as $char) {
        if (isset($gameSpecs[$char])) {
            $gameSpecs[$char]++;
            $gameState[] = $char;
        }
    }

    $oddSpareMoves = boolval($gameSpecs['.'] % 2);

    return [
        array_values($gameSpecs),
        $gameState,
        $oddSpareMoves
    ];
}

function is_valid(array $game): bool
{
    list($gameSpecs, $gameState, $oddSpareMoves) = $game;

    if (!no_double_moves(...$gameSpecs)) {
        return false;
    }

    switch (get_winner($gameState)) {
        case 'X':
            return !$oddSpareMoves;
        case 'O':
            return $oddSpareMoves;
    }

    return true;
}

function no_double_moves(int $spareMoves, int $movesX, int $movesO): bool
{
    /**
     * index = number of free moves
     * value = [X moves made, O moves made]
     */
    return [
            [5, 4],
            [4, 4],
            [4, 3],
            [3, 3],
            [3, 2],
            [2, 2],
            [2, 1],
            [1, 1],
            [1, 0],
            [0, 0],
        ][$spareMoves] === [$movesX, $movesO];
}

function get_winner(array $gameState): string
{
    $winCases = [
        [0, 1, 2],
        [3, 4, 5],
        [6, 7, 8],

        [0, 3, 6],
        [1, 4, 7],
        [2, 5, 8],

        [0, 4, 8],
        [2, 4, 6],
    ];

    foreach ($winCases as $win) {
        $f1 = $gameState[$win[0]];
        $f2 = $gameState[$win[1]];
        $f3 = $gameState[$win[2]];

        if ($f1 === $f2 && $f3 === $f2) {
            return $f1;
        }
    }

    return '';
}


