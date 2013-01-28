<?php

class Front_Controller_Front extends \assegai\Controller
{
    function homepage()
    {
        $posts = $this->model('Model_PostMapper');
        return $this->view('listPosts', array(
                'title' => $this->server->main->get('title'),
                'posts' => $posts->all(),
                'utils' => $this->model('Model_Utils'),
            ));
    }

    function post($name)
    {
        $posts = $this->model('Model_PostMapper');
        $post = $posts->getName($name);
        return $this->view('post', array(
                'title' => $this->server->main->get('title'),
                'post' => $post->current()
            ));
    }

    function rss()
    {
        $pm = $this->model('Model_PostMapper');
        $posts = $pm->all();

        $feed = new \Suin\RSSWriter\Feed();
        $channel = new \Suin\RSSWriter\Channel();
        $channel->title($this->server->main->get('title'))
            ->url($this->server->siteUrl(''))
            ->appendTo($feed);

        foreach($posts as $post) {
            $item = new \Suin\RSSWriter\Item();
            $item->title($post->getTitle())
                ->description($this->modules->markdown->render($post->getContent()))
                ->url($this->server->siteUrl('/post/' . $post->getName()))
                ->appendTo($channel);
        }

        return new \assegai\Response((string)$feed, 200, 'application/rss+xml');
    }
}
