function corLinhasTabela(){
    $(".tabela").each(function(){
        $(this).find("tbody > tr:odd").addClass("linha_par")
    });
    $(".tabela > tbody > tr").mouseover(function(){
        $(this).addClass("linha_ativa")
    });
    $(".tabela > tbody > tr").mouseout(function(){
        $(this).removeClass("linha_ativa")
    })
}
corLinhasTabela();
function validaData(data){
    var date=data;
    var array_data=new Array;
    var ExpReg=new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
    array_data=date.split("/");
    var erro=false;
    if(date.search(ExpReg)==-1)
        erro=true;
    else if(((array_data[1]==4)||(array_data[1]==6)||(array_data[1]==9)||(array_data[1]==11))&&(array_data[0]>30))
        erro=true;
    else if(array_data[1]==2){
        if((array_data[0]>28)&&((array_data[2]%4)!=0))
            erro=true;
        if((array_data[0]>29)&&((array_data[2]%4)==0))
            erro=true;
    }
    return erro;
}
function validaHora(hora){
    var novaHora=hora;
    if((novaHora.substr(0,2)>=00&&novaHora.substr(0,2)<=23)&&(novaHora.substr(3,2)>=00&&novaHora.substr(3,2)<=59)){
        return false;
    }else{
        return true;
    }
}
function number_format_db(number){
    number = number.replace('.','');
    number = number.replace(',','.');
    return number;
}
function number_format(number,decimals,dec_point,thousands_sep){
    var n=number,prec=decimals;
    n=!isFinite(+n)?0:+n;
    prec=!isFinite(+prec)?0:Math.abs(prec);
    var sep=(typeof thousands_sep=="undefined")?',':thousands_sep;
    var dec=(typeof dec_point=="undefined")?'.':dec_point;
    var s=(prec>0)?n.toFixed(prec):Math.round(n).toFixed(prec);
    var abs=Math.abs(n).toFixed(prec);
    var _,i;
    if(abs>=1000){
        _=abs.split(/\D/);
        i=_[0].length%3||3;
        _[0]=s.slice(0,i+(n<0))+
        _[0].slice(i).replace(/(\d{3})/g,sep+'$1');
        s=_.join(dec);
    }else{
        s=s.replace('.',dec);
    }
    return s;
    
}

(function($){
    $.fn.extend({
        bt:function(parametros){
            var defaults={
                icon:'',
                fontSize:'1em',
                height:'',
                width:'',
                text:'Nome do botão',
                title:''
            }
            var options=$.extend(true,defaults,parametros);

            $(this).button({
                icons: {
                    primary: options.icon
                },
                label: options.text
            }).css({
                fontSize:options.fontSize
            });

            if(options.height != ''){
                $(this).css({
                    height : options.height
                });
            }
            if(options.width != ''){
                $(this).css({
                    width : options.width
                });
            }
            if (options.title != '') {
                $(this).attr('title', options.title);
            }
            return false;
        }
    });
})(jQuery);

(function($){
    $.fn.extend({
        subtitulo : function(msg){
            if(!msg){
                msg = "";
            }
            $(this).after('<div class="exemplo_div">'+msg+'</div>');
        }
    });
})(jQuery);

$.msg = function(parametros){
    var defaults = {
        'rv':false,
        'cs':'',
        'desc':'',
        'icon':''
    }
    var options = $.extend(true,defaults,parametros);
    $('#msg_sistema').removeClass();
    $('#msg_sistema .ui-corner-all').removeClass('ui-state-error');
    $('#msg_sistema .ui-corner-all').removeClass('ui-state-highlight');
    if(options.rv == false){
        $('#msg_sistema').addClass('ui-widget');
        switch (options.cs) {
            case 'erro':
                $('#msg_sistema .ui-corner-all').addClass('ui-state-error');
                break;
            case 'sucesso':
                $('#msg_sistema .ui-corner-all').addClass('ui-state-highlight');
                break;
        }
        $('#msg_sistema .icone').addClass(options.icon);
        $('#msg_sistema .desc_msg').html(options.desc);
        $('#msg_sistema').show();
        $("html, body").animate({
            scrollTop:0
        },"slow");
    } else {
        $('#msg_sistema').hide();
    }
    return false;
};

(function($){
    $.fn.extend({
        valida_form:function(parametros){
            var defaults={
                classErro : 'textoErro',
                classSucesso : 'textoSucesso',
                classAviso : 'textoAviso',
                divErro : ''
            }
            var options=$.extend(true,defaults,parametros);
            var erro = 0;
            
            $.each($(this).find(":input").not(':button'),function(){
                var obj = this
                $(obj).removeClass(options.classSucesso).removeClass(options.classErro).removeClass(options.classAviso);
                $(obj).closest('.redactor_box').css('border-color', '');

                if($(obj).hasClass('obrigatorio') && $.trim($(obj).val()) == '' ) {
                    erro++;
                    $(obj).addClass(options.classErro);
                    
                    if($(obj).hasClass('editor')) {
                        erro++;
                        $(obj).closest('.redactor_box').css('border-color', 'red');
                    }
                } else if($.trim($(obj).val()) != '' && $(obj).hasClass('email')){
                    if( valida_email($.trim($(obj).val())) == true ){
                        erro++;
                        $(obj).addClass(options.classErro);
                    } else {
                        $(obj).addClass(options.classSucesso);
                    }
                } else if($.trim($(obj).val()) != '' && $(obj).hasClass('data')){
                    if( validaData($.trim($(obj).val())) == true ){
                        erro++;
                        $(obj).addClass(options.classErro);
                    } else {
                        $(obj).addClass(options.classSucesso);
                    }
                } else if($.trim($(obj).val()) != '' && $(obj).hasClass('hora')){
                    if( validaHora($.trim($(obj).val())) == true ){
                        erro++;
                        $(obj).addClass(options.classErro);
                    } else {
                        $(obj).addClass(options.classSucesso);
                    }
                } else if($.trim($(obj).val()) != '' && $(obj).hasClass('cpf')) {
                    if( validaCPF($.trim($(obj).val())) == true ){
                        erro++;
                        $(obj).addClass(options.classErro);
                    } else {
                        $(obj).addClass(options.classSucesso);
                    }
                } else if($.trim($(obj).val()) != '' && $(obj).hasClass('cnpj')) {
                    if( validaCNPJ($.trim($(obj).val())) == true ){
                        erro++;
                        $(obj).addClass(options.classErro);
                    } else {
                        $(obj).addClass(options.classSucesso);
                    }
                } else {
                    $(obj).addClass(options.classSucesso);
                }
            });

            if(erro > 0){
                $.msg({
                    cs:'erro',
                    desc:'Campos destacados em vermelho são de preenchimento obrigatorio. Verifique a ocorrência de erros.',
                    icon:'ui-icon-alert'
                });
                return false;
            } else {
                $.msg({
                    rv:true
                });
                return true;
            }

        }
    });
})(jQuery);

(function($){
    $.fn.extend({
        clear_form:function(){
            var obj;
            if($(this).attr('id') == ''){
                obj =  '#'+$(this).attr('id')+' :input';
            } else {
                obj =  '#'+$(this).attr('name')+' :input';
            }
            $(obj).each(function(){
                switch (this.type) {
                    case 'password':
                    case 'select-multiple':
                    case 'select-one':
                    case 'select':
                    case 'text':
                    case 'textarea':
                        $(this).val('');
                        break;
                    case 'checkbox':
                    case 'radio':
                        this.checked = false
                        break;
                }

            });
        }
    });
})(jQuery);

function validaCPF(cpf) {
    var exp = /\.|\-/g;
    cpf = cpf.toString().replace( exp, "" );
    var erro = false;
    var digitos_iguais = 1;
    if (cpf.length != 11) {
        erro = true;
    } else if (cpf == '00000000000' || cpf == '11111111111' || cpf == '22222222222' || cpf == '33333333333' || cpf == '44444444444' || cpf == '55555555555' || cpf == '66666666666' || cpf == '77777777777' || cpf == '88888888888' || cpf == '99999999999') {
        erro = true;
    } else {
        for (i = 0; i < cpf.length - 1; i++) {
            if (cpf.charAt(i) != cpf.charAt(i + 1)) {
                digitos_iguais = 0;
                break;
            }
        }
        if (!digitos_iguais)   {
            var numeros = cpf.substring(0,9);
            var digitos = cpf.substring(9);
            var soma = 0;
            for (i = 10; i > 1; i--) {
                soma += numeros.charAt(10 - i) * i;
            }
            var resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0)) {
                erro = true;
            }
            numeros = cpf.substring(0,10);
            soma = 0;
            for (var i = 11; i > 1; i--) {
                soma += numeros.charAt(11 - i) * i;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1)) {
                erro = true;
            } else {
                erro = false;
            }
        } else {
            erro = true;
        }
    }

    return erro;
}

function validaCNPJ(cnpj){
    var erro = false;
    var exp = /\.|\-|\//g
    cnpj = cnpj.toString().replace( exp, "" );
    if(cnpj.length != 14){
        erro = true;
    } else if(cnpj == '00000000000000' || cnpj == '11111111111111' || cnpj == '22222222222222' || cnpj == '33333333333333' || cnpj == '44444444444444' || cnpj == '55555555555555' || cnpj == '66666666666666' || cnpj == '88888888888888' || cnpj == '99999999999999') {
        erro = true;
    } else {
        var valida = new Array(6,5,4,3,2,9,8,7,6,5,4,3,2);
        var dig1= new Number;
        var dig2= new Number;
        var digito = new Number(eval(cnpj.charAt(12)+cnpj.charAt(13)));
        for(i = 0; i<valida.length; i++){
            dig1 += (i>0? (cnpj.charAt(i-1)*valida[i]):0);
            dig2 += cnpj.charAt(i)*valida[i];
        }
        dig1 = (((dig1%11)<2)? 0:(11-(dig1%11)));
        dig2 = (((dig2%11)<2)? 0:(11-(dig2%11)));
        if(((dig1*10)+dig2) != digito){
            erro = true;
        }
    }
    return erro;
}

(function($){
    $.fn.extend({
        insere_mascara:function(parametros){
            var defaults={
                numero:{
                    size:10,
                    maxlength:10,
                    minDate:null,
                    mascara:'?9999999999'
                }
            }
            var options=$.extend(true,defaults,parametros);
            $.each($(this).find(":input"),function(){
                $(this).unmask();
                $(this).unmaskMoney();
                if($(this).hasClass('textoDisabled')){
                    $(this).removeAttr('title');
                    $(this).removeClass('obrigatorio');
                } 
                if($(this).hasClass('obrigatorio')){
                    $(this).removeAttr('title');
                } 
                if($(this).hasClass('data')){
                    $(this).mask("?99/99/9999");
                    $(this).datepicker({
                        minDate: options.minDate
                    });
                    $(this).attr('title','Informe uma Data');
                    $(this).attr('size','10');
                    $(this).attr('maxlength','10');
                }else if($(this).hasClass('email')){
                    $(this).attr('title','Informe um E-mail.');
                    $(this).attr('size','150');
                    $(this).removeAttr('maxlength');
                }else if($(this).hasClass('hora')){
                    $(this).attr('title','Informe uma Hora.');
                    $(this).mask("?99:99");
                    $(this).attr('size','5');
                    $(this).attr('maxlength','5');
                }else if($(this).hasClass('hora_segundos')){
                    $(this).mask("?99:99:99");
                    $(this).attr('title','Informe uma Hora.');
                    $(this).attr('size','8');
                    $(this).attr('maxlength','8');
                }else if($(this).hasClass('data_hora')){
                    $(this).datetimepicker({
                        showSecond:true,
                        timeFormat:'hh:mm:ss'
                    });
                    $(this).mask("?99/99/9999 99:99:99");
                    $(this).attr('title','Informe uma Data/Hora.');
                    $(this).attr('size','19');
                    $(this).attr('maxlength','19');
                }else if($(this).hasClass('placa')){
                    $(this).mask("?aaa-9999");
                    $(this).attr('title','Informe uma Placa.');
                    $(this).attr('size','8');
                    $(this).attr('maxlength','8');
                    $(this).css({
                        'text-transform':'uppercase'
                    });
                }else if($(this).hasClass('cpf')){
                    $(this).mask("?999.999.999-99");
                    $(this).attr('title','Informe um CPF.');
                    $(this).attr('size','14');
                    $(this).attr('maxlength','14');
                }else if($(this).hasClass('ddd')){
                    $(this).mask("?99");
                    $(this).attr('title','Informe um DDD.');
                    $(this).attr('size','2');
                    $(this).attr('maxlength','2');
                }else if($(this).hasClass('telefone')){
                    $(this).mask("?9999-9999");
                    $(this).attr('title','Informe um Telefone.');
                    $(this).attr('size','9');
                    $(this).attr('maxlength','9');
                }else if($(this).hasClass('ddd_telefone')){
                    $(this).mask("?(99) 9999-9999");
                    $(this).attr('title','Informe um Telefone com DDD.');
                    $(this).attr('size','16');
                    $(this).attr('maxlength','14');
                }else if($(this).hasClass('pais_ddd_telefone')){
                    $(this).mask("?+99 (99) 9999-9999");
                    $(this).attr('title','Informe um Telefone com DDD.');
                    $(this).attr('size','20');
                    $(this).attr('maxlength','18');
                }else if($(this).hasClass('cnpj')){
                    $(this).mask("?99.999.999/9999-99");
                    $(this).attr('title','Informe um CNPJ.');
                    $(this).attr('size','18');
                    $(this).attr('maxlength','18');
                }else if($(this).hasClass('cep')){
                    $(this).mask("?99999-999");
                    $(this).attr('title','Informe um CEP.');
                    $(this).attr('size','9');
                    $(this).attr('maxlength','9');
                }else if($(this).hasClass('numero')){
                    $(this).mask(options.numero.mascara,{
                        placeholder:""
                    });
                    $(this).attr('title','Informe o número.');
                    $(this).attr('size',options.numero.size);
                    $(this).attr('maxlength',options.numero.maxlength);
                }else if($(this).hasClass('moeda')){
                    $(this).maskMoney({
                        allowNegative:true
                    });
                    $(this).attr('title','Informe valor Monetário.');
                }else if($(this).hasClass('latitude_longitude')){
                    $(this).maskMoney({
                        allowNegative:true,
                        precision:6
                    });
                    $(this).attr('title','Informe valor '+$(this).attr('name')+'.');
                }else if($(this).hasClass('peso')){
                    $(this).maskMoney({
                        precision:3
                    });
                    $(this).attr('title','Informe valor Peso KG');
                }
            });
            $.each($(this).find(":input"),function(){
                var concat='';
                if($(this).hasClass('obrigatorio')){
                    concat=$(this).attr('title');
                    if(concat==undefined||$.trim(concat)==''){
                        $(this).attr('title','Campo obrigatório.');
                    }else{
                        $(this).attr('title','Campo obrigatório, '+concat);
                    }
                }else if($(this).hasClass('editor')){
                    concat=$(this).parent().attr('title');
                    if(concat==undefined||$.trim(concat)==''){
                        $(this).closest('.redactor_box').attr('title','Campo obrigatório.');
                    }else{
                        $(this).closest('.redactor_box').attr('title','Campo obrigatório, '+concat);
                    }
                }
            });
        }
    });
})(jQuery);

function valida_email(mail) {
    var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
    if (er.test(mail)) {
        return false;
    } else {
        return true;
    }
}

(function($){
    $.fn.extend({
        color_campos_form:function(parametros){
            var defaults={
                classErro:'textoErro',
                classSucesso:'textoSucesso',
                classAviso:'textoAviso',
                campos:'',
                msg:'',
                divErro:''
            }
            var options=$.extend(true,defaults,parametros);
            var obj=$(this);
            var e='';
            $(obj).find(':input').removeClass(options.classSucesso);
            $(obj).find(':input').removeClass(options.classErro);
            $(obj).find(':input').removeClass(options.classAviso);
            $.each(obj.find(':input'),function(c,d){
                $.each(options.campos,function(a,b){
                    if($(d).attr('id')==a){
                        $(d).removeAttr('title').addClass(options.classErro).attr('title',b.msg)
                        if($(d).hasClass('editor')){
                            $(d).closest('.redactor_box').removeAttr('title').addClass(options.classErro).attr('title',b.msg);
                        }
                    }
                });
            });
            $.msg({
                cs:'erro',
                desc: options.msg,
                icon:'ui-icon-alert'
            }); 
        }
    });
})(jQuery);

(function($){
    $.fn.extend({
        form_consultar:function(){
            var form = '#'+$(this).closest('form').attr('id');
            var obj = this;
            $(obj).click(function(){
                if ($(form).valida_form() == true) {
                    $.msg({
                        cs:'sucesso',
                        desc: "Aguarde... Verificando dados.",
                        icon:'ui-icon-info'
                    }); 
                    $(form).removeAttr('onsubmit');
                    $(form).attr('method','post');
                    $(form).submit();
                    return true;
                } else {
                    return false;
                }
            }); 
        }
    });
})(jQuery);

function url_segmento(posicao){
    if(posicao==undefined||posicao==''||posicao==0){
        return null;
    }else{
        var nova_url=new Array();
        var url=location.href;
        url=url.replace(url_base,'');
        nova_url=url.split('/');
        if(nova_url[(posicao-1)]==undefined){
            return null
        }else{
            return nova_url[(posicao-1)];
        }
    }
}

function bt_novo(){
    $('.bt_novo').bt({
        text:'Novo',
        icon:'ui-icon-document'
    });
    $('.bt_novo').click(function(e){
        e.preventDefault();
        var url = (url_base + url_segmento(1) + '/' + url_segmento(2) + '/cadastrar');
        location.href = url;
        return false;
    });
}

(function($){
    $.fn.extend({
        print_frame:function(parametros){
            var defaults={
                'html':'',
                height:($(window).height() - ($(window).height()/10)),
                width:($(window).width() - 100 ),
                title:''
            }
            var options=$.extend(true,defaults,parametros);
            $( "#dialog:ui-dialog" ).dialog( "destroy" );
            $( "#dialog-modal p" ).html('<iframe src="'+options.html+'" name="print_modal" id="print_modal" width="100%" height="'+(options.height-100)+'" frameborder="0" marginheight="0" marginwidth="0" scrolling="auto"></iframe>');
            $( "#dialog-modal" ).dialog({
                title: options.title,
                modal: true,
                resizable:true,
                position: 'center',
                width: options.width,
                height: options.height,
                buttons: {
                    Fechar: function() {
                        $( this ).dialog( "close" );
                    },
                    Imprimir: function() {
                        window.frames["print_modal"].printPage();
                    }
                },
                open: function() {
                    $(this).parent().find('.ui-dialog-buttonpane button:first-child').button({
                        icons: {
                            primary: 'ui-icon-circle-close'
                        }
                    });
                    $(this).parent().find('.ui-dialog-buttonpane button:first-child').next().button({
                        icons: {
                            primary: 'ui-icon-print'
                        }
                    });
                }
            });
            return false;
        }
            
    });
})(jQuery);

(function($){
    $.fn.extend({
        preview_img:function(parametros){
            inclui_dialog();
            var defaults={
                height:($(window).height() - 100),
                width:($(window).width() - 100 ),
                _atual:'',
                _qtd:[],
                title:'Preview Imagem',
                scrolling: false,
                add_buttons : {
                    "Fechar": function() {
                        $( this ).dialog( "close" );
                        $("#dialog-modal .preview_img_temp").remove();
                    //$( "#dialog-modal .preview_img_temp" ).html('')
                    },
                    "Anterior": function() {
                        options._set_preview_img(options._atual - 1);
                    },
                    "Proximo": function() {
                        options._set_preview_img(options._atual + 1);
                    }
                },
                _set_preview_img : function(id){
                    if(id < 0){
                        id = ($(obj).length - 1);
                    } else if (id > ($(obj).length - 1)){
                        id = 0;
                    }
                    options._atual = id;

                    $( "#dialog-modal .preview_img_temp" ).html('');
                    $( "#dialog-modal .preview_img_temp" ).append('<img src="'+options._qtd[options._atual]+'" />');
                    $("#dialog-modal .preview_img_temp img").load(function(){
                        var tamanho_maximo = (options.height-110);
                        
                        var pad = 0;
                        
                        if($(this).height() >= tamanho_maximo){
                            $( "#dialog-modal .preview_img_temp img" ).attr({
                                'height' : tamanho_maximo
                            });
                        } else {
                            pad = parseInt(tamanho_maximo - $(this).height());
                            pad = (pad/2);
                        } 
                        
                        $( "#dialog-modal .preview_img_temp" ).css({
                            'text-align' : 'center',
                            'padding-top' : pad+'px',
                            'margin' : '0 auto',
                            'height' : (tamanho_maximo - pad),
                            "overflow": options.scrolling ? 'auto' : 'hidden'

                        });
                        $(this).unbind('load');
                    });
                }
            }
        
            var obj = this;
            var options=$.extend(true,defaults,parametros);
            $(this).unbind('click');
            $(this).click(function(){                    
                var img_atual = $(this).attr('src');
                _atualizar_tamanho_tela();
                
                function _get_preview_img(){
                    _get_preview_img_ordem(img_atual);
                    options._set_preview_img(options._atual);
                }
                
                function _get_preview_img_ordem(img){
                    $.each(obj,function(a,b){
                        options._qtd[a] = b.src;
                        if(b.src == img){
                            options._atual = a;
                        }
                    });
                }
                
                $(window).resize(function(){
                    if ($("#dialog-modal").html() != null){
                        _atualizar_tamanho_tela();
                        options._set_preview_img(options._atual);
                    }
                });
                
                function _atualizar_tamanho_tela(){
                    if($( "#dialog-modal" ).html() == null){    
                        $('body').prepend('<div id="dialog-modal"><p><div class="preview_img_temp"></div></p></div>');
                    } else {
                        $("#dialog-modal").remove();
                        $('body').prepend('<div id="dialog-modal"><p><div class="preview_img_temp"></div></p></div>');
                    }
                
                    
                    options.width = ($(window).width() - 500 );
                    options.height = ($(window).height() - ($(window).height()/3));
                    
                    $( "#dialog:ui-dialog" ).dialog( "destroy" );
                    //$( "#dialog-modal p div.preview_img_temp" ).html('');                
                
                    $( "#dialog-modal .preview_img_temp" ).css({
                        'text-align' : 'center',
                        'padding-top' : '5px',
                        'margin' : '0 auto',
                        "overflow": options.scrolling ? 'auto' : 'hidden'
                    }).html('');

                    $( "#dialog-modal" ).dialog({
                        title: options.title,
                        modal: true,
                        resizable:false,
                        position: 'center',
                        width: options.width,
                        height: options.height,
                        draggable: false,
                        buttons: options.add_buttons,
                        open: function() {
                            $(this).parent().find('.ui-dialog-buttonpane button').eq(0).button({
                                icons: {
                                    primary: 'ui-icon-circle-close'
                                }
                            });
                            if($(obj).length > 1){
                                $(this).parent().find('.ui-dialog-buttonpane button').eq(1).button({
                                    icons: {
                                        primary: 'ui-icon-circle-arrow-w'
                                    }
                                });
                                $(this).parent().find('.ui-dialog-buttonpane button').eq(2).button({
                                    icons: {
                                        primary: 'ui-icon-circle-arrow-e'
                                    }
                                });
                            } else {
                                $(this).parent().find('.ui-dialog-buttonpane button').eq(1).hide();
                                $(this).parent().find('.ui-dialog-buttonpane button').eq(2).hide();
                            }
                            _get_preview_img();
                        
                            if (jQuery.browser.msie != true) {
                                $('div[role="dialog"]').css({
                                    "position": "fixed",
                                    'top': '30px'
                                });
                            }
                        
                        }
                    
                    });
                
                }

                
                return false;
            });
        }
    });
})(jQuery);

function redimensionar_img(width, height, max_width, max_height) {
    parseInt(width, 10);
    parseInt(height, 10);
    parseInt(max_width, 10);
    parseInt(max_height, 10);
    
    if ( width > max_width || height > max_height ) {
        var ratioh = parseFloat(max_height / height);
        var ratiow = parseFloat(max_width / width);
        var ratio = Math.min(ratioh, ratiow);
        // New dimensions 
        width = parseInt( (ratio * width), 10 );
        height = parseInt( (ratio * height), 10 );
    }
    var res = new Array();
    res[0] = width;
    res[1] = height;
    return res;
}

function inclui_dialog() {
    $('#dialog-modal').remove();
    if ($('#dialog-modal').html() == null ) {
        $('body').append('<div id="dialog-modal"><p></p></div>');
    }
} 