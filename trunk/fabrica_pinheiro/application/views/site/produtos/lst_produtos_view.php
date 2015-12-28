<div class="paginacao">{paginacao}</div>
<div class="lista_produtos">
    <ul>
        {produtos}
        <li class="borda_redonda">
            <div class="foto">
                <img  src="{url_site}home/ver_foto/{id_produtos_fotos}.{extensao}"  width="{largura}px" height="{altura}px" title="{prf_nome}" />
            </div>
            <div class="lh title"><strong>{nome}</strong></div>
            <!--div style="color: blue;">Categoria: {ct_descricao}</div-->
            <div class="lh valor">{valor}</div>
            <div class="lh link">{links}</div>
        </li>
        {/produtos}
    </ul>
</div>
<div class="paginacao">{paginacao}</div>