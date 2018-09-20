<?php

/**
 * https://www.spoj.com/problems/WORDS1/
 */

fscanf(STDIN, '%d', $dataCtn);
while ($dataCtn--) {
    echo run() . PHP_EOL;
}

function run()
{
    fscanf(STDIN, "%d", $n);
    $G = new_g($n * 2);
    $SE = [];

    $i = 0;
    while ($n--) {
        fscanf(STDIN, '%s', $w);

        $s = $w[0];
        $e = $w[strlen($w) - 1];

        $i += 2;
        // link start -> end nodes per word
        $G[$i - 2][$i - 1] = 1;
        $SE[$i] = [$s, $e];
    }

    // link all ends towards all starts (except current edges start)
    foreach ($SE as $I => $se) {
        foreach ($SE as $I_ => $se_) {
            if ($I_ === $I) continue;
            if ($se[1] === $se_[0]) {
                $G[$I - 1][$I_ - 2] = 1;
            }
        }
    }

    // if all edges were visited, then it's linked
    $vis = [];
    dfs($G, $vis, 0);
    if (array_sum($vis) === count($G)) {
        return "Ordering is possible.";
    } else {
        return "The door cannot be opened.";
    }
}

function new_g(int $size)
{
    $adj = new SplFixedArray($size);
    for ($i = 0; $i < $size; $i++) {
        $adj[$i] = new SplFixedArray($size);
        for ($j = 0; $j < $size; $j++) {
            $adj[$i][$j] = 0;
        }
    }
    return $adj;
}

function dfs(&$G, &$vis, $row)
{
    $vis[$row] = 1;
    foreach ($G[$row] as $i => $node) {
        if ($node === 1 && !isset($vis[$i])) {
            //$G[$row][$i] = 0;
            dfs($G, $vis, $i);
        }
    }
}

function dd($G, $N, $false = 0)
{
    echo '^\$ ' . implode(' ', $N) . PHP_EOL;
    foreach ($G as $i => $row) {
        echo $N[$i] . ' |';
        foreach ($row as $j => $item) {
            echo $item ? ' 1' : ' .';
        }
        echo PHP_EOL;
    }
    $false && die;
}

