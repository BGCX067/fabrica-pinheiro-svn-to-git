$(window).load(function(){
    
    $('#frm_cad_produtos').insere_mascara();
    
    if($('#frm_cad_produtos').html() != null){
        atualizar_images();   
    }
    
    $('.bt_gravar').bt({
        text:'Gravar',
        icon:'ui-icon-disk'
    });
    
    $('.bt_consultar').bt({
        text:'Consultar',
        icon:'ui-icon-search'
    });
    
    $('#frm_con_produtos .bt_consultar').form_consultar();
   
    bt_novo();
     
    $('.bt_gravar').click(function(){
        if($('#frm_cad_produtos').valida_form() == true){
            $.ajax({
                url: url_admin+'produtos/gravar',
                dataType: 'json',
                data: $('#frm_cad_produtos').serialize(),
                type : 'POST',
                beforeSend: function() {
                    $.msg({
                        cs:'sucesso',
                        desc:'Aguarde... Validando dados.',
                        icon:'ui-icon-info'
                    });
                },
                success: function(b) {
                    if(b.cod == 999){
                        $.msg({
                            cs:'sucesso',
                            desc: b.msg,
                            icon:'ui-icon-info'
                        });   
                        $('#frm_cad_produtos #id_produtos').val(b.id_produtos);
                        json_fotos();
                    } else {
                        $('#frm_cad_produtos').color_campos_form({
                            campos:b.campos,
                            msg:b.msg
                        });
                     
                    }
                }
            });
        }
    });
    
    $('#bt_fotos').upload_arquivos({
        nome_botao: 'Adicionar Fotos',
        url: url_admin+'produtos_fotos/gravar',
        debug_display: false,
        success: function(b) {
            $.msg({
                rv:true
            }); 
            if(b.cod == 999){
                var dimensoes = redimensionar_img(b.largura, b.altura, 125, 105);
                var foto = '<div class="minha_foto">';
                foto += '       <img class="pre_img" src="'+url_base+'fotos/'+b.file_name+'" height="'+dimensoes[1]+'px" width="'+dimensoes[0]+'px" title="'+b.file_name+'" id_foto="" />';
                foto += '   <div class="acao">';
                foto += '       <a class="remover">Remover</a>';
                foto += '   </div>';
                foto += '</div>';
                $('.fotos').prepend(foto);
                atualizar_images();
            } else {
                var msg = '';
                $.each(b.erros,function(y,z){
                    if(y != 'cod'){
                        if(msg != ''){
                            msg += '<br />';
                        }
                        msg += z;
                    }
                });
                $.msg({
                    cs:'erro',
                    desc: msg,
                    icon:'ui-icon-alert'
                });   
            }
        },
        error: function(a) {
            $.msg({
                cs:'erro',
                desc: a.msg,
                icon:'ui-icon-alert'
            });  
        }
    });
    
    $('.fotos .minha_foto .acao .remover').live('click',function(){
        var obj = this;
        var id_foto = $(obj).closest('.minha_foto').find('.pre_img').attr('id_foto');
        $( "#dialog:ui-dialog" ).dialog( "destroy" );
        $( "#dialog-modal p" ).html("Confirma a exclusão deste arquivo?");
        $( "#dialog-modal" ).dialog({
            height : 150,
            width : 300,
            //title: "Fábrica Pinheiro informa:",
            title: "Pinheiro Shop informa:",
            modal: true,
            resizable: false,
            buttons: {
                "Sim": function() {
                    $( this ).dialog( "close" );
                    if(!id_foto){
                        $(obj).closest('.minha_foto').remove();
                    } else {
                        $.ajax({
                            url: url_admin+'produtos_fotos/remover_foto/'+id_foto,
                            dataType: 'json',
                            type : 'GET',
                            beforeSend: function() {
                                $.msg({
                                    cs:'sucesso',
                                    desc:'Aguarde... Validando dados.',
                                    icon:'ui-icon-info'
                                });
                            },
                            success: function(b) {
                                if(b.cod == 999){
                                    $.msg({
                                        cs:'sucesso',
                                        desc: b.msg,
                                        icon:'ui-icon-info'
                                    });   
                                    $(obj).closest('.minha_foto').remove();
                                } else {
                                    $.msg({
                                        cs:'erro',
                                        desc: b.msg,
                                        icon:'ui-icon-alert'
                                    });  
                                }
                            }
                        });
                    }
                },
                "Não": function() {
                    $( this ).dialog( "close" );
                }
            }
        });
        
    });
});

$(window).resize(function() {
    atualizar_images();
    $('.geral .rodape').css({
        'botton':'0px'
    });
});

function atualizar_images(){
    $('.pre_img').preview_img();
}

function json_fotos(){
    var array_json_foto = new Array();
    $('.fotos .minha_foto .pre_img').each(function(z,y){
        array_json_foto[z] = $.parseJSON('{"ordem":"'+z+'","title":"'+$(this).attr('title')+'","id_foto":"'+$(this).attr('id_foto')+'"}');
    });
    if(array_json_foto.length > 0){
        $.ajax({
            url: url_admin+'produtos_fotos/gravar_fotos',
            dataType: 'json',
            data: {
                "id_produtos" : $('#frm_cad_produtos #id_produtos').val(),
                "fotos" : array_json_foto
            },
            type : 'POST',
            beforeSend: function() {
                $.msg({
                    cs:'sucesso',
                    desc:'Aguarde... Validando dados.',
                    icon:'ui-icon-info'
                });
            },
            success: function(b) {
                $.each(b.novo_fotos,function(a,c){
                    $('.fotos .minha_foto a[rel="preview_img_temp"]').each(function(z,y){
                        if($(this).attr('title') == c.title){
                            $(this).attr('id_foto',c.id);
                        }
                    });
                });
                $.msg({
                    cs:'sucesso',
                    desc: b.msg,
                    icon:'ui-icon-info'
                });   
            }
        });
    }
}