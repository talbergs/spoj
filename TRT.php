<?php

/**
 * https://www.spoj.com/problems/TRT/
 */
$treats = [];
$N = $dataCtn = (int)fgets(STDIN);

while (--$dataCtn > -1) {
    $treats[] = (int)fgets(STDIN);
}

$cache = new SplFixedArray($N);
for ($i = 0; $i < $N; $i++) {
    $cache[$i] = new SplFixedArray($N);
}

$sell = function (int $start, int $end) use ($treats, &$sell, $N, &$cache): int {
    if ($start > $end) {
        return 0;
    }

    if ($cache[$start][$end]) {
        return $cache[$start][$end];
    }

    $age = $N - ($end - $start);

    $cache[$start][$end] = max(
        $sell($start + 1, $end) + $age * $treats[$start],
        $sell($start, $end - 1) + $age * $treats[$end]
    );

    return $cache[$start][$end];
};

echo $sell(0, $N - 1);
