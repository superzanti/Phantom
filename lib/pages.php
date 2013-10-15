<?php

    class pages {
        
        public $params;// Each word between the slashes in the url is stored in a variable

        public $page;// The current page

        public $err;// If err then return a 404

        public $display; // How many articles to display per page

        public $config;

        public function __construct(){
            $this->config = require "config/config.php";
            $this->checkPage();
        }

        public function findParams(){ 
            $pathinfo = isset($_SERVER['PATH_INFO'])
                    ? $_SERVER['PATH_INFO']
                    : $_SERVER['REQUEST_URI'];

            $this->params = preg_split('|/|', $pathinfo, -1, PREG_SPLIT_NO_EMPTY);
        }

        public function checkPage($config){
            $this->findParams();
            $this->page = "404";
            $this->err = FALSE;

            foreach ($this->config['routes'] as $key => $value){
                if (preg_match($value['route'], "/" . implode("/", $this->params))){
                    $this->page = $key;
                }
            }

            $this->displayPage();
        }

        public function displayPage(){
            include_once("lib/articles.php");
            $articles = new articles($this->params, $this->config['articles.display'], $this->config['articles.path']);

            switch ($this->page){
                case '__root__':
                    $this->err = $articles->displayAll();
                    break;
                case 'post':
                    include("lib/post.php");
                    break;
                default:
                    $this->page = "404";
            }
            if (!$this->err)
                echo "404";
            return $this->page;
        }

    }

?>
