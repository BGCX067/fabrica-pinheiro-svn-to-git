$(window).load(function(){
    
    $('#frm_cad_pedidos, #frm_con_pedidos').insere_mascara();
    
    $('.bt_consultar').bt({
        text:'Consultar',
        icon:'ui-icon-search'
    });
    
    $('.bt_imprimir').bt({
        text:'Imprimir',
        icon:'ui-icon-print'
    });
   
    $('.bt_imprimir').click(function(){
        $('#div_print').print_frame({ 
            html:url_admin+'pedidos/detalhes/'+url_segmento(4)+'/S',
            title:'Imprimir Pedido'
        });
    });
    
    $('#frm_con_pedidos .bt_consultar').form_consultar();
    
    bt_novo();
    
});