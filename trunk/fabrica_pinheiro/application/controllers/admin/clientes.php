<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clientes
 *
 * @author Lucas Pinheiro
 */
class Clientes extends Admin_controller {

    function __construct() {
        parent::__construct();
        $this->template->set_js('clientes.js');
        $this->load->model('clientes_model');
    }

    function index() {
        $this->template->display('Selecione uma opção no menu.');
    }

    function cadastrar() {
        $params = array();
        $params['AND']['cl.id_pessoas'] = $this->uri->segment(4);
        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblPessoas') . ' as pe',
            'AND' => 'cl.id_pessoas = pe.id_pessoas',
            'TIPO' => 'INNER',
        );
        $b_consultar = $this->clientes_model->consultar($params);
        $v_dados = array();
        $v_dados['senha'] = '';
        if ($b_consultar != null) {
            $b_consultar = $b_consultar[0];
            $v_dados['id_clientes'] = $b_consultar->id_clientes;
            $v_dados['email'] = $b_consultar->email;
            $v_dados['status'] = combo_status($b_consultar->status);
            $v_dados['id_pessoas'] = $b_consultar->id_pessoas;
            $this->template->set_conteudo_titulo('Alterar Cliente');
        } else {
            $v_dados['id_clientes'] = '';
            $v_dados['email'] = '';
            $v_dados['status'] = combo_status();
            $v_dados['id_pessoas'] = $this->uri->segment(4);
            $this->template->set_conteudo_titulo('Cadasrar Cliente');
        }
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/clientes/frm_cad_clientes_view', $v_dados, true));
    }

    function consultar() {
        $v_dados = array();
        $v_dados['base_url'] = base_url();
        $v_dados['email'] = '';
        $v_dados['status'] = combo_status();
        $dados = (Object) array();
        $dados->email = NULL;
        $dados->status = NULL;
        if ($this->uri->segment(4, NULL) != NULL) {
            $dados = json_url_base64_decode($this->uri->segment(4, NULL));
            $v_dados['email'] = $dados->email;
            $v_dados['status'] = combo_status($dados->status);
        }
        $v_dados['conteudo'] = $this->_consultar($dados);
        $this->template->set_conteudo_titulo('Consultar Clientes');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/clientes/frm_con_clientes_view', $v_dados, true));
    }

    function consulta() {
        $v_dados = array();
        $v_dados['email'] = $this->input->post('email');
        $v_dados['status'] = $this->input->post('status');

        redirect(url_admin() . 'clientes/consultar/' . json_url_base64_encode($v_dados));
    }

    function _consultar($dados) {
        $params = array();

        if ($dados->email != NULL) {
            $params['OR_LIKE']['cl.email'] = $dados->email;
        }
        if ($dados->status != NULL) {
            $params['AND']['cl.status'] = $dados->status;
        }

        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblPessoas') . ' as pe',
            'AND' => 'cl.id_pessoas = pe.id_pessoas',
            'TIPO' => 'LEFT',
        );
        $b_consultar_total = $this->clientes_model->consultar_total($params);

        $params['LIMIT']['inicio'] = $this->uri->segment(5, NULL);
        $params['LIMIT']['fim'] = $this->total_registro_por_pagina;
        $b_consultar = $this->clientes_model->consultar($params);

        $v_dados = array();
        $v_dados['clientes'] = array();
        $v_dados['paginacao'] = '';

        if ($b_consultar != NULL) {
            foreach ($b_consultar as $k => $v) {
                $v_dados['clientes'][$k]['id_clientes'] = $v->id_clientes;
                $v_dados['clientes'][$k]['email'] = $v->email;
                $v_dados['clientes'][$k]['senha'] = $v->senha;
                $v_dados['clientes'][$k]['status'] = ($v->status == 'A' ? 'Ativo' : 'Inativo');
                $v_dados['clientes'][$k]['id_pessoas'] = $v->id_pessoas;
                $v_dados['clientes'][$k]['nome'] = $v->nome;
                $v_dados['clientes'][$k]['tipo_pessoa'] = ($v->tipo_pessoa == 'F' ? 'Física' : 'Júridica');
                $v_dados['clientes'][$k]['endereco'] = $v->endereco;
                $v_dados['clientes'][$k]['numero'] = $v->numero;
                $v_dados['clientes'][$k]['complemento'] = $v->complemento;
                $v_dados['clientes'][$k]['bairro'] = $v->bairro;
                $v_dados['clientes'][$k]['cidade'] = $v->cidade;
                $v_dados['clientes'][$k]['estado'] = $v->estado;
                $v_dados['clientes'][$k]['data_cadastro'] = formatarData($v->data_cadastro, array('formato' => 'd/m/Y H:i:s'));
                $v_dados['clientes'][$k]['inscricao'] = formataString(array('entrada' => $v->inscricao, 'formato' => 'cpf_cnpj'));
                $v_dados['clientes'][$k]['cep'] = formataString(array('entrada' => $v->cep, 'formato' => 'cep'));
                $v_dados['clientes'][$k]['acao'] = anchor(url_admin() . 'clientes/cadastrar/' . $v->id_pessoas, 'Alterar');
            }
            $config = array();
            $config['base_url'] = url_admin() . "clientes/consultar/" . json_url_base64_encode($dados);
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

        return $this->parser->parse($this->template->get_diretorio() . '/clientes/lst_con_clientes_view', $v_dados, true);
    }

    function gravar() {
        $this->form_validation->set_rules('email', 'E-mail', 'email|required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');
        $this->form_validation->set_rules('id_pessoas', 'ID Pessoa', 'required|trim');

        if ($this->input->post('id_clientes') == '') {
            $this->form_validation->set_rules('senha', 'Senha', 'required|trim');
        }

        $v_dados = array();

        if ($this->form_validation->run() === FALSE) {
            $v_dados['cod'] = 111;
            $v_dados['msg'] = $this->form_validation->msg_erros_campos_json();
            $v_dados['campos'] = $this->form_validation->erros_campos_json();
        } else {
            $v_dados['cod'] = 999;
            $params = array();
            $params['SET']['email'] = $this->input->post('email');
            if ($this->input->post('senha') != false) {
                $params['SET']['senha'] = md5($this->input->post('senha'));
            }
            $params['SET']['status'] = $this->input->post('status');
            $params['SET']['id_pessoas'] = $this->input->post('id_pessoas');
            if ($this->input->post('id_clientes') == "") {
                $params2 = array();
                $params2['AND']['email'] = $this->input->post('email');
                $b_consultar = $this->clientes_model->consultar($params2);
                if ($b_consultar == null) {
                    $v_dados['id_usuarios'] = $this->clientes_model->cadastrar($params);
                    $v_dados['msg'] = 'Usuário cadastrado com sucesso.';
                } else {
                    $v_dados['cod'] = 222;
                    $v_dados['msg'] = 'Cliente com este e-mail já exite';
                }
            } else {
                $params['AND']['id_clientes'] = $this->input->post('id_clientes');
                $v_dados['id_clientes'] = $this->input->post('id_clientes');
                $this->clientes_model->alterar($params);
                $v_dados['msg'] = 'Cliente alterado com sucesso.';
            }
        }
        echo json_encode($v_dados);
    }

}

?>