<?php

trait RBPostMapper {
    protected function mapRBToPost($rbpost)
    {
        $post = new Model_Post_Post();
        $post->setId($rbpost->id)
            ->setName($rbpost->name)
            ->setTitle($rbpost->title)
            ->setContent($rbpost->content)
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
        $rbpost->date = $post->getDate();
        return $rbpost;
    }
}

class Model_Post_Mapper extends \assegai\Model
{
    use RBPostMapper;
    
    function save(Model_Post_Post $post)
    {
        if(!$post->getDate()) $post->setDate(time());
        $rbpost = $this->mapPostToRB($post);
        $post->setId(RedBean_Facade::store($rbpost));
        return $post->getId();
    }

    function load($id)
    {
        $data = RedBean_Facade::load('post', $id);
        
        if(!$data) return false;

        return $this->mapRBToPost($data);
    }

    function getName($name)
    {
        $data = RedBean_Facade::findOne('post', 'name = ?', array($name));

        if(!$data) return false;
        
        return $this->mapRBToPost($data);
    }

    function all()
    {
        $data = RedBean_Facade::findAll('post');
        if(!$data) return false;
        return new Model_Post_Collection($data);
    }

    /**
     * Convenience function to create a brand new Post.
     */
    function newPost()
    {
        return new Model_Post_Post();
    }
}