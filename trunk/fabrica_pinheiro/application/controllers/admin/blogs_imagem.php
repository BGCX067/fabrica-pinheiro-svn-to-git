<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of blogs_imagem
 *
 * @author lucas
 */
class blogs_imagem extends Admin_controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('blogs_imagens_model');
    }

    public function lista() {
        $v_dados = array();
        $b_consultar = $this->blogs_imagens_model->consultar();
        if ($b_consultar != null) {
            foreach ($b_consultar as $key => $value) {
                $v_dados[$key]['thumb'] = base_url('imagens/thumb/' . $value->url);
                $v_dados[$key]['image'] = base_url('imagens/' . $value->url);
                $v_dados[$key]['name'] = $value->nome;
            }
        }
        echo json_encode($v_dados);
    }

    public function img() {
        $u_dados = $this->_upload();
        pre($u_dados);
        if ($u_dados->cod == 999) {
            echo '<img title="' . $u_dados->client_name . '" alt="' . $u_dados->client_name . '" src="' . base_url('imagens/' . $u_dados->name) . '" />';
        }
    }

    public function file() {
        $u_dados = $this->_upload();
        if ($u_dados->cod == 999) {
            echo $u_dados->file_path . '/' . $u_dados->name;
        }
    }

    public function link() {
        $u_dados = $this->_upload();
        if ($u_dados->cod == 999) {
            echo '<a title="' . $u_dados->client_name . '" href="' . base_url('imagens/' . $u_dados->name) . '">' . $u_dados->name . '</a>';
        }
    }

    public function _upload() {
        $tamanho_permitido = (_return_bytes(ini_get('upload_max_filesize')));
        $config = array();
        $config['upload_path'] = DIRETORIO_IMAGENS;
        $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|jpe';
        $config['max_size'] = $tamanho_permitido;
        $config['overwrite'] = TRUE;
        $this->load->library('upload', $config);
        $v_dados = array();
        if (!$this->upload->do_upload("file")) {
            $v_dados['erros'] = $this->upload->json_display_errors();
            $v_dados = array_merge($v_dados, array('cod' => '111'));
        } else {
            $v_dados = $this->upload->data();
            if (!file_exists($v_dados['full_path'])) {
                $v_dados['er'] = "arquivo não existe.";
            }
            $config = array();
            $config['source_image'] = $v_dados['full_path'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $new_dimession = redimensionar_img($v_dados['image_width'], $v_dados['image_height'], 500, 500);
            $config['width'] = $new_dimession['width'];
            $config['height'] = $new_dimession['height'];
            $config['quality'] = '70%';
            $config['new_image'] = $v_dados['file_path'] . $v_dados['raw_name'] . $v_dados['file_ext'];
            $this->load->library('image_lib', $config);
            if (!$this->image_lib->resize()) {
                $v_dados["erros"] = $this->image_lib->display_errors();
            }

            $dados = propriedades_arquivos($config['new_image']);
            if ($dados['localizacao'] == true) {
                foreach ($dados as $k => $v) {
                    $v_dados[$k] = $v;
                }
            }

            $new_dimession = redimensionar_img($v_dados['image_width'], $v_dados['image_height'], 100, 100);
            $config['width'] = $new_dimession['width'];
            $config['height'] = $new_dimession['height'];
            $config['new_image'] = $v_dados['file_path'] . 'thumb/' . $v_dados['raw_name'] . $v_dados['file_ext'];
            $this->image_lib->initialize($config);
            $this->image_lib->resize();

            $v_dados['cod'] = 999;
            $params = array();
            //id_blogs_imagens, nome, url
            $params['SET']['nome'] = $v_dados['client_name'];
            $params['SET']['url'] = $v_dados['name'];
            $this->blogs_imagens_model->cadastrar($params);
        }
        return json_decode(json_encode($v_dados));
    }

}