<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Database
 *
 * @author lucas_p
 */
class Database_fabrica_pinheiro {

    private $CI;
    private $banco;

    function __construct() {
        $this->CI = & get_instance();
    }

    /**
     *
     * @param Array $parametros
     * Formato =
     * Array(
     * 'AND' => array('campo da tabela' => 'valor'),
     * 'AND_IN' => array('campo da tabela' => 'valor'),
     * 'AND_NOT_IN' => array('campo da tabela' => 'valor'),
     * 'OR' => array('campo da tabela' => 'valor'),
     * 'OR_IN' => array('campo da tabela' => 'valor'),
     * 'OR_NOT_IN' => array('campo da tabela' => 'valor'),
     * 'LIKE' => array('campo da tabela' => 'valor'),
     * 'AND_NOT_LIKE' => array('campo da tabela' => 'valor'),
     * 'OR_LIKE' => array('campo da tabela' => 'valor'),
     * 'OR_NOT_LIKE' => array('campo da tabela' => 'valor'),
     * 'GROUP' => array('campo da tabela' => 'valor'),
     * 'ORDER' => array('campo da tabela' => 'valor'),
     * 'LIMIT'  => array('incio' => 'valor','fim' => 'valor'),
     * 'CAMPOS' => array('campo da tabela'),
     * 'MAX' => string ('campo da tabela'),
     * 'MIN' => string ('campo da tabela'),
     * 'SUM' => string ('campo da tabela'),
     * 'JOIN' => array('TABELA' => 'nome da tabela', 'AND' => 'valores de comparação', 'TIPO' => 'LEFT, RIGHT'),
     * )
     * @return Objeto $this
     */
    function gera_query($parametros = array(), $db = '') {
        if ($db != '') {
            $this->banco = $this->CI->load->database($db, TRUE);
        } else {
            $this->banco = $this->CI->db;
        }
        if (count($parametros) > 0) {
            $this->CI->load->helper('strings');
            foreach ($parametros as $k => $v) {
                $a = limpaString(array('entrada' => $k, 'formato' => 'retiraAcento'));
                switch ($a) {
                    case 'AND':
                        $this->_sql_and($v);
                        break;

                    case 'SET':
                        $this->_sql_set($v);
                        break;

                    case 'OR':
                        $this->_sql_or($v);
                        break;

                    case 'LIKE':
                        $this->_sql_like($v);
                        break;

                    case 'ORLIKE':
                    case 'OR_LIKE':
                        $this->_sql_or_like($v);
                        break;

                    case 'GROUPBY':
                    case 'GROUP':
                        $this->_sql_group($v);
                        break;

                    case 'ORDERBY':
                    case 'ORDER':
                        $this->_sql_order($v);
                        break;

                    case 'LIMIT':
                        $this->_sql_limit($v);
                        break;

                    case 'CAMPOS':
                        $this->_sql_campos($v);
                        break;

                    case 'MAX':
                        $this->_sql_max($v);
                        break;

                    case 'MIN':
                        $this->_sql_min($v);
                        break;

                    case 'SUM':
                        $this->_sql_sum($v);
                        break;

                    case 'JOIN':
                        $this->_sql_join($v);
                        break;

                    case 'ANDIN':
                    case 'AND_IN':
                        $this->_sql_and_in($v);
                        break;

                    case 'ORIN':
                    case 'OR_IN':
                        $this->_sql_or_in($v);
                        break;

                    case 'ANDNOTIN':
                    case 'AND_NOT_IN':
                        $this->_sql_and_not_in($v);
                        break;

                    case 'ORNOTIN':
                    case 'OR_NOT_IN':
                        $this->_sql_or_not_in($v);
                        break;

                    case 'ANDNOTLIKE':
                    case 'AND_NOT_LIKE':
                        $this->_sql_and_not_like($v);
                        break;

                    case 'ORNOTLIKE':
                    case 'OR_NOT_LIKE':
                        $this->_sql_or_not_like($v);
                        break;
                }
            }
        }
        return $this->banco;
    }

    function _sql_and($parametros) {
        if (is_array($parametros)) {
            foreach ($parametros as $k => $v) {
                $this->banco->where($k, $v);
            }
        }
    }

    function _sql_set($parametros) {
        if (is_array($parametros)) {
            foreach ($parametros as $k => $v) {
                $this->banco->set($k, $v);
            }
        }
    }

    function _sql_or($parametros) {
        if (is_array($parametros)) {
            foreach ($parametros as $k => $v) {
                $this->banco->or_where($k, $v);
            }
        }
    }

    function _sql_like($parametros) {
        if (is_array($parametros)) {
            foreach ($parametros as $k => $v) {
                $this->banco->like($k, $v);
            }
        }
    }

    function _sql_or_like($parametros) {
        $this->banco->or_like($parametros);
        /* if ( is_array($parametros) ) {
          foreach ( $parametros as $k => $v ) {
          $this->banco->or_like($k, $v) ;
          }
          } */
    }

    function _sql_group($parametros) {
        $this->banco->group_by($parametros);
    }

    function _sql_order($parametros) {
        $this->banco->order_by($parametros);
    }

    function _sql_limit($parametros) {
        if ($parametros['inicio'] != "") {
            $this->banco->limit($parametros['fim'], $parametros['inicio']);
        } else {
            $this->banco->limit($parametros['fim']);
        }
    }

    function _sql_campos($parametros) {
        $this->banco->select($parametros);
    }

    function _sql_max($parametros) {
        $this->banco->select_max(implode(',', $parametros));
    }

    function _sql_min($parametros) {
        $this->banco->select_min(implode(',', $parametros));
    }

    function _sql_sum($parametros) {
        $this->banco->select_sum(implode(',', $parametros));
    }

    function _sql_join($parametros) {
        if (is_array($parametros)) {
            foreach ($parametros as $k => $v) {
                $v['TABELA'] = (!isset($v['TABELA']) ? '' : $v['TABELA']);
                $v['TIPO'] = (!isset($v['TIPO']) ? '' : $v['TIPO']);
                $v['AND'] = (!isset($v['AND']) ? '' : $v['AND']);

                $this->banco->join($v['TABELA'], $v['AND'], $v['TIPO']);
            }
        }
    }

    function _sql_and_in($parametros) {
        if (is_array($parametros)) {
            foreach ($parametros as $k => $v) {
                $this->banco->where_in($k, $v);
            }
        }
    }

    function _sql_or_in($parametros) {
        if (is_array($parametros)) {
            foreach ($parametros as $k => $v) {
                $this->banco->or_where_in($k, $v);
            }
        }
    }

    function _sql_and_not_in($parametros) {
        if (is_array($parametros)) {
            foreach ($parametros as $k => $v) {
                $this->banco->where_not_in($k, $v);
            }
        }
    }

    function _sql_or_not_in($parametros) {
        if (is_array($parametros)) {
            foreach ($parametros as $k => $v) {
                $this->banco->or_where_not_in($k, $v);
            }
        }
    }

    function _sql_and_not_like($parametros) {
        if (is_array($parametros)) {
            $this->banco->not_like($parametros);
        }
    }

    function _sql_or_not_like($parametros) {
        if (is_array($parametros)) {
            $this->banco->or_not_like($parametros);
        }
    }

}

?>
