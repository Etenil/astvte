<?php

namespace modules\markdown
{
	use \assegai\modules;
	
	class Markdown extends modules\Module
	{
	    protected $parser;

	    public static function instanciate()
	    {
	        return true;
	    }

	    public function setOptions($options)
	    {
	        if(isset($options['type']) && $options['type'] == 'extra') {
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
}
