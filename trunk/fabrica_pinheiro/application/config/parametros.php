<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//$config['dbFabricaPinheiro'] = 'fabrica_pinheiro_db';
$config['dbFabricaPinheiro'] = 'pinheiro_fabricadb';
$config['tblCategorias'] = 'categorias_tbl';
$config['tblClientes'] = 'clientes_tbl';
$config['tblPedidos'] = 'pedidos_tbl';
$config['tblPedidoItens'] = 'pedidos_itens_tbl';
$config['tblPessoas'] = 'pessoas_tbl';
$config['tblProdutosFotos'] = 'produtos_fotos_tbl';
$config['tblProdutos'] = 'produtos_tbl';
$config['tblUsuarios'] = 'usuarios_tbl';

$config['tblBanners'] = 'banners_tbl';
$config['tblBannersTipos'] = 'banners_tipos_tbl';
$config['tblFormaPagamentos'] = 'forma_pagamentos_tbl';


$config['tblBlogs'] = 'blogs';
$config['tblBlogsCategorias'] = 'blogs_categorias';
$config['tblBlogsCategoriasHasBlogs'] = 'blogs_categorias_has_blogs';
$config['tblBlogsTags'] = 'blogs_tags';
$config['tblBlogsTagsHasBlogs'] = 'blogs_tags_has_blogs';
$config['tblBlogsImagens'] = 'blogs_imagens';

// config moip
$config['moipKey'] = 'WLWARDZBQRUEJTR1GNSA60M7NRHTNQR3N6MYXFET';
$config['moipToken'] = 'BMS4YZKZUHMJMMDGATAE3MPX6ABHARNH';
$config['moipId'] = 'fabrica_pinheiro_moip';
$config['moipEnvironment'] = 'sandbox';
?>