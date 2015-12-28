<form name="frm_cad_banners_tipos" id="frm_cad_banners_tipos" onsubmit="return false;">
    <input type="hidden" name="id_banners_tipos" id="id_banners_tipos" value="{id_banners_tipos}" />

    <label for="nome">Nome</label>
    <input type="text" id="nome" name="nome" value="{nome}" size="50" maxlength="45" class="obrigatorio" />
    <div class="clear"></div>

    <label for="largura">Largura</label>
    <input type="text" id="largura" name="largura" value="{largura}" size="3" maxlength="1" class="obrigatorio numero" />
    <div class="clear"></div>

    <label for="altura">Altura</label>
    <input type="text" id="altura" name="altura" value="{altura}" size="3" maxlength="1" class="obrigatorio numero" />
    <div class="clear"></div>

    <label for="extensao">Extensão</label>
    <input type="text" id="extensao" name="extensao" value="{extensao}" size="100" maxlength="100" class="obrigatorio" />
    <div class="clear"></div>

    <button class="bt_gravar"></button>
    <button class="bt_novo"></button>

</form>