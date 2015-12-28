
(function($){
    $.fn.extend({
        upload_arquivos: function(parametros) {
            var defaults={
                dataType: 'json',
                nome_form: 'form_anexos',
                nome_botao: 'Anexar',
                url: '',
                debug_display: false,
                data: null,
                target_uploader: 'jquery_upload_arquivos',
                success: function() {},
                error: function() {}
            }
            var option = jQuery.extend(true,defaults,parametros);
            var campos_extras = '';
            var obj = this;
        
            $(obj).html('');
        
            if(option.data !=  null){
                jQuery.each(option.data,function(a,b){
                    campos_extras += '<input type="hidden" name="'+a+'" id="'+a+'" value="'+b+'" />'+"\n";
                });
            }
        
            var _formulario = '<form method="post" id="'+option.nome_form+'" name="'+option.nome_form+'" action="'+option.url+'" enctype="multipart/form-data" target="'+option.target_uploader+'">'
            +campos_extras
            +'<span class="file-wrapper ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false" style="font-size: 1em;">'
            +'  <input type="file" id="adicionar_arquivo" name="adicionar_arquivo" />'
            +'  <span class="ui-button-icon-primary ui-icon ui-icon-document"></span>'
            +'  <span class="ui-button-text button">'+option.nome_botao+'</span>'
            +'</span>'
            +'<span class="img_carragando" style="display: none;margin-left:15px;">'
            +'    <span><img src="'+url_base+'template/defaut/images/loading.gif" /></span>'
            +' Aguarde carregando...'
            +' </span>'
            +'</form>'
            +'<iframe id="'+option.target_uploader+'" name="'+option.target_uploader+'" src="about:blank" style="display: none; border:1px solid #000;" height="1" width="1" frameborder="0" scrolling="auto"></iframe>';
        
            $(obj).html(_formulario);
            start_upload();
        
            if(option.debug_display == true){
                $('#'+option.target_uploader).css({
                    'display' : 'block',
                    'height' : '400px',
                    'width' : '99%'
                });
            }

            function start_upload(){
                $('#'+option.nome_form+' .file-wrapper :file').css({
                    'height' : $('#'+option.nome_form+' .file-wrapper').height(),
                    'width' : '100%'
                });
                $('#adicionar_arquivo').bind($.browser.msie? 'propertychange': 'change',function(){
                    if($(this).val() != ''){
                        $('#'+option.nome_form+' .img_carragando').show();
                        $("#"+option.nome_form).submit();
                        $('#'+option.nome_form+' #adicionar_arquivo').remove();
                        _retorno_upload_arquivo();
                    }
                    return true;
                });
            }
        
            function _retorno_upload_arquivo(){
                $('#'+option.target_uploader).load(function(){
                    var contents = $.trim($(this).contents().find('body').html());
                    switch (option.dataType) {
                        case 'json':
                            try {
                                option.success.call(null,$.parseJSON(contents));
                            } catch (Ex) {
                                option.error.call(null,$.parseJSON('{"cod":"404","msg":"Não foi possivel carregar o arquivo."}'));
                            }
                            break;
                        
                        case 'xml':
                            try {
                                option.success.call(null,$.parseXML(contents));
                            } catch (Ex) {
                                option.error.call(null,$.parseXML('<?xml version="1.0" encoding="UTF-8"?> <root> <cod>404</cod> <msg>Não foi possivel carregar o arquivo.</msg> </root>'));
                            }
                            break;
                        default:
                            try {
                                option.success.call(null,$.parseJSON(contents));
                            } catch (Ex) {
                                option.error.call(null,$.parseJSON('{"cod":"404","msg":"Não foi possivel carregar o arquivo."}'));
                            }
                            break;
                    }
                    $('#'+option.nome_form+' .file-wrapper').prepend('<input type="file" id="adicionar_arquivo" name="adicionar_arquivo" />');
                    $('#'+option.nome_form+' .img_carragando').hide();
                    start_upload();
                    $(this).unbind('load');
                });
                return true;
            }
        }
    });
})(jQuery);
