<div class="detalhes_produtos" style="overflow: hidden; position: relative; width: 100%;">
    <div style="float: left; width: 49%; position: relative;">
        <div class="detalhes_img" style="text-align: center;padding-top: 10px;">
            <img class="pre_img" src="{url_site}home/ver_foto/{prf_id_produtos_fotos}.{prf_extensao}" width="95%" />
        </div>
        <div class="lista_img" style=" margin-top: 15px; text-align: center;">
            {imagens}
            <span style="cursor: pointer;"><img src="{url_site}home/ver_foto/{id_produtos_fotos}.{extensao}" width="{largura}px" height="{altura}px" /></span>
            {/imagens}
        </div>
    </div>
    <div style="float: right; width: 49%; padding: 5px;line-height: 25px;">
        <h1 style="font-size: 2em; color: blue;">{nome}</h1>
        <div><strong>Valor R$:</strong> {valor}</div>
        <div><strong>Categoria:</strong> {ct_descricao}</div>
        <div>{esgotado}</div>
        <div class="social">
            <ul class="social-buttons cf">
                <li><a href="http://twitter.com/share?url=http://pinheiroshop.com.br/{uri_string}" class="socialite twitter-share" data-text="{uri_title}" data-url="http://pinheiroshop.com.br/{uri_string}" data-count="vertical" rel="nofollow" target="_blank"><span class="vhidden">Share on Twitter</span></a></li>
                <li><a href="https://plus.google.com/share?url=http://pinheiroshop.com.br/{uri_string}" class="socialite googleplus-one" data-size="tall" data-href="http://pinheiroshop.com.br/{uri_string}" rel="nofollow" target="_blank"><span class="vhidden">Share on Google+</span></a></li>
                <li><a href="http://www.facebook.com/sharer.php?u=http://pinheiroshop.com.br/{uri_string}&amp;t={uri_title}" class="socialite facebook-like" data-href="http://pinheiroshop.com.br/{uri_string}" data-send="false" data-layout="box_count" data-width="60" data-show-faces="true" rel="nofollow" target="_blank"><span class="vhidden">Share on Facebook</span></a></li>
                <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=http://pinheiroshop.com.br/{uri_string}&amp;title={uri_title}" class="socialite linkedin-share" data-url="http://pinheiroshop.com.br/{uri_string}" data-counter="top" rel="nofollow" target="_blank"><span class="vhidden">Share on LinkedIn</span></a></li>
            </ul>
        </div>
        <div><strong>Descrição:</strong> {descricao}</div>

    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>
<script>
    Socialite.load($(this)[0]);
</script>