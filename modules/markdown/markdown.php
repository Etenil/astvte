<?php

class Module_Markdown extends \assegai\Module
{
    protected $parser;

    public static function instanciate()
    {
        return true;
    }

    public function _init($options)
    {
        if(isset($options['type']) && $optins['type'] == 'extra') {
            $this->parser = new \dflydev\markdown\MarkdownExtraParser();
        } else {
            $this->parser = new \dflydev\markdown\MarkdownParser();
        }
    }

    public function render($text)
    {
        return $this->parser->transformMarkdown($text);
    }
}
