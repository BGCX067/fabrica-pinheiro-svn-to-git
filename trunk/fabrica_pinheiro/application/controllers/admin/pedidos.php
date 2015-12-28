<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pedidos
 *
 * @author Lucas Pinheiro
 */
class Pedidos extends Admin_controller {

    function __construct() {
        parent::__construct();
        $this->template->set_js('pedidos.js');
        $this->load->model('pedidos_model');
        $this->load->model('pedidos_itens_model');
    }

    function index() {
        $this->template->display('Selecione uma opção no menu.');
    }

    function consultar() {
        $v_dados = array();
        $v_dados['base_url'] = base_url();
        $v_dados['nome'] = '';
        $v_dados['data_hora'] = date('d/m/Y');
        $v_dados['situacao'] = combo_situacao();
        $dados = (Object) array();
        $dados->nome = NULL;
        $dados->data_hora = date('Y-m-d');
        $dados->situacao = NULL;
        if ($this->uri->segment(4, NULL) != NULL) {
            $dados = json_url_base64_decode($this->uri->segment(4, NULL));
            $v_dados['nome'] = $dados->nome;
            $v_dados['data_hora'] = formatarData($dados->data_hora, array('formato' => 'd/m/Y'));
            $v_dados['situacao'] = combo_situacao($dados->situacao);
        }
        $v_dados['conteudo'] = $this->_consultar($dados);
        $this->template->set_conteudo_titulo('Consultar Pedidos');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/pedidos/frm_con_pedidos_view', $v_dados, true));
    }

    function consulta() {
        $v_dados = array();
        $v_dados['nome'] = $this->input->post('nome');
        $v_dados['data_hora'] = formatarData($this->input->post('data_hora'), array('formato' => 'Y-m-d'));
        $v_dados['situacao'] = $this->input->post('situacao');

        redirect(url_admin() . 'pedidos/consultar/' . json_url_base64_encode($v_dados));
    }

    function _consultar($dados) {
        $params = array();

        if ($dados->nome != NULL) {
            $params['OR_LIKE']['pe.nome'] = $dados->nome;
        }
        if ($dados->data_hora != NULL) {
            $params['OR_LIKE']['DATE(pd.data_hora)'] = formatarData($dados->data_hora, array('formato' => 'Y-m-d'));
        }
        if ($dados->situacao != NULL) {
            $params['OR_LIKE']['pd.situacao'] = $dados->situacao;
        }

        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblClientes') . ' as cl',
            'AND' => 'pd.id_clientes = cl.id_clientes',
            'TIPO' => 'LEFT',
        );

        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblPessoas') . ' as pe',
            'AND' => 'cl.id_pessoas = pe.id_pessoas',
            'TIPO' => 'LEFT',
        );

        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblPedidoItens') . ' as pi',
            'AND' => 'pi.id_pedidos = pd.id_pedidos',
            'TIPO' => 'LEFT',
        );

        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblFormaPagamentos') . ' as fp',
            'AND' => 'pd.situacao = fp.id_forma_pagamentos',
            'TIPO' => 'LEFT',
        );

        $params['CAMPOS'] = 'pd.*, pe.nome, pe.cidade, pe.bairro, cl.email, SUM(pi.valor_total) as total, fp.descricao as fp_descricao';
        $params['GROUPBY'] = 'pi.id_pedidos ';
        $b_consultar_total = $this->pedidos_model->consultar_total($params);

        $params['LIMIT']['inicio'] = $this->uri->segment(5, NULL);
        $params['LIMIT']['fim'] = $this->total_registro_por_pagina;
        $b_consultar = $this->pedidos_model->consultar($params);

        $v_dados = array();
        $v_dados['pedidos'] = array();
        $v_dados['paginacao'] = '';

        if ($b_consultar != NULL) {
            foreach ($b_consultar as $k => $v) {
                $v_dados['pedidos'][$k]['id_pedidos'] = $v->id_pedidos;
                $v_dados['pedidos'][$k]['data_hora'] = formatarData($v->data_hora, array('formato' => 'd/m/Y H:i:s'));
                $v_dados['pedidos'][$k]['situacao'] = $v->fp_descricao;
                $v_dados['pedidos'][$k]['nome'] = $v->nome;
                $v_dados['pedidos'][$k]['cidade'] = $v->cidade;
                $v_dados['pedidos'][$k]['bairro'] = $v->bairro;
                $v_dados['pedidos'][$k]['email'] = $v->email;
                $v_dados['pedidos'][$k]['total'] = number_format($v->total, 2, ',', '.');
                $v_dados['pedidos'][$k]['acao'] = anchor(url_admin() . 'pedidos/detalhes/' . $v->id_pedidos, 'Detalhes', 'title="Detalhes do pedido"');
            }
            $config = array();
            $config['base_url'] = url_admin() . "pedidos/consultar/" . json_url_base64_encode($dados);
            $config['total_rows'] = $b_consultar_total;
            $config['per_page'] = $this->total_registro_por_pagina;
            $config['cur_page'] = 0;
            $config['uri_segment'] = 5;
            $config['num_links'] = 4;
            $config['first_link'] = 'Primeiro';
            $config['last_link'] = 'Último';
            $config['next_link'] = 'Próximo';
            $config['prev_link'] = 'Anterior';

            $this->pagination->initialize($config);
            $v_dados['paginacao'] = $this->pagination->create_links();
        }

        return $this->parser->parse($this->template->get_diretorio() . '/pedidos/lst_con_pedidos_view', $v_dados, true);
    }

    function detalhes() {
        $id_pedidos = $this->uri->segment(4);
        $imprimir = $this->uri->segment(5, 'N');
        $params = array();
        $params['AND']['pi.id_pedidos'] = $id_pedidos;

        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblPedidos') . ' as pd',
            'AND' => 'pi.id_pedidos = pd.id_pedidos',
            'TIPO' => 'LEFT',
        );

        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblClientes') . ' as cl',
            'AND' => 'pd.id_clientes = cl.id_clientes',
            'TIPO' => 'LEFT',
        );

        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblPessoas') . ' as pe',
            'AND' => 'cl.id_pessoas = pe.id_pessoas',
            'TIPO' => 'LEFT',
        );

        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblProdutos') . ' as pr',
            'AND' => 'pi.id_produtos = pr.id_produtos',
            'TIPO' => 'LEFT',
        );

        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblFormaPagamentos') . ' as fp',
            'AND' => 'pd.situacao = fp.id_forma_pagamentos',
            'TIPO' => 'LEFT',
        );
        $params['CAMPOS'] = 'pd.*,pi.*,pr.nome as pr_nome,cl.email,pe.nome, fp.descricao as fp_descricao';
        $b_consultar = $this->pedidos_itens_model->consultar($params);
        $v_dados = array();
        $v_dados['cliente'] = array();
        $v_dados['pedido'] = array();
        $v_dados['itens'] = array();
        $v_dados['total_geral'] = 0;

        if ($b_consultar != null) {
            foreach ($b_consultar as $k => $v) {
                $v_dados['cliente'][0]['id_clientes'] = $v->id_clientes;
                $v_dados['cliente'][0]['nome'] = $v->nome;
                $v_dados['cliente'][0]['email'] = $v->email;

                $v_dados['pedido'][0]['id_pedidos'] = $v->id_pedidos;
                $v_dados['pedido'][0]['data_hora'] = formatarData($v->data_hora, array('formato' => 'd/m/Y H:i:s'));
                $v_dados['pedido'][0]['situacao'] = $v->fp_descricao;

                $v_dados['itens'][$k]['id_pedido_itens'] = $v->id_pedido_itens;
                $v_dados['itens'][$k]['id_produtos'] = $v->id_produtos;
                $v_dados['itens'][$k]['qtd'] = $v->qtd;
                $v_dados['itens'][$k]['valor'] = number_format($v->valor, 2, ',', '.');
                $v_dados['itens'][$k]['valor_total'] = number_format($v->valor_total, 2, ',', '.');
                $v_dados['itens'][$k]['pr_nome'] = $v->pr_nome;

                $v_dados['total_geral'] += $v->valor_total;
            }
        }
        $v_dados['total_geral'] = number_format($v_dados['total_geral'], 2, ',', '.');
        $this->template->set_conteudo_titulo('Detalhes dp Pedido');
        if ($imprimir == "N") {
            $v_dados['bt_imprimir'] = '<button class="bt_imprimir"></button>';
            $this->template->display($this->parser->parse($this->template->get_diretorio() . '/pedidos/lst_con_detalhes_pedidos_view', $v_dados, true));
        } else {
            $v_dados['bt_imprimir'] = '';
            $this->template->display_imprimir($this->parser->parse($this->template->get_diretorio() . '/pedidos/lst_con_detalhes_pedidos_view', $v_dados, true));
        }
    }

}

?>