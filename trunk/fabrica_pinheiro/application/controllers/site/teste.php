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
class Teste extends Site_controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->template->display('teste');
    }

}

?>
