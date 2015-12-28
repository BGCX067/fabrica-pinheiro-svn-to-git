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
            </script>
            {js}
    </head>
    <body>
        <div class="geral">
            <div class="topo">
                <div></div>
            </div>

            <div class="menu">
                <ul>
                    <li><a class="current" href="#">Cadastros</a>
                        <ul>
                            <li><a href="{url_admin}categorias/cadastrar">Categorias</a></li>
                            <li><a href="{url_admin}pessoas/cadastrar">Pessoas</a></li>
                            <li><a href="{url_admin}produtos/cadastrar">Produtos</a></li>
                            <li><a href="{url_admin}banners/cadastrar">Banners</a></li>
                            <li><a href="{url_admin}banners_tipos/cadastrar">Tipos Banners</a></li>
                            <li><a href="{url_admin}blogs/cadastrar">Blogs</a></li>
                            <li><a href="{url_admin}blogs_categorias/cadastrar">Blogs Categorias</a></li>
                        </ul>
                    </li>
                    <li><a class="current" href="#">Consultas</a>
                        <ul>
                            <li><a href="{url_admin}categorias/consultar">Categorias</a></li>
                            <li><a href="{url_admin}clientes/consultar">Clientes</a></li>
                            <li><a href="{url_admin}pessoas/consultar">Pessoas</a></li>
                            <li><a href="{url_admin}produtos/consultar">Produtos</a></li>
                            <li><a href="{url_admin}usuarios/consultar">Usuários</a></li>
                            <li><a href="{url_admin}banners/consultar">Banners</a></li>
                            <li><a href="{url_admin}banners_tipos/consultar">Tipos Banners</a></li>
                            <li><a href="{url_admin}blogs/consultar">Blogs</a></li>
                            <li><a href="{url_admin}blogs_categorias/consultar">Blogs Categorias</a></li>
                        </ul>
                    </li>
                    <li><a class="current" href="#">Pedidos</a>
                        <ul>
                            <li><a href="{url_admin}pedidos/consultar">Consultar</a></li>
                        </ul>
                    </li>
                    <li><a class="current" href="{url_admin}login/sair">Sair</a></li>
                </ul>
            </div>

            <div id="msg_sistema" class="ui-widget" {style}>
                 <div class="ui-corner-all {msg_class}"> 
                    <span class="icone ui-icon {msg_icon}"></span> 
                    <span class="desc_msg">{msg_descricao}</span>
                </div>

            </div>
            <div class="conteudo_geral">
                <div class="conteudo">
                    <h1 class="conteudo_titulo">{conteudo_titulo}</h1>
                    <div class="conteudo_content">{conteudo}</div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
            <div class="rodape">{rodape}</div>
        </div>

        <div id="dialog-modal">
            <p></p>
        </div>
        <div id="div_print">
        </div>
    </body>
</html>
