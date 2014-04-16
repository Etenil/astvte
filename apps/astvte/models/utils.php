<?php

namespace astvte\models;

class Utils extends \assegai\Model
{
    function excerpt($text)
    {
        return substr($text, 0, min(strlen($text), 200)) . '...';
    }
}