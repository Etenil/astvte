<?php

class Back_Controller_Post extends \assegai\Controller
{
    function listAll()
    {
        $posts = $this->model('Model_Post');
        return $this->view('listPosts', array(
                               'posts' => $posts->all(),
                               ));
    }

    function write()
    {
        return $this->view('newPost');
    }

    function add()
    {
        $posts = $this->model('Model_Post');
        $id = $posts->create($this->request->post('title'),
                             $this->request->post('content'));

        throw new \atlatl\HTTPRedirect($this->server->siteUrl('/cms'));
    }

    function edit($id)
    {
        $posts = $this->model('Model_Post');
        $post = $posts->load($id);
        return $this->view('newPost', array(
                               'post' => $post,
                               ));
    }

    function change($id)
    {
        $posts = $this->model('Model_Post');
        $posts->update($id,
                       $this->request->post('title'),
                       $this->request->post('content'));
        throw new \atlatl\HTTPRedirect($this->server->siteUrl('/cms'));
    }

    function preRequest()
    {
        $resp = new \assegai\Response();
        if(!$resp->getSession('user')) {
            throw new \atlatl\HTTPRedirect($this->server->siteUrl('/cms/login'));
        }
    }
}
