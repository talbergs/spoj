<?php declare(strict_types=1);

/**
 * https://www.spoj.com/problems/BEADS/
 */

fscanf(STDIN, "%d\n", $testCases);

while ($testCases--) {
    fscanf(STDIN, "%s\n", $word);
    $origStr = $strStr = $word;
    $strStr .= $word;

    $minIndex = 0;
    $c = strlen($word);

    for ($i = 0; $i < $c; $i++) {
        $subStrStr = substr($strStr, $i, $c - 1);
        if ($subStrStr < $origStr) {
            $origStr = $subStrStr;
            $minIndex = $i;
        }
    }

    printf("%d\n", $minIndex + 1);
}
