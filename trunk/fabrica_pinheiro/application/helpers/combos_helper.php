<?php

function combo_forma_pagamento($forma = null) {
    $dados = array();
    $dados['boleto'] = 'Boleto';
    $dados['financiamento'] = 'Financiamento';
    $dados['debito'] = 'Débito';
    $dados['cartao_credito'] = 'Cartão Crédito';
    $dados['cartao_debito'] = 'Cartão Débito';
    $dados['carteira_moip'] = 'Carteira Moip';
    $option = '<option value="" selected="selected">Selecionar</option>';
    foreach ($dados as $k => $v) {
        if ($k == $forma) {
            $option .= '<option value="' . $k . '" selected="selected">' . $v . '</option>';
        } else {
            $option .= '<option value="' . $k . '">' . $v . '</option>';
        }
    }
    return $option;
}

function combo_situacao($id_forma_pagamentos = null) {
    $ci = &get_instance();
    $ci->load->model('forma_pagamentos_model');
    $b_consultar = $ci->forma_pagamentos_model->consultar();
    $option = '<option value="" selected="selected">Selecionar</option>';
    if ($b_consultar != null) {
        foreach ($b_consultar as $k => $v) {
            if ($v->id_forma_pagamentos == $id_forma_pagamentos) {
                $option .= '<option value="' . $v->id_forma_pagamentos . '" selected="selected">' . $v->descricao . '</option>';
            } else {
                $option .= '<option value="' . $v->id_forma_pagamentos . '">' . $v->descricao . '</option>';
            }
        }
    }

    return $option;
}

function combo_tipo_pessoas($id_tipo_pessoas = null) {
    $dados = array();
    $dados['F'] = 'Física';
    $dados['J'] = 'Júridica';
    $option = '<option value="" selected="selected">Selecionar</option>';
    foreach ($dados as $k => $v) {
        if ($k == $id_tipo_pessoas) {
            $option .= '<option value="' . $k . '" selected="selected">' . $v . '</option>';
        } else {
            $option .= '<option value="' . $k . '">' . $v . '</option>';
        }
    }
    return $option;
}

function combo_status($id_status = null) {
    $dados = array();
    $dados['A'] = 'Atitvo';
    $dados['I'] = 'Inativo';
    $option = '<option value="" selected="selected">Selecionar</option>';
    foreach ($dados as $k => $v) {
        if ($k == $id_status) {
            $option .= '<option value="' . $k . '" selected="selected">' . $v . '</option>';
        } else {
            $option .= '<option value="' . $k . '">' . $v . '</option>';
        }
    }
    return $option;
}

function combo_exibir($id_exibir = null) {
    $dados = array();
    $dados['S'] = 'Sim';
    $dados['N'] = 'Não';
    $option = '<option value="" selected="selected">Selecionar</option>';
    foreach ($dados as $k => $v) {
        if ($k == $id_exibir) {
            $option .= '<option value="' . $k . '" selected="selected">' . $v . '</option>';
        } else {
            $option .= '<option value="' . $k . '">' . $v . '</option>';
        }
    }
    return $option;
}

function combo_categorias($id_categorias = null) {
    $ci = &get_instance();
    $ci->load->model('categorias_model');
    $b_consultar = $ci->categorias_model->consultar();
    $option = '<option value="" selected="selected">Selecionar</option>';
    if ($b_consultar != null) {
        foreach ($b_consultar as $k => $v) {
            if ($v->id_categorias == $id_categorias) {
                $option .= '<option value="' . $v->id_categorias . '" selected="selected">' . $v->descricao . '</option>';
            } else {
                $option .= '<option value="' . $v->id_categorias . '">' . $v->descricao . '</option>';
            }
        }
    } else {
        $option .= '<option value="">Nenhuma categoria localizada</option>';
    }

    return $option;
}

function combo_blogs_categorias($id_blogs = null) {
    $ci = &get_instance();
    $ci->load->model('blogs_categorias_model');

    $params = array();
    $params['CAMPOS'] = 'blc.*, blch.id_blogs';
    $params['JOIN'][] = array(
        'TABELA' => $ci->config->item('dbFabricaPinheiro') . '.' . $ci->config->item('tblBlogsCategoriasHasBlogs') . ' as blch',
        'AND' => 'blc.id_blogs_categorias = blch.id_blogs_categorias AND blch.id_blogs ' . ($id_blogs == null ? ' IS NULL ' : ' = ' . $id_blogs),
        'TIPO' => 'LEFT',
    );
    $b_consultar = $ci->blogs_categorias_model->consultar($params);
    $option = '';
    if ($b_consultar != null) {
        foreach ($b_consultar as $v) {
            if ($v->id_blogs != NULL) {
                $option .= '<option value="' . $v->id_blogs_categorias . '" selected="selected">' . $v->nome . '</option>';
            } else {
                $option .= '<option value="' . $v->id_blogs_categorias . '">' . $v->nome . '</option>';
            }
        }
    }
    return $option;
}

function lista_tags($id_blogs) {
    $ci = &get_instance();
    $ci->load->model('blogs_tags_model');

    $params = array();
    $params['CAMPOS'] = 'blt.nome';
    $params['AND']['blth.id_blogs'] = $id_blogs;
    $params['JOIN'][] = array(
        'TABELA' => $ci->config->item('dbFabricaPinheiro') . '.' . $ci->config->item('tblBlogsTagsHasBlogs') . ' as blth',
        'AND' => 'blt.id_blogs_tags = blth.id_blogs_tags',
        'TIPO' => 'INNER',
    );
    $b_consultar = $ci->blogs_tags_model->consultar($params);
    if ($b_consultar != null) {
        $retorno = '';
        foreach ($b_consultar as $value) {
            if ($retorno != '') {
                $retorno .= ', ';
            }
            $retorno .= $value->nome;
        }
        return $retorno;
    }
    return '';
}

function combo_tipos_banners($id_tipos_banners = null) {
    $ci = &get_instance();
    $ci->load->model('banners_tipos_model');
    $b_consultar = $ci->banners_tipos_model->consultar();
    $option = '<option value="" selected="selected">Selecionar</option>';
    if ($b_consultar != null) {
        foreach ($b_consultar as $k => $v) {
            if ($v->id_banners_tipos == $id_tipos_banners) {
                $option .= '<option value="' . $v->id_banners_tipos . '" selected="selected">' . $v->nome . '</option>';
            } else {
                $option .= '<option value="' . $v->id_banners_tipos . '">' . $v->nome . '</option>';
            }
        }
    } else {
        $option .= '<option value="">Nenhum tipo de banner localizado</option>';
    }

    return $option;
}

?>