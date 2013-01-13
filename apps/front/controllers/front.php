<?php

class Front_Controller_Front extends \assegai\Controller
{
    function homepage()
    {
        $posts = $this->model('Model_Post');
        return $this->view('listPosts', array(
                               'posts' => $posts->all(),
                               'utils' => $this->model('Model_Utils'),
                               ));
    }

    function post($id)
    {
        $posts = $this->model('Model_Post');
        $post = $posts->load($id);
        return $this->view('post', array('post' => $post));
    }
}
