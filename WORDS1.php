<?php declare(strict_types=1);

/**
 * https://www.spoj.com/problems/WORDS1/
 */

$dataCtn = (int)fgets(STDIN);

while (--$dataCtn > -1) {
    $size = (int) fgets(STDIN);
    $lines = [];

    while (--$size > -1) {
        $lines[] = trim(fgets(STDIN));
    }

    echo (new Graph($lines))->hasEulerPath()
        ? "Ordering is possible.\n"
        : "The door cannot be opened.\n";
}

class Vertex
{
    /**
     * @var int
     */
    protected $value;
    /**
     * @var int
     */
    protected $weight;

    public function __construct(int $value, int $weight)
    {
        $this->value = $value;
        $this->weight = $weight;
    }

    public function connects(Vertex $vertex): bool
    {
        if ($this->value === $vertex->getValue()) {
            $this->weight ++;
            $vertex->weight ++;

            return true;
        }

        return false;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}

class Edge
{
    /**
     * @var int
     */
    public $startNode;
    /**
     * @var int
     */
    public $endNode;

    public function __construct(int $start, int $end)
    {
        $this->startNode = new Vertex($start, 1);
        $this->endNode = new Vertex($end, 1);
    }
}

class Graph
{
    /**
     * @var Edge[]
     */
    public $edges = [];

    /**
     * @var bool
     */
    protected $disconnections = 0;

    public function __construct(array $lines)
    {
        foreach ($lines as $line) {
            $this->edges[] = new Edge(
                ord(substr($line, 0, 1)),
                ord(substr($line, -1, 1))
            );
        }

        $floatingEdges = [];
        foreach ($this->edges as $index => $testEdge) {
            $anyConnection = false;
            foreach ($this->edges as $expIndex => $edge) {
                if ($expIndex === $index) continue;
                $connected = $testEdge->startNode->connects($edge->endNode);
                if ($connected && !$anyConnection) {
                    $anyConnection = true;
                }
            }

            if (!$anyConnection) {
                $floatingEdges[] = $testEdge;
            }
        }

        if ($floatingEdges) {
            foreach ($floatingEdges as $edge) {
                if (
                    $edge->endNode->getWeight() < 2
                    && $edge->startNode->getWeight() < 2
                ) {
                    $this->disconnections = 2;
                }
            }
        }
    }

    public function isConnected(): bool
    {
        return $this->disconnections < 2;
    }

    public function hasEulerPath(): bool
    {
        if (!$this->isConnected()) {
            return false;
        }

        $oddCtn = 0;

        foreach ($this->vertexes() as $vertex) {
            if ($vertex->getWeight() % 2) {
                $oddCtn ++;
            }
        }

        return boolval($oddCtn % 2 === 0);
    }

    /**
     * @return Generator|Vertex[]
     */
    protected function vertexes()
    {
        foreach ($this->edges as $e) {
            yield $e->startNode;
            yield $e->endNode;
        }
    }
}
