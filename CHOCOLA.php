<?php declare(strict_types=1);

/**
 * https://www.spoj.com/problems/CHOCOLA/
 */

fscanf(STDIN, "%d\n", $testCases);
while ($testCases--) {
    fgets(STDIN);
    fscanf(STDIN, "%d %d", $m, $n);

    $x = [];
    for ($i = 1; $i < $m; $i ++) {
        fscanf(STDIN, "%d", $x[]);
    }

    $y = [];
    for ($i = 1; $i < $n; $i ++) {
        fscanf(STDIN, "%d", $y[]);
    }

    rsort($x);
    rsort($y);

    $N = 1;
    $M = 1;

    $totalCost = 0;
    $moves = ($m - 1) + $m * ($n - 1);

    while ($moves--) {
        if (reset($x) > reset($y)) {
            $totalCost += array_shift($x) * $M;
            $N ++;
        } else {
            $totalCost += array_shift($y) * $N;
            $M ++;
        }
    }

    echo "{$totalCost}\n";
}
