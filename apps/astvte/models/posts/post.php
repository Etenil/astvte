<?php

namespace astvte\models\posts;

class Post
{
    protected $_id;
    protected $_name;
    protected $_title;
    protected $_content;
    protected $_published = false;
    protected $_date;

    function getId()
    {
        return $this->_id;
    }

    function setId($val)
    {
        $this->_id = $val;
        return $this;
    }

    function getName()
    {
        return $this->_name;
    }

    function setName($val)
    {
        $this->_name = $val;
        return $this;
    }

    function getTitle()
    {
        return $this->_title;
    }

    function setTitle($val)
    {
        $this->_title = $val;
        return $this;
    }

    function getContent()
    {
        return $this->_content;
    }

    function setContent($val)
    {
        $this->_content = $val;
        return $this;
    }

    function getHumanDate()
    {
        return date('Y-m-d', $this->getDate());
    }

    function getPublished()
    {
        return $this->_published;
    }

    function setPublished($val)
    {
        $this->_published = (bool)$val;
        return $this;
    }

    function getDate()
    {
        return $this->_date;
    }

    function setDate($val)
    {
        $this->_date = $val;
        return $this;
    }

    function toArray()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'title' => $this->getTitle(),
            'content' => $this->getContent(),
            'published' => $this->getPublished(),
            'date' => $this->getDate());
    }
}
