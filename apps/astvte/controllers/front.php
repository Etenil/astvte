<?php

namespace astvte\controllers;

class Front extends \assegai\Controller
{
    function homepage()
    {	
        $posts = $this->model('astvte\models\posts\Mapper');
        return $this->view('listPosts', array(
                'title' => $this->server->main->get('title'),
                'posts' => $posts->allPublished(),
                'utils' => $this->model('astvte\models\Utils'),
            ));
    }

    function post($name)
    {
        $posts = $this->model('astvte\models\posts\Mapper');
        $post = $posts->getName($name);
        return $this->view('post', array(
                'title' => $this->server->main->get('title'),
                'post' => $post
            ));
    }

    function rss()
    {
        $pm = $this->model('astvte\models\posts\Mapper');
        $posts = $pm->allPublished();

        $feed = new \Suin\RSSWriter\Feed();
        $channel = new \Suin\RSSWriter\Channel();
        $channel->title($this->server->main->get('title'))
            ->url($this->server->siteUrl(''))
            ->appendTo($feed);

        foreach($posts as $post) {
            $item = new \Suin\RSSWriter\Item();
            $item->title(html_entity_decode($post->getTitle(), ENT_COMPAT | ENT_HTML401, 'UTF-8'))
                ->description($this->modules->markdown->render($post->getContent()))
                ->url($this->server->siteUrl('/post/' . $post->getName()))
                ->pubDate($post->getDate())
                ->appendTo($channel);
        }

        return new \assegai\Response((string)$feed, 200, 'application/rss+xml');
    }
}
