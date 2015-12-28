<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            {meta}
            <title>{title}</title>
            {css}
            <link rel="shortcut icon" href="{base_url}template/defaut/images/ps.ico" type="image/x-icon" />
            <script type="text/javascript">
                var url_site = "{url_site}";    
                var url_admin = "{url_admin}";    
                var url_base = "{base_url}";   
                var url_blog = "{url_blog}";   
                {js}
            </script>
    </head>
    <body>
        <div class="geral">
            <div class="conteudo_geral">
                <div class="conteudo">
                    <h1 class="conteudo_titulo">{conteudo_titulo}</h1>
                    <div class="conteudo_content">{conteudo}</div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
        <script type="text/javascript">
            function printPage(){
                window.print();
            }
        </script>
    </body>
</html>