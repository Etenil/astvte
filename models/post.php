<?php

class Model_Post
{
    protected $_id;
    protected $_name;
    protected $_title;
    protected $_content;
    protected $_date;

    function __construct(array $data = null)
    {
        if($data) {
            $this->fromArray($data);
        }
    }

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

    Function getTitle()
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
            'date' => $this->getDate());
    }

    function fromArray($record)
    {
        $this->setId($record['id'])
            ->setName($record['name'])
            ->setTitle($record['title'])
            ->setContent($record['content']);
    }
}
