<?php

namespace App\Widgets;

class BaseWidget
{

    static function breadcumb(string $titulo, array $urls)
    {
        $start = [
            '<div class="content-header">',
            '<div class="container-fluid">',
            '<div class="row mb-2">',
            '<div class="col-sm-6">',
            sprintf('<h1 class="m-0">%s</h1>', $titulo),
            '</div><!-- /.col -->',
            '<div class="col-sm-6">',
            '<ol class="breadcrumb float-sm-right">',
            '<li class="breadcrumb-item"><a href="#">Home</a></li>',
        ];

        foreach($urls as $url){
            if($url['url'] !== false){
                $links[] = sprintf('<li class="breadcrumb-item"><a href="%s">%s</a></li>', $url['url'], $url['title']);
            }else{
                $links[] = sprintf('<li class="breadcrumb-item active">%s</li>', $url['title']);
            }
            
        }

        $end = [
            '',
            '</ol>',
            '</div>',
            '</div>',
            '</div>',
            '</div>',
        ];

        $links = array_merge($links, $end);
        $links = array_merge($start, $links);

        echo(implode('', $links));
        
    }

}