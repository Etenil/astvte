<?php

class FSStoreDB
{
    protected $path;

    function __construct($origin_path)
    {
        $this->path = $origin_path;
    }

    function getCollection($name)
    {
        if(!file_exists($this->getPath($name)))
        {
            mkdir($this->getPath($name));
        }

        return new FSStoreCollection($this->getPath($name));
    }

    protected function getPath($file)
    {
        return $this->path . '/' . $file;
    }

    /**
     * Syntactic sugar to create collections.
     */
    function __get($name)
    {
        return $this->getCollection($name);
    }
}

class FSStoreIndex
{
    protected $index_path;
    protected $index;

    function __construct($path)
    {
        $this->index_path = $path . '_index';

        $this->load($this->index_path);
    }

    function load()
    {
        $this->index = array();

        if(file_exists($this->index_path)) {
            $this->index = json_decode(file_get_contents($this->index_path), true);
        }
    }

    function save()
    {
        file_put_contents($this->index_path, json_encode($this->index));
    }

    function __destruct()
    {
        $this->save();
    }

    function add($id, $key, $value)
    {
        if(isset($this->index[$value])) {
            $this->index[$value][$key][] = $id;
        } else {
            $this->index[$value] = array($key => array($id));
        }
        return $this;
    }

    protected function lookup($key, $value)
    {
        if(isset($this->index[$value])
           && isset($this->index[$value][$key])) {
            return $this->index[$value][$key];
        } else {
            return array();
        }
    }

    function find(array $spec)
    {
        $ids = array();
        foreach($spec as $key => $value) {
            $keyids = $this->lookup($key, $value);
            if($keyids) {
                $ids = array_merge($ids, $keyids);
            }
        }

        return $ids;
    }
}

class FSStoreCursor implements Iterator {
    protected $position = 0;
    protected $collection;
    protected $ids;
    protected $mapper = null;

    public function setMapper(Closure $mapper)
    {
        $this->mapper = $mapper;
    }

    public function __construct(FSStoreCollection $collection, array $ids) {
        $this->position = 0;
        $this->ids = $ids;
        $this->collection = $collection;
    }

    function rewind() {
        $this->position = 0;
    }

    function current() {
        $record =  $this->collection->load($this->ids[$this->position]);
        if($this->mapper) {
            return call_user_func($this->mapper, $record);
        } else {
            return $record;
        }
    }

    function key() {
        return $this->ids[$this->position];
    }

    function next() {
        ++$this->position;
    }

    function valid() {
        return isset($this->ids[$this->position]);
    }
}

class FSStoreCollection
{
    protected $path;
    protected $index;
    protected $indexed_keys;

    function __construct($path)
    {
        $this->path = $path;
        /* We don't index the ids. The file system has a much better
         * indexing mechanism than this humble PHP script. */
        $this->indexed_keys = array();
        $this->index = new FSStoreIndex($this->path);
    }

    function save(array $record)
    {
        // Generating an ID.
        if(!isset($record['id']) || !$record['id']) {
            $record['id'] = time() . '_' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        }
        file_put_contents($this->getPath($record), json_encode($record));

        foreach($this->indexed_keys as $key) {
            if(isset($record[$key])) {
                $this->index->add($record['id'], $key, $record[$key]);
            }
        }

        $this->index->save(); // Not ideal but the destructor isn't called on the index...

        return $this;
    }

    function load($id)
    {
        if(file_exists($this->getPath($id))) {
            return json_decode(file_get_contents($this->getPath($id)), true);
        } else {
            return false;
        }
    }

    function find(array $spec = null)
    {
        if(!$spec) {
            return $this->getAll();
        } else {
            $ids = $this->index->find($spec);
            if($ids) {
                return new FSStoreCursor($this, $ids);
            } else {
                return false;
            }
        }
    }

    /**
     * Retrieves all data.
     */
    protected function getAll()
    {
        $ids = array_values(preg_replace('/\.json$/', '', preg_grep('/\.json$/', scandir($this->path))));
        return new FSStoreCursor($this, $ids);
    }

    protected function getPath($record)
    {
        if(is_array($record)) {
            return $this->path . '/' . $record['id'] . '.json';
        } else {
            return $this->path . '/' . $record . '.json';
        }
    }

    /**
     * Adds a key to index.
     */
    public function index($key)
    {
        $this->indexed_keys[] = $key;
        return $this;
    }
}
