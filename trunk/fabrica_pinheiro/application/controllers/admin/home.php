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
class Home extends Admin_controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->template->set_conteudo_titulo('Área Administrativa');
        $this->template->display('Bem Vindo a área administrativa.');
    }

}

?>