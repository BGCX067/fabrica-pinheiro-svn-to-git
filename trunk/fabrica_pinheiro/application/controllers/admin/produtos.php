<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of produtos
 *
 * @author Lucas Pinheiro
 */
class Produtos extends Admin_controller {

    //put your code here
    function __construct() {
        parent::__construct();
        $this->template->set_js('jquery_upload_arquivos.js');
        $this->template->set_js('produtos.js');
        $this->load->helper('imagem');
        $this->load->helper('file');
        $this->load->model('produtos_model');
        $this->load->model('produtos_fotos_model');
    }

    function index() {
        $this->template->display('Selecione uma opção no menu.');
    }

    function cadastrar() {
        $v_dados = array();
        $v_dados['id_produtos'] = '';
        $v_dados['nome'] = '';
        $v_dados['quantidade'] = '';
        $v_dados['valor'] = '';
        $v_dados['descricao'] = '';
        $v_dados['data_cadastro'] = date('d/m/Y');
        $v_dados['exibir'] = combo_exibir();
        $v_dados['id_usuarios'] = '';
        $v_dados['id_categorias'] = combo_categorias();
        $v_dados['fotos'] = array();
        $this->template->set_conteudo_titulo('Cadastrar Produto');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/produtos/frm_cad_produtos_view', $v_dados, true));
    }

    function alterar() {
        $params = array();
        $params['AND']['id_produtos'] = $this->uri->segment(4);
        $b_consultar = $this->produtos_model->consultar($params);
        $b_consultar = $b_consultar[0];
        $v_dados = array();
        $v_dados['id_produtos'] = $b_consultar->id_produtos;
        $v_dados['nome'] = $b_consultar->nome;
        $v_dados['quantidade'] = $b_consultar->quantidade;
        $v_dados['valor'] = number_format($b_consultar->valor, 2, ',', '.');
        $v_dados['descricao'] = $b_consultar->descricao;
        $v_dados['data_cadastro'] = formatarData($b_consultar->data_cadastro, array('formato' => 'd/m/Y'));
        $v_dados['exibir'] = combo_exibir($b_consultar->exibir);
        $v_dados['id_usuarios'] = $b_consultar->id_usuarios;
        $v_dados['id_categorias'] = combo_categorias($b_consultar->id_categorias);
        $v_dados['fotos'] = $this->_lista_fotos($b_consultar->id_produtos);
        $v_dados['url_admin'] = url_admin();
        $this->template->set_conteudo_titulo('Alterar Produtos');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/produtos/frm_cad_produtos_view', $v_dados, true));
    }

    function consultar() {
        $v_dados = array();
        $v_dados['base_url'] = base_url();
        $v_dados['nome'] = '';
        $v_dados['descricao'] = '';
        $v_dados['id_categorias'] = combo_categorias();
        $dados = (Object) array();
        $dados->nome = NULL;
        $dados->descricao = NULL;
        $dados->id_categorias = NULL;
        if ($this->uri->segment(4, NULL) != NULL) {
            $dados = json_url_base64_decode($this->uri->segment(4, NULL));
            $v_dados['nome'] = $dados->nome;
            $v_dados['descricao'] = $dados->descricao;
            $v_dados['id_categorias'] = combo_categorias($dados->id_categorias);
        }
        $v_dados['conteudo'] = $this->_consultar($dados);
        $this->template->set_conteudo_titulo('Consultar Produtos');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/produtos/frm_con_produtos_view', $v_dados, true));
    }

    function consulta() {
        $v_dados = array();
        $v_dados['nome'] = $this->input->post('nome');
        $v_dados['descricao'] = $this->input->post('descricao');
        $v_dados['id_categorias'] = $this->input->post('id_categorias');

        redirect(url_admin() . 'produtos/consultar/' . json_url_base64_encode($v_dados));
    }

    function _consultar($dados) {
        $params = array();

        if ($dados->nome != NULL) {
            $params['OR_LIKE']['pr.nome'] = $dados->nome;
        }
        if ($dados->descricao != NULL) {
            $params['OR_LIKE']['pr.descricao'] = $dados->descricao;
        }
        if ($dados->id_categorias != NULL) {
            $params['AND']['pr.id_categorias'] = $dados->id_categorias;
        }

        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblCategorias') . ' as ct',
            'AND' => 'pr.id_categorias = ct.id_categorias',
            'TIPO' => 'LEFT',
        );

        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblUsuarios') . ' as us',
            'AND' => 'pr.id_usuarios = us.id_usuarios',
            'TIPO' => 'LEFT',
        );

        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblPessoas') . ' as pe',
            'AND' => 'pe.id_pessoas = us.id_pessoas',
            'TIPO' => 'LEFT',
        );

        $params['CAMPOS'] = 'pr.*, ct.descricao as ct_descricao, pe.nome as pe_nome';
        $b_consultar_total = $this->produtos_model->consultar_total($params);

        $params['LIMIT']['inicio'] = $this->uri->segment(5, NULL);
        $params['LIMIT']['fim'] = $this->total_registro_por_pagina;
        $b_consultar = $this->produtos_model->consultar($params);

        $v_dados = array();
        $v_dados['produtos'] = array();
        $v_dados['paginacao'] = '';

        if ($b_consultar != NULL) {
            foreach ($b_consultar as $k => $v) {
                $v_dados['produtos'][$k]['id_produtos'] = $v->id_produtos;
                $v_dados['produtos'][$k]['nome'] = $v->nome;
                $v_dados['produtos'][$k]['quantidade'] = $v->quantidade;
                $v_dados['produtos'][$k]['valor'] = number_format($v->valor, 2, ',', '.');
                $v_dados['produtos'][$k]['descricao'] = $v->descricao;
                $v_dados['produtos'][$k]['data_cadastro'] = formatarData($v->data_cadastro, array('formato' => 'd/m/Y'));
                $v_dados['produtos'][$k]['data_exclusao'] = ($v->data_exclusao != null ? formatarData($v->data_exclusao, array('formato' => 'd/m/Y')) : '');
                $v_dados['produtos'][$k]['exibir'] = ($v->exibir == 'S' ? 'Sim' : 'Não');
                $v_dados['produtos'][$k]['id_usuarios'] = $v->pe_nome;
                $v_dados['produtos'][$k]['id_categorias'] = $v->id_categorias;
                $v_dados['produtos'][$k]['ct_descricao'] = $v->ct_descricao;
                $v_dados['produtos'][$k]['acao'] = anchor(url_admin() . 'produtos/alterar/' . $v->id_produtos, 'Alterar');
                if ($v->data_exclusao != null) {
                    $v_dados['produtos'][$k]['acao'] .= '<a href="#" class="excluir" id="' . $v->id_produtos . '" url="produtos/excluir" situacao="R">Restaurar</a> ';
                } else {
                    $v_dados['produtos'][$k]['acao'] .= '<a href="#" class="excluir" id="' . $v->id_produtos . '" url="produtos/excluir" situacao="E">Excluir</a> ';
                }
            }
            $config = array();
            $config['base_url'] = url_admin() . "produtos/consultar/" . json_url_base64_encode($dados);
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

        return $this->parser->parse($this->template->get_diretorio() . '/produtos/lst_con_produtos_view', $v_dados, true);
    }

    function gravar() {
        $this->form_validation->set_rules('nome', 'Nome', 'required|trim');
        $this->form_validation->set_rules('quantidade', 'Quantidade', 'required|trim');
        $this->form_validation->set_rules('valor', 'Valor', 'required|trim');
        $this->form_validation->set_rules('descricao', 'Descrição', 'required|trim');
        $this->form_validation->set_rules('data_cadastro', 'Data Cadastro', 'required|trim');
        $this->form_validation->set_rules('exibir', 'Exibir', 'required|trim');
        $this->form_validation->set_rules('id_categorias', 'Categoria', 'required|trim');

        $v_dados = array();

        if ($this->form_validation->run() === FALSE) {
            $v_dados['cod'] = 111;
            $v_dados['msg'] = $this->form_validation->msg_erros_campos_json();
            $v_dados['campos'] = $this->form_validation->erros_campos_json();
        } else {
            $params = array();
            $params['SET']['nome'] = $this->input->post('nome');
            $params['SET']['quantidade'] = $this->input->post('quantidade');
            $params['SET']['valor'] = formataString(array('entrada' => $this->input->post('valor'), 'formato' => 'moedaDb', 'casas' => 2));
            $params['SET']['descricao'] = $this->input->post('descricao');
            $params['SET']['data_cadastro'] = formatarData($this->input->post('data_cadastro'), array('formato' => 'Y-m-d H:i:s'));
            $params['SET']['exibir'] = $this->input->post('exibir');
            $params['SET']['id_categorias'] = $this->input->post('id_categorias');
            $params['SET']['id_usuarios'] = $this->session->userdata('idUsuario');
            if ($this->input->post('id_produtos') == "") {
                $v_dados['id_produtos'] = $this->produtos_model->cadastrar($params);
                $v_dados['msg'] = 'Produto cadastrado com sucesso.';
            } else {
                $params['AND']['id_produtos'] = $this->input->post('id_produtos');
                $v_dados['id_produtos'] = $this->input->post('id_produtos');
                $this->produtos_model->alterar($params);
                $v_dados['msg'] = 'Produto alterado com sucesso.';
            }
            $v_dados['cod'] = 999;
        }
        echo json_encode($v_dados);
    }

    function _lista_fotos($id_produtos) {
        $v_dados = array();
        $params = array();
        $params['AND']['id_produtos'] = $id_produtos;
        $b_consultar = $this->produtos_fotos_model->consultar($params);
        if ($b_consultar != null) {
            foreach ($b_consultar as $k => $v) {
                $extension = explode('/', get_mime_by_extension($v->nome));
                $v_dados[$k]['id_produtos_fotos'] = $v->id_produtos_fotos;
                $v_dados[$k]['nome_foto'] = $v->nome;
                if ($v->largura < 125) {
                    $v_dados[$k]['largura'] = $v->largura;
                } else {
                    $v_dados[$k]['largura'] = 125;
                }
                $v_dados[$k]['altura'] = $v->altura;
                $v_dados[$k]['extensao'] = $v->extensao;
                $v_dados[$k]['id_produtos'] = $v->id_produtos;
                $v_dados[$k]['sub'] = $extension[1];
            }
        }
        return $v_dados;
    }

    function ver_foto($id_produtos_fotos) {
        $this->load->helper('imagem');
        ver_foto_db($id_produtos_fotos);
    }

    function excluir() {
        $params = array();
        $params['AND']['id_produtos'] = $this->input->post('id');
        $params['SET']['data_exclusao'] = ($this->input->post('situacao') == 'E' ? date('Y-m-d H:i:s') : NULL);
        $b_alteracao = $this->produtos_model->alterar($params);
        $v_dados = array();
        if ($b_alteracao != null) {
            $v_dados['cod'] = 999;
            $v_dados['data'] = ($this->input->post('situacao') == 'E' ? date('d/m/Y') : '');
            $v_dados['msg'] = ($this->input->post('situacao') == 'E' ? 'Produto excluido com sucesso.' : 'Produto restaurado com sucesso.');
        } else {
            $v_dados['cod'] = 111;
            $v_dados['msg'] = ($this->input->post('situacao') == 'E' ? 'Não foi possível excluir o produto.' : 'Não foi possível restaurar o produto.');
        }
        echo json_encode($v_dados);
    }

}

?>