<?php declare(strict_types=1);

$pre = new SplFixedArray(13);

for ($i = 0; $i < 13; $i++) {
    $pre[$i] = new SplFixedArray(100);
    for ($j = 0; $j < 100; $j++) {
        $pre[$i][$j] = 0;
    }
}


$pre[1][0] = 1;
for ($i = 1; $i < 12; $i++) {
    for ($j = 0; $pre[$i][$j]; $j++) {
        $cnt = 0;
        for ($k = $j; $cnt < $i + 1; $k++) {
            $pre[$i + 1][$k] += $pre[$i][$j];
            $cnt++;
        }
    }
}

fscanf(STDIN, "%d\n", $testCases);
for ($i = 0; $i < $testCases; $i++) {
    fscanf(STDIN, "%d %d\n", $n, $k);
    echo $pre[$n][$k] . PHP_EOL;
}

