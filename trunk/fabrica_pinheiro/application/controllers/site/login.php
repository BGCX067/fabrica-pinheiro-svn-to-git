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
class login extends Site_controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->template->set_js('php.min.js');
        $this->template->set_js('login.js');
        $this->template->set_breadcrumbs('Área Administrativa');
        $this->load->model('pessoas_model');
        $this->load->model('clientes_model');
        $this->load->helper('combos');
    }

    function index() {
        $v_dados = array();
        $this->template->set_conteudo_titulo('Área Administrativa');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/admin/login_view', $v_dados, true));
    }

    function logar() {
        $this->form_validation->set_rules('email', 'E-mail', 'email|required|trim');
        $this->form_validation->set_rules('senha', 'Senha', 'required|trim');

        $v_dados = array();
        if ($this->form_validation->run() === FALSE) {
            $v_dados['cod'] = 111;
            $v_dados['msg'] = $this->form_validation->msg_erros_campos_json();
            $v_dados['campos'] = $this->form_validation->erros_campos_json();
        } else {
            $params = array();
            $params['AND']['cl.email'] = trim($this->input->post('email'));
            $params['AND']['cl.senha'] = $this->input->post('senha');
            $params['AND']['cl.status'] = "A";
            $params['JOIN'][] = array(
                'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblPessoas') . ' as pe',
                'TIPO' => 'INNER',
                'AND' => 'cl.id_pessoas = pe.id_pessoas'
            );
            //pre($params);
            $b_consultar = $this->clientes_model->consultar($params);
            //pre($b_consultar);
            if ($b_consultar == null) {
                $v_dados['cod'] = 222;
                $v_dados['msg'] = 'Usuário ou senha inválidos.';
            } else {
                $v_dados['cod'] = 999;
                $v_dados['msg'] = 'Aguarde... Redirecionando para a área administrativa.';
                if (!$this->session->userdata('redirect_login_carrinho')) {
                    $v_dados['link'] = url_site();
                } else {
                    $v_dados['link'] = $this->session->userdata('redirect_login_carrinho');
                }
                $this->session->set_userdata('clienteNome', $b_consultar[0]->nome);
                $this->session->set_userdata('clienteId', $b_consultar[0]->id_clientes);
                $this->session->set_userdata('clienteIdPessoa', $b_consultar[0]->id_pessoas);
                $this->session->set_userdata('clienteEmail', $b_consultar[0]->email);
            }
        }
        echo json_encode($v_dados);
    }

    function encerrar() {
        $this->session->set_userdata('clienteNome', '');
        $this->session->set_userdata('clienteId', '');
        $this->session->set_userdata('clienteIdPessoa', '');
        $this->session->set_userdata('clienteEmail', '');

        $this->session->unset_userdata('clienteNome');
        $this->session->unset_userdata('clienteId');
        $this->session->unset_userdata('clienteIdPessoa');
        $this->session->unset_userdata('clienteEmail');
        redirect(url_site());
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
        $v_dados['id_clientes'] = '';
        $v_dados['email'] = '';
        $v_dados['senha'] = '';
        $v_dados['status'] = '';
        $this->template->set_conteudo_titulo('Novo Cliente');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/login/frm_cad_clientes_view', $v_dados, true));
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
        $this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email');
        $this->form_validation->set_rules('email_moip', 'E-mail Moip', 'required|trim|valid_email');
        $this->form_validation->set_rules('senha', 'Senha', 'required|trim');

        $v_dados = array();

        if ($this->form_validation->run() === FALSE) {
            $v_dados['cod'] = 111;
            $v_dados['msg'] = $this->form_validation->msg_erros_campos_json();
            $v_dados['campos'] = $this->form_validation->erros_campos_json();
        } else {
            $params = array();
            $params['SET']['nome'] = $this->input->post('nome');
            $params['SET']['tipo_pessoa'] = $this->input->post('tipo_pessoa');
            $params['SET']['endereco'] = $this->input->post('endereco');
            $params['SET']['numero'] = $this->input->post('numero');
            $params['SET']['complemento'] = $this->input->post('complemento');
            $params['SET']['bairro'] = $this->input->post('bairro');
            $params['SET']['cidade'] = $this->input->post('cidade');
            $params['SET']['estado'] = $this->input->post('estado');
            $params['SET']['cep'] = limpaString(array('entrada' => $this->input->post('cep')));
            $params['SET']['inscricao'] = limpaString(array('entrada' => $this->input->post('inscricao')));
            $params['SET']['identidade'] = $this->input->post('identidade');

            $params2 = array();
            $params2['AND']['email'] = trim($this->input->post('email'));
            $b_consultar = $this->clientes_model->consultar($params2);

            if ($b_consultar == null) {
                $params2 = array();
                $params2['AND']['inscricao'] = limpaString(array('entrada' => $this->input->post('inscricao')));
                $b_consultar = $this->pessoas_model->consultar($params2);
                if ($b_consultar == null) {
                    $params['SET']['data_cadastro'] = date('Y-m-d H:i:s');
                    $v_dados['id_pessoas'] = $this->pessoas_model->cadastrar($params);
                    $params = array();
                    $params['SET']['id_pessoas'] = $v_dados['id_pessoas'];
                    $params['SET']['email'] = $this->input->post('email');
                    $params['SET']['email_moip'] = $this->input->post('email_moip');
                    $params['SET']['senha'] = $this->input->post('senha');
                    $params['SET']['status'] = 1;
                    $this->clientes_model->cadastrar($params);
                    $v_dados['msg'] = 'Cliente cadastrado com sucesso.';
                    $v_dados['cod'] = 999;
                    if (!$this->session->userdata('redirect_login_carrinho')) {
                        $v_dados['link'] = url_site();
                    } else {
                        $v_dados['link'] = $this->session->userdata('redirect_login_carrinho');
                    }
                } else {
                    if ($this->input->post('tipo_pessoa') == 'F') {
                        $v_dados['msg'] = 'CPF informado já exite no sistema.';
                    } else {
                        $v_dados['msg'] = 'CNPJ informado já exite no sistema.';
                    }
                    $v_dados['cod'] = 222;
                }
            } else {
                $v_dados['msg'] = 'E-mail informado já exite no sistema.';
                $v_dados['cod'] = 222;
            }
        }
        echo json_encode($v_dados);
    }

}

?>
