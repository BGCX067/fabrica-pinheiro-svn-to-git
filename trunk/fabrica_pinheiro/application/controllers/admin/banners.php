<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of banners 
 *
 * @author Lucas Pinheiro
 */
class Banners extends Admin_controller {

    //id_banners, descricao, link, path, data_cadastro, data_exclusao, id_banners_tipos, id_usuarios

    function __construct() {
        parent::__construct();
        $this->template->set_js('jquery.flash.js');
        $this->template->set_js('jquery_upload_arquivos.js');
        $this->template->set_js('tiny_mce/jquery.tinymce.js');
        $this->template->set_js('banners.js');
        $this->load->model('banners_tipos_model');
        $this->load->model('banners_model');
        $this->load->helper('combos');
        $this->load->helper('number');
        $this->load->helper('imagem');
    }

    function index() {
        $this->template->display('Selecione uma opção no menu.');
    }

    function cadastrar() {
        $v_dados = array();
        $v_dados['id_banners'] = '';
        $v_dados['descricao'] = '';
        $v_dados['link'] = '';
        $v_dados['path'] = '';
        $v_dados['data_cadastro'] = '';
        $v_dados['data_exclusao'] = '';
        $v_dados['id_banners_tipos'] = combo_tipos_banners();
        $v_dados['id_usuarios'] = '';
        $v_dados['banner'] = '';
        $this->template->set_conteudo_titulo('Cadastrar Banners');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/banners/frm_cad_banners_view', $v_dados, true));
    }

    function alterar() {
        $params = array();
        $params['AND']['id_banners'] = $this->uri->segment(4);
        $b_consultar = $this->banners_model->consultar($params);
        $b_consultar = $b_consultar[0];
        $v_dados = array();

        $v_dados['id_banners'] = $b_consultar->id_banners;
        $v_dados['descricao'] = $b_consultar->descricao;
        $v_dados['link'] = $b_consultar->link;
        $v_dados['path'] = $b_consultar->path;
        $v_dados['data_cadastro'] = $b_consultar->data_cadastro;
        $v_dados['data_exclusao'] = $b_consultar->data_exclusao;
        $v_dados['id_banners_tipos'] = combo_tipos_banners($b_consultar->id_banners_tipos);
        $v_dados['id_usuarios'] = $b_consultar->id_usuarios;
        $v_dados['banner'] = '<img src="' . base_url() . 'banners/' . $b_consultar->path . '" />';

        $this->template->set_conteudo_titulo('Alterar Banners');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/banners/frm_cad_banners_view', $v_dados, true));
    }

    function consultar() {
        $v_dados = array();
        $v_dados['base_url'] = base_url();
        $v_dados['descricao'] = '';
        $v_dados['link'] = '';
        $dados = (Object) array();
        $dados->descricao = NULL;
        $dados->link = NULL;
        if ($this->uri->segment(4, NULL) != NULL) {
            $dados = json_url_base64_decode($this->uri->segment(4, NULL));
            $v_dados['descricao'] = $dados->descricao;
            $v_dados['link'] = $dados->link;
        }
        $v_dados['conteudo'] = $this->_consultar($dados);
        $this->template->set_conteudo_titulo('Consultar Tipos de Banners');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/banners/frm_con_banners_view', $v_dados, true));
    }

    function consulta() {
        $v_dados = array();
        $v_dados['descricao'] = $this->input->post('descricao');
        $v_dados['link'] = $this->input->post('link');

        redirect(url_admin() . 'banners/consultar/' . json_url_base64_encode($v_dados));
    }

    function _consultar($dados) {
        $params = array();

        if ($dados->descricao != NULL) {
            $params['LIKE']['bn.descricao'] = $dados->descricao;
        }

        if ($dados->link != NULL) {
            $params['LIKE']['bn.link'] = $dados->link;
        }

        $params['CAMPOS'] = 'bn.*, bnt.nome as bnt_nome';

        $b_consultar_total = $this->banners_model->consultar_total($params);

        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblBannersTipos') . ' as bnt',
            'AND' => 'bn.id_banners_tipos = bnt.id_banners_tipos',
            'TIPO' => 'LEFT',
        );

        $params['LIMIT']['inicio'] = $this->uri->segment(5, NULL);
        $params['LIMIT']['fim'] = $this->total_registro_por_pagina;

        $b_consultar = $this->banners_model->consultar($params);

        $v_dados = array();
        $v_dados['banners'] = array();
        $v_dados['paginacao'] = '';

        if ($b_consultar != NULL) {
            foreach ($b_consultar as $k => $v) {
                $v_dados['banners'][$k]['id_banners'] = $v->id_banners;
                $v_dados['banners'][$k]['descricao'] = $v->descricao;
                $v_dados['banners'][$k]['link'] = $v->link;
                $v_dados['banners'][$k]['path'] = $v->path;
                $v_dados['banners'][$k]['data_cadastro'] = formatarData($v->data_cadastro, array('formato' => 'd/m/Y H:i:s'));
                $v_dados['banners'][$k]['data_exclusao'] = ($v->data_exclusao != null ? formatarData($v->data_exclusao, array('formato' => 'd/m/Y H:i:s')) : "");
                $v_dados['banners'][$k]['id_banners_tipos'] = $v->bnt_nome;
                $v_dados['banners'][$k]['id_usuarios'] = $v->id_usuarios;
                $v_dados['banners'][$k]['acao'] = anchor(url_admin() . 'banners/alterar/' . $v->id_banners, 'Alterar');
            }
            $config = array();
            $config['base_url'] = url_admin() . "banners/consultar/" . json_url_base64_encode($dados);
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

        return $this->parser->parse($this->template->get_diretorio() . '/banners/lst_con_banners_view', $v_dados, true);
    }

    function gravar() {
        $this->form_validation->set_rules('descricao', 'Descrição', 'required|trim');
        $this->form_validation->set_rules('link', 'Link', 'required|trim|prep_url');
        $this->form_validation->set_rules('path', 'Path', 'required|trim');
        $this->form_validation->set_rules('id_banners_tipos', 'Tipo Banners', 'required|trim');

        $v_dados = array();

        if ($this->form_validation->run() === FALSE) {
            $v_dados['cod'] = 111;
            $v_dados['msg'] = $this->form_validation->msg_erros_campos_json();
            $v_dados['campos'] = $this->form_validation->erros_campos_json();
        } else {
            $params = array();
            $params['SET']['descricao'] = $this->input->post('descricao');
            $params['SET']['link'] = prep_url($this->input->post('link'));
            $params['SET']['path'] = $this->input->post('path');
            $params['SET']['data_cadastro'] = date('Y-m-d H:i:s');
            $params['SET']['id_banners_tipos'] = $this->input->post('id_banners_tipos');
            $params['SET']['id_usuarios'] = $this->session->userdata('idUsuario');

            if ($this->input->post('id_banners') == "") {
                $v_dados['id_banners'] = $this->banners_model->cadastrar($params);
                $v_dados['msg'] = 'Banner cadastrado com sucesso.';
            } else {
                $params['AND']['id_banners'] = $this->input->post('id_banners');
                $v_dados['id_banners'] = $this->input->post('id_banners');
                $this->banners_model->alterar($params);
                $v_dados['msg'] = 'Banner alterado com sucesso.';
            }
            $v_dados['cod'] = 999;
        }
        echo json_encode($v_dados);
    }

    function upload_banner() {

        $params = array();
        $params['AND']['id_banners_tipos'] = $this->input->post('id_banners_tipos');
        $b_consultar = $this->banners_tipos_model->consultar($params);
        $v_dados = array();

        if ($b_consultar != null) {
            $b_consultar = $b_consultar[0];

            $tamanho_permitido = (_return_bytes(ini_get('upload_max_filesize')));
            $config = array();
            $config['upload_path'] = DIRETORIO_BANNERS;
            $config['allowed_types'] = $b_consultar->extensao;
            $config['max_size'] = $tamanho_permitido;
            $config['overwrite'] = TRUE;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload("adicionar_arquivo")) {
                $v_dados['erros'] = $this->upload->json_display_errors();
                $v_dados = array_merge($v_dados, array('cod' => '111'));
            } else {
                $dados_arquivo = array();
                $v_dados = $this->upload->data();
                if (!file_exists($v_dados['full_path'])) {
                    $v_dados['er'] = "arquivo não existe.";
                }

                $tipo_img = explode("/", $v_dados['file_type']);
                if ($tipo_img[0] == 'image') {

                    if (strtoupper($tipo_img[1]) != 'GIF') {
                        $config = array();
                        $config['new_image'] = $v_dados['file_path'] . $v_dados['raw_name'] . '.jpg';

                        $config['source_image'] = $v_dados['full_path'];
                        $config['create_thumb'] = FALSE;
                        $config['master_dim'] = 'auto';
                        $config['maintain_ratio'] = TRUE;
                        $config['width'] = $v_dados['image_width'];
                        $config['height'] = $v_dados['image_height'];
                        $config['quality'] = '70%';
                        $this->load->library('image_lib', $config);

                        if (!$this->image_lib->resize()) {
                            $v_dados["erros"] = $this->image_lib->display_errors();
                        }
                        if ($v_dados['full_path'] !== $config['new_image']) {
                            unlink($v_dados['full_path']);
                            $v_dados['full_path'] = $config['new_image'];
                        }
                        $dados_arquivo = propriedades_arquivos($config['new_image']);
                    } else {
                        $dados_arquivo = propriedades_arquivos($v_dados['full_path']);
                    }
                } else {
                    $dados_arquivo = propriedades_arquivos($v_dados['full_path']);
                }

                if ($dados_arquivo['localizacao'] == true) {
                    $v_dados = array();
                    foreach ($dados_arquivo as $k => $v) {
                        $v_dados[$k] = $v;
                    }
                }
                $v_dados['cod'] = 999;
            }
        } else {
            $v_dados['erros']['msg'] = "Não exite este tipo de banner.";
            $v_dados['cod'] = 111;
        }
        echo json_encode($v_dados);
    }

}

?>