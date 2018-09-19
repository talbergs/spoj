<?php declare(strict_types=1);

/**
 * https://www.spoj.com/problems/CMPLS/
 */

fscanf(STDIN, "%d\n", $testCases);

while ($testCases--) {
    fscanf(STDIN, '%d %d', $_, $c);
    $p = array_map(
        'intval',
        explode(' ', fgets(STDIN))
    );

    $table = [];
    fill_table($p, $table);

    $res = [];
    for ($i = 0; $i < $c; $i++) {
        solve_table($table, $res);
    }

    echo implode(' ', $res) . PHP_EOL;
}

function solve_table(array &$table, array &$res)
{
    $l = count($table);

    for ($j = $l - 1; $j > 0; $j--) {
        $next = end($table[$j]) + end($table[$j - 1]);
        $table[$j - 1][] = $next;

        if ($j === 1) {
            $res[] = $next;
        }
    }
}

function fill_table(array $seq, array &$table)
{
    $table[] = $seq;

    if (count(array_unique($seq)) !== 1) {
        $l = count($seq);
        $sSeq = [];
        for ($i = 1; $i < $l; $i++) {
            $sSeq[] = $seq[$i] - $seq[$i - 1];
        }

        fill_table($sSeq, $table);
    } else {
        $table[] = array_fill(0, count($seq), 0);
    }

    return $table;
}
