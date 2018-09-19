<?php

/**
 * https://www.spoj.com/problems/AGGRCOW/
 */
class AGGRCOW
{
    protected $positions;
    protected $N;
    protected $C;

    public function __construct(array $positions, int $cows)
    {
        sort($positions);

        $this->N = count($positions);
        $this->C = $cows;
        $this->positions = $positions;
    }

    public function result(): string
    {
        return $this->search() . chr(10);
    }

    protected function test(int $dist): bool
    {
        $placed = 1;
        $lastPos = $this->positions[0];

        for ($i = 1; $i < $this->N; $i++) {
            if ($this->positions[$i] - $lastPos >= $dist) {
                $lastPos = $this->positions[$i];
                $placed++;

                if ($placed == $this->C) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function search(): int
    {
        $start = 0;
        $end = $this->positions[$this->N - 1] - $this->positions[0];

        while ($start < $end) {
            $mid = floor(($start + $end) / 2);
            if ($this->test($mid)) {
                $start = $mid + 1;
            } else {
                $end = $mid;
            }
        }

        return $start - 1;
    }
}

$dataCtn = (int)fgets(STDIN);
while (--$dataCtn > -1) {
    $positions = [];
    $vars = explode(' ', fgets(STDIN));
    list($N, $C) = array_map('intval', $vars);

    while (--$N > -1) {
        $positions[] = (int)fgets(STDIN);
    }

    echo (new AGGRCOW($positions, $C))->result();
}
