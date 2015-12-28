<div class="paginacao">{paginacao}</div>
<table class="tabela">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF/CNPJ</th>
            <th>Endereço</th>
            <th>Cidade</th>
            <th>Bairro</th>
            <th>CEP</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        {pessoas}
        <tr>
            <td>{id_pessoas}</td>
            <td>{nome}</td>
            <td>{inscricao}</td>
            <td>{endereco}, {numero}</td>
            <td>{cidade} - {estado}</td>
            <td>{bairro}</td>
            <td>{cep}</td>
            <td>{acao}</td>
        </tr>
        {/pessoas}
    </tbody>
</table>
<div class="paginacao">{paginacao}</div>