<?php

class Model_PostMapper extends \assegai\Model
{
    function save(Model_Post $post)
    {
        $apost = $post->toArray();
        $this->modules->fsstore->main->posts->index('name')->save($apost);
        $post->setId($apost['id']);
        return $post->getId();
    }

    function load($id)
    {
        $data = $this->modules->fsstore->main->posts->load($id);
        if(!$data) {
            return false;
        }

        return new Model_Post($data);
    }

    function getName($name)
    {
        $cursor = $this->modules->fsstore->main->posts->find(array('name' => $name));
        $cursor->setMapper(function($record) {
                return new Model_Post($record);
            });
        return $cursor;
    }

    function all()
    {
        $cursor = $this->modules->fsstore->main->posts->find();
        $cursor->setMapper(function($record) {
                return new Model_Post($record);
            });
        return $cursor;
    }

    /**
     * Convenience function to create a brand new Post.
     */
    function newPost()
    {
        return new Model_Post();
    }
}