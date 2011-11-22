use GitElephant\Utilities;
use GitElephant\Objects\DiffChunk;

class DiffObject implements \ArrayAccess, \Countable, \Iterator
    private $position;
    private $chunks;
        $this->position = 0;
        $this->chunks = array();

        if ($this->mode == self::MODE_INDEX) {
            $this->findChunks(array_slice($lines, 4));
        }
    }

    private function findChunks($lines)
    {
        $arrayChunks = Utilities::preg_split_array($lines, '/@@ -(\d+,\d+)|(\d+) \+(\d+,\d+)|(\d+) @@?(.*)/');
        foreach($arrayChunks as $chunkLines) {
            $this->chunks[] = new DiffChunk($chunkLines);
        }

    public function getChunks()
    {
        return $this->chunks;
    }

    public function getDestPath()
    {
        return $this->destPath;
    }

    public function getMode()
    {
        return $this->mode;
    }

    public function getOrigPath()
    {
        return $this->origPath;
    }

    // ArrayAccess interface
    public function offsetExists($offset)
    {
        return isset($this->chunks[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->chunks[$offset]) ? $this->chunks[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->chunks[] = $value;
        } else {
            $this->chunks[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->chunks[$offset]);
    }

    // Countable interface
    public function count()
    {
        return count($this->chunks);
    }

    // Iterator interface
    public function current()
    {
        return $this->chunks[$this->position];
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return isset($this->chunks[$this->position]);
    }

    public function rewind()
    {
        $this->position = 0;
    }