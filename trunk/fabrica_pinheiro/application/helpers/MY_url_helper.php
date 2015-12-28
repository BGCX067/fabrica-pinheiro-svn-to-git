<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function pre($dados) {
    echo '<div style="border: 1px solid #cccccc;padding: 15px;margin: 10px;background: #FFECA2;">';
    echo '<h1>Debugando um "' . strtoupper(gettype($dados)) . '"</h1>';
    echo '<div style="color: green;">';
    echo '<pre>';
    var_dump($dados);
    echo '</pre>';
    echo '</div>';
    echo '</div>';
}

if (!function_exists('url_site')) {

    function url_site($uri = '') {
        $CI = & get_instance();
        return $CI->config->base_url($uri) . 'site/';
    }

}

if (!function_exists('url_blog')) {

    function url_blog($uri = '') {
        $CI = & get_instance();
        return $CI->config->base_url($uri) . 'blog/';
    }

}

if (!function_exists('url_admin')) {

    function url_admin($uri = '') {
        $CI = & get_instance();
        return $CI->config->base_url($uri) . 'admin/';
    }

}

if (!function_exists('tinyurl')) {

    function tinyurl($uri = '') {
        if (trim($uri) != '') {
            return "http://tinyurl.com/api-create.php?url=" . $uri;
        } else {
            return "";
        }
    }

}


