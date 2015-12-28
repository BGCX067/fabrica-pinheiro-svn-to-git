<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author Lucas Pinheiro
 */
class Home extends Site_controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        if ($this->uri->segment(2) == 'admin')
            redirect(base_url() . 'admin/home');
        else
            redirect(base_url() . 'site/home');
    }

    function admin() {
        redirect(base_url() . 'admin/home');
    }

    function site() {
        redirect(base_url() . 'site/home');
    }

}

?>