<table class="tabela">
    <thead>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Valor Unitário</th>
            <th>Valor Total</th>
            <th>Ação</th>
        </tr>
    </thead>    
    <tbody>
        {produtos}
        <tr id_produtos="{id_produtos}">
            <td>{produto}</td>
            <td><input type="text" id="qtd" name="qtd" value="{quantidade}" class="qtd" /></td>
            <td>R$ {valor_unitario}</td>
            <td>R$ {valor_total}</td>
            <td><a class="atualizar"></a> <a class="remover"></a></td>
        </tr>
        {/produtos}
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td>Total Geral</td>
            <td>R$ {total_geral}</td>
            <td></td>
        </tr>
    </tfoot>
</table>

<div>
    <a class="comprar"></a>
    <a class="cancelar"></a>
    <select id="forma_pagamento" name="forma_pagamento">
        {forma_pagamento}
    </select>
</div>