<?php

namespace astvte\controllers;

class Login extends \assegai\Controller
{
    function login()
    {
        return $this->view('admin/login');
    }

    function doLogin()
    {
        if($this->request->post('password') == $this->server->app->get('password')) {
			$this->request->setSession('user', 'admin');
            return $this->redirect($this->server->siteUrl('/cms'));
        } else {
            return $this->redirect($this->server->siteUrl('/cms/login'));
        }
    }
}
