<?php

/**
 * https://www.spoj.com/problems/POUR1/
 */

fscanf(STDIN, "%d\n", $testCases);

for ($i = 0; $i < $testCases; $i++) {
    fscanf(STDIN, "%d\n", $a);
    fscanf(STDIN, "%d\n", $b);
    fscanf(STDIN, "%d\n", $c);

    echo process($a, $b, $c) . PHP_EOL;
}

function process(int $a, int $b, int $c)
{
    if ($c > $a && $c > $b) {
        return -1;
    } else if ($c % gcd($a, $b) != 0) {
        return -1;
    } else if ($c === $a || $c === $b) {
        return 1;
    }

    return min(
        pour($a, $b, $c),
        pour($b, $a, $c)
    );
}

function gcd(int $a, int $b)
{
    if ($b === 0) {
        return $a;
    }

    return gcd($b, $a % $b);
}

function pour(int $v1, int $v2, int $target)
{
    $moves = 1;
    $a = $v1;
    $b = 0;

    while ($a != $target && $b != $target) {
        $tfr = min($a, $v2 - $b);
        $b += $tfr;
        $a -= $tfr;
        $moves++;

        if ($a === $target || $b === $target) {
            break;
        }

        if ($a === 0) {
            $a = $v1;
            $moves++;
        }

        if ($b === $v2) {
            $b = 0;
            $moves++;
        }
    }

    return $moves;
}




