<?php declare(strict_types=1);

/**
 * https://www.spoj.com/problems/ARITH/
 */

$dataCtn = (int)fgets(STDIN);

while (--$dataCtn > -1) {
    $line = fgets(STDIN);

    list(, $value1, $operator, $value2) = line_parse($line);

    $res = pretty_calc($value1, $value2, $operator);

    fwrite(STDOUT, $res . chr(10));
}

/**
 * @param $value1
 * @param $value2
 * @param $operator
 * @return string
 */
function pretty_calc($value1, $value2, $operator): string
{
    $lines = aligned_lines([$value1, $operator . $value2]);

    if ($operator === '+') {
        $result = $value1 + $value2;
    } else if ($operator === '-') {
        $result = $value1 - $value2;
    } else if ($operator === '*') {
        $result = $value1 * $value2;
        $len = strlen($value2) - 1;

        if ($len) {
            $lines[] = str_repeat('-', strlen($lines[0]));
            $ptResults = [];

            for ($i = 0; $i <= $len; $i++) {
                $line = $value1 * $value2[$i];
                $line .= str_repeat(' ', $len - $i);
                array_unshift($ptResults, $line);
            }

            $lines = array_merge($lines, $ptResults);
        }
    }

    $result = (string) $result;
    $lines[] = str_repeat('-', max(strlen($lines[0]), strlen($result)));
    $lines[] = (string) $result;

    return implode(chr(10), aligned_lines($lines)) . chr(10);
}

/**
 * @param string $expression
 * @return string[]
 */
function line_parse(string $expression): array
{
    preg_match('/^(\d+?)([*,+,-])(\d+?)$/', $expression, $matches);

    return $matches;
}

/**
 * aligns lines right side
 * by prefixing a space
 * fitting max length
 *
 * @param string[] $lines
 * @return string[]
 */
function aligned_lines(array $lines): array
{
    $widths = array_map('strlen', $lines);
    $maxWidth = max($widths);

    $align = function (string $line) use ($maxWidth): string {
        $line = str_pad($line, $maxWidth, ' ', STR_PAD_LEFT);
        return rtrim($line);
    };

    return array_map($align, $lines);

}
