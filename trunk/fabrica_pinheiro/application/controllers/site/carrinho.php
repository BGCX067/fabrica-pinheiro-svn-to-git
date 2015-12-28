<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of carrinho
 *
 * @author lucas
 */
class Carrinho extends Site_controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->model('produtos_model');
        $this->load->model('pessoas_model');
        $this->load->model('clientes_model');
        $this->load->model('pedidos_model');
        $this->load->model('pedidos_itens_model');
    }
    
    public function index(){}

    function adicionar() {
        $carrinho = $this->session->userdata('carrinho');

        if (!$this->session->userdata('carrinho')) {
            $carrinho = array();
        }
        $carrinho[$this->input->post('id_produto')]['codigo'] = (int) $this->input->post('id_produto');
        if (isset($carrinho[$this->input->post('id_produto')]['qtd'])) {
            $carrinho[$this->input->post('id_produto')]['qtd'] += (int) $this->input->post('quantidade');
        } else {
            $carrinho[$this->input->post('id_produto')]['qtd'] = (int) $this->input->post('quantidade');
        }
        $v_dados = array();
        $v_dados['id_produto'] = $this->input->post('id_produto');
        $v_dados['quantidade'] = $this->input->post('quantidade');
        $v_dados['msg'] = 'Produto adicionado no carrinho com sucesso.';
        $v_dados['cod'] = 999;
        $this->session->set_userdata('carrinho', $carrinho);
        $carrinho_total = $this->_listar();
        $v_dados['carrinho_total'] = $carrinho_total['total_geral'];
        echo json_encode($v_dados);
    }

    function atualizar() {
        $carrinho = $this->session->userdata('carrinho');

        if (!$this->session->userdata('carrinho')) {
            $carrinho = array();
        }
        $carrinho[$this->input->post('id_produto')]['codigo'] = (int) $this->input->post('id_produto');
        if ($this->input->post('quantidade') > 0) {
            $carrinho[$this->input->post('id_produto')]['qtd'] = (int) $this->input->post('quantidade');
        } else {
            unset($carrinho[$this->input->post('id_produto')]);
        }
        $v_dados = array();
        $v_dados['id_produto'] = $this->input->post('id_produto');
        $v_dados['quantidade'] = $this->input->post('quantidade');
        $v_dados['msg'] = 'Produto atualizado no carrinho com sucesso.';
        $v_dados['cod'] = 999;
        $this->session->set_userdata('carrinho', $carrinho);
        $carrinho_total = $this->_listar();
        $v_dados['carrinho_total'] = $carrinho_total['total_geral'];
        echo json_encode($v_dados);
    }

    function listar() {
        $v_dados = $this->_listar();
        if ($v_dados['cod'] == 111) {
            $this->template->set_msg('Nenhum registro localizado', 'erro', 'ui-icon-alert');
        } else if ($this->uri->segment(4, null) == 'error') {
            $this->template->set_msg('Não foi possível finalizar a compra, tente novamente.', 'erro', 'ui-icon-alert');
        }
        $v_dados['forma_pagamento'] = combo_forma_pagamento('cartao_credito');

        $this->template->set_conteudo_titulo('Carrinho');
        $this->template->set_breadcrumbs('Carrinho');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/carrinho/lst_carrino_view', $v_dados, true));
    }

    function _listar() {
        $v_dados = array();
        $v_dados['produtos'] = array();
        $v_dados['total_geral'] = 0;
        $carrinho = $this->session->userdata('carrinho');

        if (count($carrinho) > 0 AND $carrinho != '') {
            $v_dados['cod'] = 999;
            foreach ($carrinho as $k => $v) {
                $params = array();
                $params['AND']['id_produtos'] = $v['codigo'];
                $b_consultar = $this->produtos_model->consultar($params);
                if ($b_consultar != null) {
                    foreach ($b_consultar as $k1 => $v1) {
                        $v_dados['produtos'][$k]['id_produtos'] = $v1->id_produtos;
                        $v_dados['produtos'][$k]['produto'] = $v1->nome;
                        $v_dados['produtos'][$k]['valor_unitario'] = number_format($v1->valor, 2, ',', '.');
                        $v_dados['produtos'][$k]['valor_total'] = number_format(($v1->valor * $v['qtd']), 2, ',', '.');
                        $v_dados['produtos'][$k]['quantidade'] = $v['qtd'];
                        $v_dados['total_geral'] += ($v1->valor * $v['qtd']);
                    }
                }
            }
        } else {
            $v_dados['cod'] = 111;
        }
        $v_dados['total_geral'] = number_format($v_dados['total_geral'], 2, ',', '.');
        $this->session->set_userdata('carrinho_total', $v_dados['total_geral']);
        return $v_dados;
    }

    function remover() {
        $carrinho = $this->session->userdata('carrinho');

        if (!$this->session->userdata('carrinho')) {
            $carrinho = array();
        }

        unset($carrinho[$this->input->post('id_produto')]);

        $v_dados = array();
        $v_dados['id_produto'] = $this->input->post('id_produto');
        $v_dados['msg'] = 'Produto removido do carrinho com sucesso.';
        $v_dados['cod'] = 999;
        $this->session->set_userdata('carrinho', $carrinho);
        $carrinho_total = $this->_listar();
        $v_dados['carrinho_total'] = $carrinho_total['total_geral'];
        echo json_encode($v_dados);
    }

    function finalizar($forma_pagamento) {
        if (!$this->session->userdata('clienteNome')) {
            $this->session->set_userdata('redirect_login_carrinho', url_site() . 'carrinho/finalizar/' . $forma_pagamento);
            redirect(url_site() . 'login');
        } else {
            $this->session->set_userdata('redirect_login_carrinho', '');
            $this->session->unset_userdata('redirect_login_carrinho');

            if (!$this->session->userdata('carrinho')) {
                redirect(base_url() . 'site/carrinho/listar/error/');
            } else {

                $this->load->library('moip/MoIP');


                $uniqueID = md5($this->config->item('moipId') . date('Y-m-d H:i:s') . $this->session->userdata('clienteEmail'));

                $this->moip->setCredential(array('key' => $this->config->item('moipKey'), 'token' => $this->config->item('moipToken')));
                $this->moip->setUniqueID($uniqueID);
                $this->moip->setEnvironment($this->config->item('moipEnvironment'));

                $this->moip->setReason('Teste do MoIP-PHP');
                $this->moip->addPaymentWay($forma_pagamento, array(
                    'dias_expiracao' => array(
                        'dias' => 5,
                        'tipo' => 'corridos'
                    )
                        )
                );


                $params = array();
                $params['AND']['cl.id_clientes'] = $this->session->userdata('clienteId');
                $params['JOIN'][] = array(
                    'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblPessoas') . ' as pe',
                    'TIPO' => 'INNER',
                    'AND' => 'cl.id_pessoas = pe.id_pessoas'
                );
                $b_consultar = $this->clientes_model->consultar($params);

                $this->moip->setPayer(
                        array(
                            'nome' => $b_consultar[0]->nome,
                            'login_moip' => $b_consultar[0]->email_moip,
                            'email' => $b_consultar[0]->email,
                            'celular' => limpaString(array('entrada' => $b_consultar[0]->celular)),
                            'apelido' => '',
                            'identidade' => $b_consultar[0]->identidade,
                            'endereco' => array(
                                'logradouro' => $b_consultar[0]->endereco,
                                'numero' => $b_consultar[0]->numero,
                                'complemento' => $b_consultar[0]->complemento,
                                'cidade' => $b_consultar[0]->cidade,
                                'estado' => $b_consultar[0]->estado,
                                'pais' => 'Brasil',
                                'cep' => limpaString(array('entrada' => $b_consultar[0]->cep)),
                                'telefone' => limpaString(array('entrada' => $b_consultar[0]->telefone)))
                        )
                );

                $total_geral = 0;
                $carrinho = $this->session->userdata('carrinho');

                if (count($carrinho) > 0 AND $carrinho != '') {
                    foreach ($carrinho as $k => $v) {
                        $params = array();
                        $params['AND']['id_produtos'] = $v['codigo'];
                        $b_consultar_pro = $this->produtos_model->consultar($params);
                        if ($b_consultar_pro != null) {
                            foreach ($b_consultar_pro as $k1 => $v1) {
                                $total_geral += ($v1->valor * $v['qtd']);
                            }
                        }
                    }
                }
                $this->moip->setValue($total_geral);
                $this->moip->validate();
                $x_retorno = $this->moip->send();
                //pre($x_retorno);
                //exit;
                if ($x_retorno->getAnswer()->token != '') {

                    $params = array();
                    $params['SET']['id_clientes'] = $b_consultar[0]->id_clientes;
                    $params['SET']['data_hora'] = date('Y-m-d H:i:s');
                    $params['SET']['situacao'] = 2;
                    $params['SET']['unique_id'] = $uniqueID;
                    $params['SET']['moip_token'] = $x_retorno->getAnswer()->token;
                    $id_pedido = $this->pedidos_model->cadastrar($params);
                    if (count($carrinho) > 0 AND $carrinho != '') {
                        foreach ($carrinho as $k => $v) {
                            $params = array();
                            $params['AND']['id_produtos'] = $v['codigo'];
                            $b_consultar = $this->produtos_model->consultar($params);
                            if ($b_consultar != null) {
                                foreach ($b_consultar as $k1 => $v1) {
                                    $params = array();
                                    $params['SET']['id_pedidos'] = (int) $id_pedido;
                                    $params['SET']['id_produtos'] = (int) $v['codigo'];
                                    $params['SET']['qtd'] = (int) $v['qtd'];
                                    $params['SET']['valor'] = (Double) $v1->valor;
                                    $params['SET']['valor_total'] = (Double) ($v1->valor * ( (int) $v['qtd']));
                                    $this->pedidos_itens_model->cadastrar($params);
                                }
                            }
                        }
                    }
                    $this->baixa_estoque();
                    $this->cancelar();
                    redirect('https://desenvolvedor.moip.com.br/sandbox/Instrucao.do?token=' . $x_retorno->getAnswer()->token);
                    //redirect($x_retorno->payment_url);
                } else {
                    redirect(base_url() . 'site/carrinho/listar/error/');
                }
            }
        }
    }

    function cancelar() {
        $this->session->set_userdata('carrinho', '');
        $this->session->set_userdata('carrinho_total', '');
        $this->session->unset_userdata('carrinho');
        $this->session->unset_userdata('carrinho_total');
        echo json_encode(array('cod' => 999, 'msg' => 'Carrinho cancelado com sucesso.'));
    }

    function baixa_estoque() {
        $carrinho = $this->session->userdata('carrinho');
        if (count($carrinho) > 0 AND $carrinho != '') {
            foreach ($carrinho as $v) {
                $params = array();
                $params['AND']['id_produtos'] = $v['codigo'];
                $params['SET']['quantidade'] = $v['qtd'];
                $this->produtos_model->alterar($params);
            }
        }
    }

    function retorno_automatico() {
        $params = array();
        $params['AND']['unique_id'] = $this->input->post('id_transacao');
        $params['SET']['situacao'] = $this->input->post('status_pagamento');
        $params['SET']['cod_moip'] = $this->input->post('cod_moip');
        $params['SET']['forma_pagamento'] = $this->input->post('forma_pagamento');
        $params['SET']['tipo_pagamento'] = $this->input->post('tipo_pagamento');
        $params['SET']['email_consumidor'] = $this->input->post('email_consumidor');
        $params['SET']['valor_pago'] = $this->input->post('valor');

        $b_alterar = $this->pedidos_model->alterar($params);
        
        if ($b_alterar == null && empty($params['SET']['cod_moip'])) {
            header("HTTP/1.0 404 Not Found");
        } else {
            header("HTTP/1.0 200 OK");
        }
    }

}

?>
