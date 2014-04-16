<?php

namespace astvte\models\posts;

class Collection implements Iterator
{
    protected $position;
    protected $payload;

    protected function mapRBToPost($rbpost)
    {
        $post = new Model_Post_Post();
        $post->setId($rbpost->id)
            ->setName($rbpost->name)
            ->setTitle($rbpost->title)
            ->setContent($rbpost->content)
            ->setPublished($rbpost->published)
            ->setDate($rbpost->date);
        return $post;
    }

    protected function mapPostToRB($post)
    {
        if($post->getId()) {
            $rbpost = RedBean_Facade::load('post', $post->getId());
        } else {
            $rbpost = RedBean_Facade::dispense('post');
        }
        $rbpost->name = $post->getName();
        $rbpost->title = $post->getTitle();
        $rbpost->content = $post->getContent();
        $rbpost->published = $post->getPublished();
        $rbpost->date = $post->getDate();
        return $rbpost;
    }

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