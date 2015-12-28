<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of produtos_fotos
 *
 * @author lucas
 */
class Produtos_fotos extends Admin_controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->helper('number');
        $this->load->helper('imagem');
        $this->load->model('produtos_fotos_model');
    }

    function gravar() {
        $tamanho_permitido = (_return_bytes(ini_get('upload_max_filesize')));
        $config = array();
        $config['upload_path'] = DIRETORIO_FOTOS;
        $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|jpe';
        $config['max_size'] = $tamanho_permitido;
        $config['overwrite'] = TRUE;
        $this->load->library('upload', $config);
        $v_dados = array();
        if (!$this->upload->do_upload("adicionar_arquivo")) {
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
            $config['master_dim'] = 'auto';
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
            $v_dados['cod'] = 999;
        }
        echo json_encode($v_dados);
    }

    function gravar_fotos() {
        $v_dados = array();
        $v_dados['novo_fotos'] = array();
        $id_produtos = $this->input->post('id_produtos');
        $fotos = $this->input->post('fotos');
        if (count($fotos) > 0) {
            foreach ($fotos as $k => $v) {
                if (trim($v['id_foto']) == '') {
                    $arquivo = DIRETORIO_FOTOS . $v['title'];
                    if (file_exists($arquivo)) {
                        $dados = propriedades_arquivos($arquivo);
                        $ler_arquivo = base64_encode(imagem_db($arquivo));
                        //pre($ler_arquivo);
                        $params = array();
                        $params['SET']['nome'] = $v['title'];
                        $params['SET']['largura'] = $dados['largura'];
                        $params['SET']['altura'] = $dados['altura'];
                        $params['SET']['extensao'] = $dados['mime'];
                        $params['SET']['id_produtos'] = $id_produtos;
                        $params['SET']['foto'] = $ler_arquivo;
                        //$id = 0;
                        $id = $this->produtos_fotos_model->cadastrar($params);
                        $v_dados['novo_fotos'][$id]['id'] = $id;
                        $v_dados['novo_fotos'][$id]['title'] = $v['title'];
                        //unlink($arquivo);
                    }
                }
            }
        }
        $v_dados['cod'] = 999;
        $v_dados['msg'] = 'Fotos anexadas com sucesso.';
        echo json_encode($v_dados);
    }

    function remover_foto($id_foto) {
        $params = array();
        $params['AND']['id_produtos_fotos'] = $id_foto;
        $b_excluir = $this->produtos_fotos_model->excluir($params);
        $v_dados = array();
        if ($b_excluir == null) {
            $v_dados['cod'] = 111;
            $v_dados['msg'] = 'Não foi possivel excluir a foto.';
        } else {
            $v_dados['cod'] = 999;
            $v_dados['msg'] = 'Foto excluida com sucesso.';
        }
        echo json_encode($v_dados);
    }

}

?>