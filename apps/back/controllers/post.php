<?php

class Back_Controller_Post extends \assegai\Controller
{
    function listAll()
    {
        $posts = $this->model('Model_PostMapper');
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
        $posts = $this->model('Model_PostMapper');
        $post = $posts->newPost();
        $post->setName($this->request->post('name'))
            ->setTitle($this->request->post('title'))
            ->setContent($this->request->post('content'));

        $posts->save($post);

        throw new \atlatl\HTTPRedirect($this->server->siteUrl('/cms'));
    }

    function edit($id)
    {
        $posts = $this->model('Model_PostMapper');
        $post = $posts->load($id);
        return $this->view('newPost', array(
                'post' => $post->toArray(),
            ));
    }

    function change($id)
    {
        $posts = $this->model('Model_PostMapper');
        $post = $posts->newPost();
        $post->setId($id)
            ->setName($this->request->post('name'))
            ->setTitle($this->request->post('title'))
            ->setContent($this->request->post('content'));
        $posts->save($post);
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
