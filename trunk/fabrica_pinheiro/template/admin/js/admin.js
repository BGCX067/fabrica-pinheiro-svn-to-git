$(window).load(function(){

    $(".geral .menu li").hover( function () {
        $(this).find("ul").css({
            'display':'block'
        });
    }, function () {
        $(this).find("ul").css({
            'display':'none'
        });
    });

    if($('.editor').html() != null){
        $('.editor').redactor({ 	
            imageUpload: url_admin+'blogs_imagem/img',
            //fileUpload: url_admin+'blogs_imagem/file',
            linkFileUpload: url_admin+'blogs_imagem/link',
            imageGetJson: url_admin+'blogs_imagem/lista'
        });
    }

    $('.tabela a').button();
    
    $('a.excluir').click(function(a){
        a.preventDefault();
        var id = $(this).attr('id');
        var situacao = $(this).attr('situacao');
        var urls = $(this).attr('url');
        $( "#dialog:ui-dialog" ).dialog( "destroy" );
        var obj = this;
        if(situacao == 'E'){
            $( "#dialog-modal p" ).html("Deseja excluir este registro?");
        } else {
            $( "#dialog-modal p" ).html("Deseja restaurar este registro?");
        }
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
                    $.ajax({
                        url: url_admin+urls,
                        dataType: 'json',
                        data: {
                            'id' : id,
                            'situacao' : situacao
                        },
                        type : 'POST',
                        beforeSend: function() {
                            $.msg({
                                cs:'sucesso',
                                desc:'Aguarde... Verificando dados.',
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
                                $(obj).closest('tr').find('td').eq(8).html(b.data);
                                if(situacao == 'E'){
                                    $(obj).attr('situacao','R');
                                    $(obj).html('Restaurar');
                                } else {
                                    $(obj).attr('situacao','E');
                                    $(obj).html('Excluir');
                                }
                            } else {
                                $.msg({
                                    cs:'erro',
                                    desc: b.msg,
                                    icon:'ui-icon-alert'
                                });   
                            }
                        }
                    });
                },
                "Não": function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    });
});