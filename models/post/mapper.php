<?php

class Model_Post_Mapper extends \assegai\Model
{
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

    /**
     * Loads all the published posts.
     */
    function allPublished()
    {
        $data = RedBean_Facade::find('post', 'published = 1 ORDER BY date DESC');
        if(!$data) return false;
        return new Model_Post_Collection($data);
    }
    
    function all()
    {
        $data = RedBean_Facade::findAll('post', 'ORDER BY date DESC');
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