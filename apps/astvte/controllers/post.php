<?php

namespace astvte\controllers;

class Post extends \assegai\Controller
{
    function listAll()
    {
        $posts = $this->model('astvte\models\posts\Mapper');
        return $this->view('admin/listPosts', array(
	        'posts' => $posts->all(),
        ));
    }

    function write()
    {
        return $this->view('admin/newPost');
    }

    function add()
    {
        $v = new \assegai\modules\validator\Validator($this->request->allPost());
        $v->required("You must supply a URL name.")
            ->validate('name');
        $v->required("You must give a title.")
            ->validate('title');
        $v->required("Please fill in some content.")
            ->validate('content');

        if($v->hasErrors()) {
            return $this->view('admin/newPost', array(
                    'errors' => $v->getAllErrors(),
                    'post' => $this->request->allPost(),
                ));
        }

        $posts = $this->model('astvte\models\posts\Mapper');
        $post = $posts->newPost();
        $post->setName($this->request->post('name'))
            ->setTitle($this->request->post('title'))
            ->setContent($this->request->unsafePost('content'))
            ->setPublished($this->request->post('published'));

        $posts->save($post);

        throw new \assegai\exceptions\HTTPRedirect($this->server->siteUrl('/cms'));
    }

    function edit($id)
    {
        $posts = $this->model('astvte\models\posts\Mapper');
        $post = $posts->load($id);
        return $this->view('admin/newPost', array(
                'post' => $post->toArray(),
            ));
    }

    function change($id)
    {
        // Validating.
        $v = new \assegai\modules\validator\Validator($this->request->allPost());
        $v->required("You must supply a URL name.")
            ->validate('name');
        $v->required("You must give a title.")
            ->validate('title');
        $v->required("Please fill in some content.")
            ->validate('content');

        if($v->hasErrors()) {
            return $this->view('admin/newPost', array(
                    'errors' => $v->getAllErrors(),
                    'post' => $this->request->allPost(),
                ));
        }

        // Saving.
        $posts = $this->model('astvte\models\posts\Mapper');
        $post = $posts->load($id);
        $post->setName($this->request->post('name'))
            ->setTitle($this->request->post('title'))
            ->setContent($this->request->unsafePost('content'))
            ->setPublished($this->request->post('published'));;
        $posts->save($post);
        throw new \assegai\exceptions\HTTPRedirect($this->server->siteUrl('/cms'));
    }

    function preRequest()
    {
        if(!$this->request->getSession('user')) {
            throw new \assegai\exceptions\HTTPRedirect($this->server->siteUrl('/cms/login'));
        }
    }
}
