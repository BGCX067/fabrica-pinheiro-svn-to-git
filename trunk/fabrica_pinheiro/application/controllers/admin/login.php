<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author lucas
 */
class login extends Admin_controller {

    //put your code here
    function __construct() {
        parent::__construct();
    }

    function sair() {
        $this->session->sess_destroy();
        redirect(url_site() . 'administracao');
    }

}

?>