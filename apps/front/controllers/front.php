<?php

class Front_Controller_Front extends \assegai\Controller
{
    function homepage()
    {
        $posts = $this->model('Model_PostMapper');
        return $this->view('listPosts', array(
                               'posts' => $posts->all(),
                               'utils' => $this->model('Model_Utils'),
                               ));
    }

    function post($name)
    {
        $posts = $this->model('Model_PostMapper');
        $post = $posts->getName($name);
        return $this->view('post', array('post' => $post->current()));
    }
}
