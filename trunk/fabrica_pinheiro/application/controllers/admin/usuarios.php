<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuarios
 *
 * @author Lucas Pinheiro
 */
class Usuarios extends Admin_controller {

    function __construct() {
        parent::__construct();
        $this->template->set_js('usuarios.js');
        $this->load->model('usuarios_model');
    }

    function index() {
        $this->template->display('Selecione uma opção no menu.');
    }

    function cadastrar() {
        $params = array();
        $params['AND']['us.id_pessoas'] = $this->uri->segment(4);
        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblPessoas') . ' as pe',
            'AND' => 'us.id_pessoas = pe.id_pessoas',
            'TIPO' => 'INNER',
        );
        $b_consultar = $this->usuarios_model->consultar($params);
        $v_dados = array();
        $v_dados['senha'] = '';
        if ($b_consultar != null) {
            $b_consultar = $b_consultar[0];
            $v_dados['id_usuarios'] = $b_consultar->id_usuarios;
            $v_dados['email'] = $b_consultar->email;
            $v_dados['status'] = combo_status($b_consultar->status);
            $v_dados['id_pessoas'] = $b_consultar->id_pessoas;
            $this->template->set_conteudo_titulo('Alterar Usuário');
        } else {
            $v_dados['id_usuarios'] = '';
            $v_dados['email'] = '';
            $v_dados['status'] = combo_status();
            $v_dados['id_pessoas'] = $this->uri->segment(4);
            $this->template->set_conteudo_titulo('Cadasrar Usuário');
        }
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/usuarios/frm_cad_usuarios_view', $v_dados, true));
    }

    function consultar() {
        $v_dados = array();
        $v_dados['base_url'] = base_url();
        $v_dados['email'] = '';
        $v_dados['status'] = combo_status();
        $dados = (Object) array();
        $dados->nome = NULL;
        $dados->email = NULL;
        $dados->status = NULL;
        if ($this->uri->segment(4, NULL) != NULL) {
            $dados = json_url_base64_decode($this->uri->segment(4, NULL));
            $v_dados['email'] = $dados->email;
            $v_dados['status'] = combo_status($dados->status);
        }
        $v_dados['conteudo'] = $this->_consultar($dados);
        $this->template->set_conteudo_titulo('Consultar Usuários');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/usuarios/frm_con_usuarios_view', $v_dados, true));
    }

    function consulta() {
        $v_dados = array();
        $v_dados['email'] = $this->input->post('email');
        $v_dados['status'] = $this->input->post('status');

        redirect(url_admin() . 'usuarios/consultar/' . json_url_base64_encode($v_dados));
    }

    function _consultar($dados) {
        $params = array();

        if ($dados->email != NULL) {
            $params['OR_LIKE']['us.email'] = $dados->email;
        }
        if ($dados->status != NULL) {
            $params['AND']['us.status'] = $dados->status;
        }

        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblPessoas') . ' as pe',
            'AND' => 'us.id_pessoas = pe.id_pessoas',
            'TIPO' => 'LEFT',
        );
        $b_consultar_total = $this->usuarios_model->consultar_total($params);

        $params['LIMIT']['inicio'] = $this->uri->segment(5, NULL);
        $params['LIMIT']['fim'] = $this->total_registro_por_pagina;
        $b_consultar = $this->usuarios_model->consultar($params);

        $v_dados = array();
        $v_dados['usuarios'] = array();
        $v_dados['paginacao'] = '';

        if ($b_consultar != NULL) {
            foreach ($b_consultar as $k => $v) {
                $v_dados['usuarios'][$k]['id_usuarios'] = $v->id_usuarios;
                $v_dados['usuarios'][$k]['email'] = $v->email;
                $v_dados['usuarios'][$k]['senha'] = $v->senha;
                $v_dados['usuarios'][$k]['status'] = ($v->status == 'A' ? 'Ativo' : 'Inativo');
                $v_dados['usuarios'][$k]['id_pessoas'] = $v->id_pessoas;
                $v_dados['usuarios'][$k]['nome'] = $v->nome;
                $v_dados['usuarios'][$k]['tipo_pessoa'] = ($v->tipo_pessoa == 'F' ? 'Física' : 'Júridica');
                $v_dados['usuarios'][$k]['endereco'] = $v->endereco;
                $v_dados['usuarios'][$k]['numero'] = $v->numero;
                $v_dados['usuarios'][$k]['complemento'] = $v->complemento;
                $v_dados['usuarios'][$k]['bairro'] = $v->bairro;
                $v_dados['usuarios'][$k]['cidade'] = $v->cidade;
                $v_dados['usuarios'][$k]['estado'] = $v->estado;
                $v_dados['usuarios'][$k]['data_cadastro'] = formatarData($v->data_cadastro, array('formato' => 'd/m/Y H:i:s'));
                $v_dados['usuarios'][$k]['inscricao'] = formataString(array('entrada' => $v->inscricao, 'formato' => 'cpf_cnpj'));
                $v_dados['usuarios'][$k]['cep'] = formataString(array('entrada' => $v->cep, 'formato' => 'cep'));
                $v_dados['usuarios'][$k]['acao'] = anchor(url_admin() . 'usuarios/cadastrar/' . $v->id_pessoas, 'Alterar');
            }
            $config = array();
            $config['base_url'] = url_admin() . "usuarios/consultar/" . json_url_base64_encode($dados);
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

        return $this->parser->parse($this->template->get_diretorio() . '/usuarios/lst_con_usuarios_view', $v_dados, true);
    }

    function gravar() {
        $this->form_validation->set_rules('email', 'E-mail', 'email|required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');
        $this->form_validation->set_rules('id_pessoas', 'ID Pessoa', 'required|trim');

        if ($this->input->post('id_usuarios') == '') {
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
            if ($this->input->post('senha') != '') {
                $params['SET']['senha'] = md5($this->input->post('senha'));
            }
            $params['SET']['status'] = $this->input->post('status');
            $params['SET']['id_pessoas'] = $this->input->post('id_pessoas');
            if ($this->input->post('id_usuarios') == "") {
                $params2 = array();
                $params2['AND']['email'] = $this->input->post('email');
                $b_consultar = $this->usuarios_model->consultar($params2);
                if ($b_consultar == null) {
                    $v_dados['id_usuarios'] = $this->usuarios_model->cadastrar($params);
                    $v_dados['msg'] = 'Usuário cadastrado com sucesso.';
                } else {
                    $v_dados['cod'] = 222;
                    $v_dados['msg'] = 'Usuário com este e-mail já exite';
                }
            } else {
                $params['AND']['id_usuarios'] = $this->input->post('id_usuarios');
                $v_dados['id_usuarios'] = $this->input->post('id_usuarios');
                $this->usuarios_model->alterar($params);
                $v_dados['msg'] = 'Usuário alterado com sucesso.';
            }
        }
        echo json_encode($v_dados);
    }

}

?>