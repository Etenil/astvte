<?php

class Model_Post_Collection implements Iterator
{
    use RBPostMapper;
    
    protected $position;
    protected $payload;

    function __construct($data)
    {
        // RedBean uses associative arrays with IDs. We don't care.
        $this->payload = array_values($data);
        $this->rewind();
    }

    function current()
    {
        return $this->mapRBToPost($this->payload[$this->position]);
    }

    function key()
    {
        return $this->position;
    }

    function next()
    {
        $this->position++;
    }

    function valid()
    {
        return isset($this->payload[$this->position]);
    }

    function rewind()
    {
        $this->position = 0;
    }
}