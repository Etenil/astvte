<?php

namespace astvte\controllers;

class Post extends \assegai\Controller
{
    function listAll()
    {
        $posts = $this->model('Model_Post_Mapper');
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
        $v = new Module_Validator($this->request->allPost());
        $v->required("You must supply a URL name.")
            ->validate('name');
        $v->required("You must give a title.")
            ->validate('title');
        $v->required("Please fill in some content.")
            ->validate('content');

        if($v->hasErrors()) {
            return $this->view('newPost', array(
                    'errors' => $v->getAllErrors(),
                    'post' => $this->request->allPost(),
                ));
        }

        $posts = $this->model('Model_Post_Mapper');
        $post = $posts->newPost();
        $post->setName($this->request->post('name'))
            ->setTitle($this->request->post('title'))
            ->setContent($this->request->unsafePost('content'))
            ->setPublished($this->request->post('published'));

        $posts->save($post);

        throw new \atlatl\HTTPRedirect($this->server->siteUrl('/cms'));
    }

    function edit($id)
    {
        $posts = $this->model('Model_Post_Mapper');
        $post = $posts->load($id);
        return $this->view('newPost', array(
                'post' => $post->toArray(),
            ));
    }

    function change($id)
    {
        // Validating.
        $v = new Module_Validator($this->request->allPost());
        $v->required("You must supply a URL name.")
            ->validate('name');
        $v->required("You must give a title.")
            ->validate('title');
        $v->required("Please fill in some content.")
            ->validate('content');

        if($v->hasErrors()) {
            return $this->view('newPost', array(
                    'errors' => $v->getAllErrors(),
                    'post' => $this->request->allPost(),
                ));
        }

        // Saving.
        $posts = $this->model('Model_Post_Mapper');
        $post = $posts->load($id);
        $post->setName($this->request->post('name'))
            ->setTitle($this->request->post('title'))
            ->setContent($this->request->unsafePost('content'))
            ->setPublished($this->request->post('published'));;
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
