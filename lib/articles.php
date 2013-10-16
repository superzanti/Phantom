<?php

    class articles {

        public $articles = array();

        public $params;

        public $display;

        public $path;

        public $page;

        public function __construct($params, $page, $display, $path){
            $this->params = $params;
            $this->display = $display;
            $this->path = $path;
            $this->page = $page;
        }

        public function getAll(){
            $dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->path),
                RecursiveIteratorIterator::SELF_FIRST);
            foreach($dir as $file){
                if (($file->isFile()) and ($file->getExtension() == "txt")){
                    $handle  = fopen($file->getPathname(), 'r');
                    $content = stream_get_contents($handle);
                    $content = explode("\n\n", $content);
                    $rawMeta = array_shift($content);
                    $meta    = json_decode($rawMeta,true);
                    $content = implode("\n\n", $content);
                    $this->articles[$file->getPathname()] = 
                        array('meta' => $meta, 'content' => $content);
                }
            }
            $dates = array();
            foreach ($this->articles as $date){
                $dates[] = $date['meta']['date'];
            }
            array_multisort($dates, SORT_DESC, $this->articles);
        }

        public function displayAll(){
            $this->getAll();
            if ($this->page != '__root__')
                $this->params[0] = 0;
            if($this->params[0] == 0){
                $this->display = $this->display + 1;
            }
            $this->display = $this->display - 1;
            if(!(sizeof($this->articles) <= $this->display))
                if ($this->params[0] >= sizeof($this->articles) - $this->display)
                    return FALSE;
            foreach(array_slice($this->articles, 
                $this->params[0], $this->params[0] + $this->display) as $article){
                echo "<h1> ". $article['meta']['title'] ." </h1><br> ";
                echo substr(strip_tags($article['content']), 0,200)
                    . '... <a href="/' . $article['meta']['slug']
                    . '">Read more >> </a><br><br>';
            }
            $err = TRUE;
            if(sizeof($this->articles) > $this->display)
                $err = $this->navArticles();
            return $err;
        }

        public function navArticles(){
            if (sizeof($this->articles) > $this->display){
                if ($this->params[0] == 0){
                    echo "<hr><span style=\"float:right;\"><a href=\"/";
                    if ($this->params[0] >= sizeof($this->articles) - $this->display - 1)
                        echo sizeof($this->articles) - $this->display;
                    else
                        echo $this->params[0] + $this->display;
                    echo "\">Older Posts</a></span>";
                }
                elseif ($this->params[0] >= sizeof($this->articles) - $this->display - 1){
                    echo "<hr><span style=\"float:left;\"><a href=\"/";
                    if ($this->params[0] < $this->display + 1)
                        echo "0";
                    else
                        echo $this->params[0] - $this->display - 1;
                    echo "\">Newer Posts</a></span>";
                }
                else{
                    echo "<hr><span style=\"float:left;\"><a href=\"/";
                    if ($this->params[0] < $this->display + 1)
                        echo "0";
                    else
                        echo $this->params[0] - $this->display - 1;
                    echo "\">Newer Posts</a></span>
                        <span style=\"float:right;\"><a href=\"/";
                    if ($this->params[0] >= sizeof($this->articles) - $this->display - 1)
                        echo sizeof($this->articles) - $this->display - 1;
                    else
                        echo $this->params[0] + $this->display;
                    echo "\">Older Posts</a></span>";
                }
            }
            return TRUE;
        }
    }

?>
