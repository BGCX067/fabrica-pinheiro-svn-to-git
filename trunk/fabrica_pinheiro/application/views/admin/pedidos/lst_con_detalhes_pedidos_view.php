{bt_imprimir}
<div style="margin-bottom: 5px;margin-top: 5px;">
    <h2 class="caixa_titulo">Dados do Cliente</h2>
    <div class="caixa_borda">
        <table class="tabela">
            <thead>
                <tr>
                    <th>ID Cliente</th>
                    <th>Nome</th>
                    <th>E-mnail</th>
                </tr>
            </thead>
            <tbody>
                {cliente}
                <tr>
                    <td>{id_clientes}</td>
                    <td>{nome}</td>
                    <td>{email}</td>
                </tr>
                {/cliente}
            </tbody>
        </table>
    </div>
</div>

<div class="clear"></div>

<div style="margin-bottom: 5px;">
    <h2 class="caixa_titulo">Dados do Pedido</h2>
    <div class="caixa_borda">
        <table class="tabela">
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Data/hora</th>
                    <th>Situação</th>
                </tr>
            </thead>
            <tbody>
                {pedido}
                <tr>
                    <td>{id_pedidos}</td>
                    <td>{data_hora}</td>
                    <td>{situacao}</td>
                </tr>
                {/pedido}
            </tbody>
        </table>
    </div>
</div>

<div class="clear"></div>

<div style="margin-bottom: 5px;">
    <h2 class="caixa_titulo">Itens do Pedido</h2>
    <div class="caixa_borda">
        <table class="tabela">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Valor unitario (R$)</th>
                    <th>Quantidade</th>
                    <th>Valor totla (R$)</th>
                </tr>
            </thead>
            <tbody>
                {itens}
                <tr>
                    <td>{pr_nome}</td>
                    <td>{valor}</td>
                    <td>{qtd}</td>
                    <td>{valor_total}</td>
                </tr>
                {/itens}
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Total do pedido</td>
                    <td>{total_geral}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
{bt_imprimir}