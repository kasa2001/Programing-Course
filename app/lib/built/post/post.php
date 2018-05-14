<?php

namespace Lib\Built\Post;


class Post
{
    private $post;

    public function __construct()
    {
        $this->post = $_POST;
    }

    /**
     * Magic get method
     * @throws PostException if not isset data in post array
     * @param $name string|int
     * @return mixed
     * */
    public function __get($name)
    {
        if (isset($this->post[$name]))
            return $this->post[$name];
        else
            throw new PostException("Błąd wewnętrzny serwera", 500);
    }
}