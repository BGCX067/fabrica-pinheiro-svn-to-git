<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Form_validation
 *
 * @author lucas
 */
class MY_Form_validation extends CI_Form_validation {

    //put your code here

    function __construct($rules = array()) {
        parent::__construct($rules);
    }

    /**
     *
     * @param String Nome da matriz
     * @return Array retorna um array dos campo que contem erros. 
     */
    function erros_campos_json($replace = null) {
        $dados = array();
        foreach ($this->_error_array as $k => $v) {
            if ($replace != null) {
                $k = str_replace(array($replace . '[', ']'), '', $k);
            }
            $dados[$k]['id'] = $k;
            $dados[$k]['msg'] = $v;
        }
        return $dados;
    }

    /**
     *
     * @return String Mensagem padrão de erro. 
     */
    function msg_erros_campos_json() {
        return 'Os campos destacados em vermelho são de preenchimento obrigatório ou contém erros.';
    }

}

?>
