<?php
    return array(
        'site.name' => 'SethMiers',
        'site.title' => 'A personal website to help organize my thoughts',
        'articles.display' => 10,
        'articles.path' => 'articles/',
        'routes' => array(
            '__root__' => array(
                'route' => '/^(\/\d+$)|(\/$)/',
                'template' => 'index'
            ),
            'portfolio' => array(
                'route' => '/portfolio',
                'template' => 'index'
            ),
            'archives' => array(
                'route' => '/archives',
                'template' => 'index'
            ),
            'article' => array(
                'route' => '/articles',
                'template' => 'index'
            ),
            'post' => array(
                'route' => '/post',
                'template' => 'index'
            ),
            'rss' => array(
                'route' => '/feed/rss',
                'template' => 'rss'
            )
        ),
    );
?>
