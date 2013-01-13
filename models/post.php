<?php

class Model_Post extends \assegai\Model
{
    function create($title, $content)
    {
        $post = $this->modules->redbean->dispense('post');
        $post->title = $title;
        $post->content = $content;
        $post->date = time();

        return $this->save($post);
    }

    function update($id, $title, $content)
    {
        $post = $this->load($id);
        if(!$post) {
            return false;
        }
        $post->title = $title;
        $post->content = $content;
        $post->date = time();
        $this->save($post);
        return $post->id;
    }

    function load($id)
    {
        return $this->modules->redbean->load('post', $id);
    }

    function save($post)
    {
        return $this->modules->redbean->store($post);
    }

    function all()
    {
        return $this->modules->redbean->findAll('post', ' ORDER BY date DESC ');
    }
}
