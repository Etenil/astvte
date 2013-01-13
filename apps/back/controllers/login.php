<?php

class Back_Controller_Login extends \assegai\Controller
{
    function login()
    {
        return $this->view('login');
    }

    function doLogin()
    {
        if($this->request->post('password') == $this->server->main->get('password')) {
            $resp = new \assegai\Response();
            $resp->setSession('user', 'admin');
            $resp->redirect($this->server->siteUrl('/cms'));
            return $resp;
        } else {
            throw new \atlatl\HTTPRedirect($this->server->siteUrl('/cms/login'));
        }
    }
}
