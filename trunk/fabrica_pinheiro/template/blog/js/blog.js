$(window).load(function(){
    $('.geral > .geral_conteudo > .conteudo > .conteudo_content > .lista_produtos ul li').mouseover(function(){
        $(this).addClass('produto_selecionado');
    }).mouseout(function(){
        $(this).removeClass('produto_selecionado');
    });
    
    $('a.comprar').bt({
        icon : 'ui-icon-circle-check',
        text : 'Finalizar'
    });
    $('a.login').bt({
        icon : 'ui-icon-key',
        text : 'Logar'
    });
    $('a.encerrar').bt({
        icon : 'ui-icon-close',
        text : 'Sair'
    });
    $('a.cancelar').bt({
        icon : 'ui-icon-circle-close',
        text : 'Cancelar'
    });
    $('a.detalhar').bt({
        icon : 'ui-icon-note',
        text : 'Detalhar'
    });
    $('a.remover').bt({
        icon : 'ui-icon-close',
        text : 'Remover'
    });
    $('a.atualizar').bt({
        icon : 'ui-icon-refresh',
        text : 'Atualizar'
    });
    
    $('a.ver_carrinho').bt({
        icon : 'ui-icon-cart',
        text : 'Ver carrinho'
    });
    
    $('a.adicionar, .bt_adicionar').bt({
        icon : 'ui-icon-cart',
        text : 'Comprar'
    });
    
    if($('.qtd').html() != null){
        $('.qtd').mask('?9999999999',{
            placeholder:""
        });
        $('.qtd').attr('title','Informe o número.');
        $('.qtd').attr('size',5);
        $('.qtd').attr('maxlength',5);
        
        $('.bt_adicionar').click(function(){
            var qtd = $('.qtd').val();
            $.msg({
                rv:true
            });
            if(qtd < 1){
                $.msg({
                    cs:'erro',
                    desc:'Informe uma quantidade válida.',
                    icon:'ui-icon-alert'
                });
            } else {
                adicionar_carrinho(url_segmento(4),qtd,'adicionar');
            }
        });
    
    }
    
    $('a.ver_carrinho').click(function(e){
        e.preventDefault();
        location.href = url_site+'carrinho/listar/';
    });
    
    $('a.login').click(function(e){
        e.preventDefault();
        location.href = url_site+'login/index/';
    });
    
    $('a.encerrar').click(function(e){
        e.preventDefault();
        location.href = url_site+'login/encerrar/';
    });
    
    $('a.detalhar').click(function(e){
        e.preventDefault();
        location.href = $(this).attr('link');
    });
    
    $('a.adicionar').click(function(e){
        e.preventDefault();
        adicionar_carrinho($(this).attr('link'),1,'adicionar');
    });
    
    $('a.atualizar').click(function(e){
        e.preventDefault();
        var id_produto = $(this).closest('tr').attr('id_produtos');
        var qtd = parseInt($(this).closest('tr').find(':input').val());
        var valor = $(this).closest('tr').find('td').eq(2).html();
        var valor_total = 0;
        valor = valor.replace('R$','');
        valor = parseFloat(number_format_db($.trim(valor)));
        if(qtd > 0){
            valor_total = 'R$ '+number_format((valor*qtd),2,',','.');
            $(this).closest('tr').find('td').eq(3).html(valor_total);
        } else {
            $(this).closest('tr').remove();
        }
        adicionar_carrinho(id_produto,qtd,'atualizar');
        calcular_linhas();
    });
    
    $('a.remover').click(function(e){
        e.preventDefault();
        var id_produto = $(this).closest('tr').attr('id_produtos');
        remover_carrinho(id_produto,this);
        calcular_linhas();
    });
    
    $('a.cancelar').click(function(e){
        cancelar_carrinho();
    });
    
    $('a.comprar').click(function(e){
        location.href = url_site+'carrinho/finalizar/'+$('#forma_pagamento').val();
    });
    
    $('.lista_img img').click(function(){
        $('.detalhes_img img').attr('src',$(this).attr('src'));
    });
    
    $('.pre_img').preview_img();
    
    
});

function adicionar_carrinho(id_produto,quantidade,link){
    $.ajax({
        url: url_site+'carrinho/'+link,
        dataType: 'json',
        data: {
            'id_produto':id_produto,
            'quantidade':quantidade
        },
        type : 'POST',
        beforeSend: function() {
            $.msg({
                cs:'sucesso',
                desc:'Aguarde... Adicionando produto no carrinho.',
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
                $('.carrinho_total').html('R$ '+b.carrinho_total);
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

function remover_carrinho(id_produto, obj){
    $.ajax({
        url: url_site+'carrinho/remover',
        dataType: 'json',
        data: {
            'id_produto':id_produto
        },
        type : 'POST',
        beforeSend: function() {
            $.msg({
                cs:'sucesso',
                desc:'Aguarde... Excluindo produto no carrinho.',
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
                $('.carrinho_total').html('R$ '+b.carrinho_total);
                $(obj).closest('tr').remove();
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

function cancelar_carrinho(){
    $.ajax({
        url: url_site+'carrinho/cancelar',
        dataType: 'json',
        type : 'POST',
        beforeSend: function() {
            $.msg({
                cs:'sucesso',
                desc:'Aguarde... Cancelando o carrinho.',
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
                location.href = url_site;
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

function calcular_linhas(){
    var valor_total = 0;
    $('.conteudo_content .tabela tbody tr').each(function(a,b){
        var valor = $(this).find('td').eq(3).html();
        valor = valor.replace('R$','');
        valor = parseFloat(number_format_db($.trim(valor)));
        valor_total += valor;
    });
    valor_total = 'R$ '+number_format(valor_total,2,',','.');
    $('.conteudo_content .tabela tfoot tr td').eq(3).html(valor_total)
}