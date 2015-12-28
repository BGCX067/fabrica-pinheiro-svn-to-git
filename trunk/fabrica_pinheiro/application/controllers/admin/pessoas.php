<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pessoas
 *
 * @author Lucas Pinheiro
 */
class Pessoas extends Admin_controller {

    function __construct() {
        parent::__construct();
        $this->template->set_js('pessoas.js');
        $this->load->model('pessoas_model');
    }

    function index() {
        $this->template->display('Selecione uma opção no menu.');
    }

    function cadastrar() {
        $v_dados = array();
        $v_dados['id_pessoas'] = '';
        $v_dados['nome'] = '';
        $v_dados['tipo_pessoa'] = combo_tipo_pessoas();
        $v_dados['endereco'] = '';
        $v_dados['numero'] = '';
        $v_dados['complemento'] = '';
        $v_dados['bairro'] = '';
        $v_dados['cidade'] = '';
        $v_dados['estado'] = '';
        $v_dados['cep'] = '';
        $v_dados['inscricao'] = '';
        $v_dados['data_cadastro'] = '';
        $v_dados['telefone'] = '';
        $v_dados['celular'] = '';
        $v_dados['identidade'] = '';
        $v_dados['email_moip'] = '';
        $this->template->set_conteudo_titulo('Cadastrar Pessoa');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/pessoas/frm_cad_pessoas_view', $v_dados, true));
    }

    function alterar() {
        $params = array();
        $params['AND']['id_pessoas'] = $this->uri->segment(4);
        $b_consultar = $this->pessoas_model->consultar($params);
        $b_consultar = $b_consultar[0];
        $v_dados = array();
        $v_dados['id_pessoas'] = $b_consultar->id_pessoas;
        $v_dados['nome'] = $b_consultar->nome;
        $v_dados['tipo_pessoa'] = combo_tipo_pessoas($b_consultar->tipo_pessoa);
        $v_dados['endereco'] = $b_consultar->endereco;
        $v_dados['numero'] = $b_consultar->numero;
        $v_dados['complemento'] = $b_consultar->complemento;
        $v_dados['bairro'] = $b_consultar->bairro;
        $v_dados['cidade'] = $b_consultar->cidade;
        $v_dados['estado'] = $b_consultar->estado;
        $v_dados['cep'] = formataString(array('entrada' => $b_consultar->cep, 'formato' => 'cep'));
        $v_dados['inscricao'] = formataString(array('entrada' => $b_consultar->inscricao, 'formato' => 'cpf_cnpj'));
        $v_dados['data_cadastro'] = $b_consultar->data_cadastro;
        $v_dados['telefone'] = formataString(array('entrada' => $b_consultar->telefone, 'formato' => 'telefone'));
        $v_dados['celular'] = formataString(array('entrada' => $b_consultar->celular, 'formato' => 'telefone'));
        $v_dados['identidade'] = $b_consultar->identidade;
        $v_dados['email_moip'] = $b_consultar->email_moip;
        $this->template->set_conteudo_titulo('Alterar Pessoa');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/pessoas/frm_cad_pessoas_view', $v_dados, true));
    }

    function consultar() {
        $v_dados = array();
        $v_dados['base_url'] = base_url();
        $v_dados['nome'] = '';
        $v_dados['tipo_pessoa'] = combo_tipo_pessoas();
        $dados = (Object) array();
        $dados->nome = NULL;
        $dados->tipo_pessoa = NULL;
        $dados->inscricao = NULL;
        if ($this->uri->segment(4, NULL) != NULL) {
            $dados = json_url_base64_decode($this->uri->segment(4, NULL));
            $v_dados['nome'] = $dados->nome;
            $v_dados['tipo_pessoa'] = combo_tipo_pessoas($dados->tipo_pessoa);
        }
        $v_dados['conteudo'] = $this->_consultar($dados);
        $this->template->set_conteudo_titulo('Consultar Pessoa');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/pessoas/frm_con_pessoas_view', $v_dados, true));
    }

    function consulta() {
        $v_dados = array();
        $v_dados['nome'] = $this->input->post('nome');
        $v_dados['tipo_pessoa'] = $this->input->post('tipo_pessoa');

        redirect(url_admin() . 'pessoas/consultar/' . json_url_base64_encode($v_dados));
    }

    function _consultar($dados) {
        $params = array();

        if ($dados->nome != NULL) {
            $params['OR_LIKE']['pe.nome'] = $dados->nome;
        }
        if ($dados->tipo_pessoa != NULL) {
            $params['OR_LIKE']['pe.tipo_pessoa'] = $dados->tipo_pessoa;
        }

        $b_consultar_total = $this->pessoas_model->consultar_total($params);

        $params['LIMIT']['inicio'] = $this->uri->segment(5, NULL);
        $params['LIMIT']['fim'] = $this->total_registro_por_pagina;
        $b_consultar = $this->pessoas_model->consultar($params);

        $v_dados = array();
        $v_dados['pessoas'] = array();
        $v_dados['paginacao'] = '';

        if ($b_consultar != NULL) {
            foreach ($b_consultar as $k => $v) {
                $v_dados['pessoas'][$k]['id_pessoas'] = $v->id_pessoas;
                $v_dados['pessoas'][$k]['nome'] = $v->nome;
                $v_dados['pessoas'][$k]['tipo_pessoa'] = $v->tipo_pessoa;
                $v_dados['pessoas'][$k]['endereco'] = $v->endereco;
                $v_dados['pessoas'][$k]['numero'] = $v->numero;
                $v_dados['pessoas'][$k]['complemento'] = $v->complemento;
                $v_dados['pessoas'][$k]['bairro'] = $v->bairro;
                $v_dados['pessoas'][$k]['cidade'] = $v->cidade;
                $v_dados['pessoas'][$k]['estado'] = $v->estado;
                $v_dados['pessoas'][$k]['data_cadastro'] = formatarData($v->data_cadastro, array('formato' => 'd/m/Y H:i:s'));
                $v_dados['pessoas'][$k]['inscricao'] = formataString(array('entrada' => $v->inscricao, 'formato' => 'cpf_cnpj'));
                $v_dados['pessoas'][$k]['cep'] = formataString(array('entrada' => $v->cep, 'formato' => 'cep'));
                $v_dados['pessoas'][$k]['acao'] = anchor(url_admin() . 'pessoas/alterar/' . $v->id_pessoas, 'Alterar');
                $v_dados['pessoas'][$k]['acao'] .= anchor(url_admin() . 'usuarios/cadastrar/' . $v->id_pessoas, 'Usuário', 'title="Cadastrar/Alterar Usuário"');
                $v_dados['pessoas'][$k]['acao'] .= anchor(url_admin() . 'clientes/cadastrar/' . $v->id_pessoas, 'Cliente', 'title="Cadastrar/Alterar Cliente"');
            }
            $config = array();
            $config['base_url'] = url_admin() . "pessoas/consultar/" . json_url_base64_encode($dados);
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

        return $this->parser->parse($this->template->get_diretorio() . '/pessoas/lst_con_pessoas_view', $v_dados, true);
    }

    function gravar() {
        $this->form_validation->set_rules('nome', 'Nome', 'required|trim');
        $this->form_validation->set_rules('tipo_pessoa', 'Tipo de Pessoa', 'required|trim');
        $this->form_validation->set_rules('endereco', 'Endereço', 'required|trim');
        $this->form_validation->set_rules('numero', 'Número', 'required|trim');
        $this->form_validation->set_rules('bairro', 'Bairro', 'required|trim');
        $this->form_validation->set_rules('cidade', 'Cidade', 'required|trim');
        $this->form_validation->set_rules('estado', 'Estado', 'required|trim');
        $this->form_validation->set_rules('cep', 'CEP', 'required|trim');
        $this->form_validation->set_rules('inscricao', 'Inscrição', 'required|trim');
        $this->form_validation->set_rules('email_moip', 'E-mail moip', 'required|trim|valid_email');
        $this->form_validation->set_rules('telefone', 'Telefone', 'required|trim');

        $v_dados = array();

        if ($this->form_validation->run() === FALSE) {
            $v_dados['cod'] = 111;
            $v_dados['msg'] = $this->form_validation->msg_erros_campos_json();
            $v_dados['campos'] = $this->form_validation->erros_campos_json();
        } else {
            $params = array();
            //id_pessoas, nome, tipo_pessoa, endereco, numero, complemento, bairro, cidade, estado, cep, inscricao, data_cadastro, , , , 
            $params['SET']['nome'] = $this->input->post('nome');
            $params['SET']['tipo_pessoa'] = $this->input->post('tipo_pessoa');
            $params['SET']['endereco'] = $this->input->post('endereco');
            $params['SET']['numero'] = $this->input->post('numero');
            $params['SET']['complemento'] = $this->input->post('complemento');
            $params['SET']['bairro'] = $this->input->post('bairro');
            $params['SET']['cidade'] = $this->input->post('cidade');
            $params['SET']['estado'] = $this->input->post('estado');
            $params['SET']['identidade'] = $this->input->post('identidade');
            $params['SET']['email_moip'] = $this->input->post('email_moip');
            $params['SET']['cep'] = limpaString(array('entrada' => $this->input->post('cep')));
            $params['SET']['inscricao'] = limpaString(array('entrada' => $this->input->post('inscricao')));
            $params['SET']['telefone'] = limpaString(array('entrada' => $this->input->post('telefone')));
            $params['SET']['celular'] = limpaString(array('entrada' => $this->input->post('celular')));
            if ($this->input->post('id_pessoas') == "") {
                $params['SET']['data_cadastro'] = date('Y-m-d H:i:s');
                $v_dados['id_pessoas'] = $this->pessoas_model->cadastrar($params);
                $v_dados['msg'] = 'Pessoa cadastrada com sucesso.';
            } else {
                $params['AND']['id_pessoas'] = $this->input->post('id_pessoas');
                $v_dados['id_pessoas'] = $this->input->post('id_pessoas');
                $this->pessoas_model->alterar($params);
                $v_dados['msg'] = 'Pessoa alterada com sucesso.';
            }
            $v_dados['cod'] = 999;
        }
        echo json_encode($v_dados);
    }

}

?>