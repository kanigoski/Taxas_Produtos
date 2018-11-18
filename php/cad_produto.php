<?php
require("conexao.php");

if (isset($_POST['carregar'])) {
    if(!$con) {
        echo '[{"erro": "Problema com conexão com banco de dados!"}]';
    } else {
        $sql =  " SELECT " .
                    " produto.id_produto, produto.descricao, produto.valor, tipo_produto.descricao AS desc_tipo_produto, tipo_produto.tributo " .
                " FROM produto " .
                    " INNER JOIN tipo_produto " .
                        " ON tipo_produto.id_tipo_produto = produto.id_tipo_produto " .
                        " AND tipo_produto.registro_valido = TRUE " .
                " WHERE produto.registro_valido = TRUE " .
                " ORDER BY produto.id_produto ";
        $result = pg_query($sql);
        $n = pg_num_rows($result);
    
        if (!$result) {
            echo '[{"erro": "Nenhum resultado encontrado!"}]';
        }else {
            if ($n > 0) {
                for($i = 0; $i<$n; $i++) {
                    $dados[] = pg_fetch_assoc($result, $i); 
                }
                echo json_encode($dados);
            } else {
                echo '[{"erro": "Aperte em \"Cadastrar\" para adicionar produtos!"}]';
            }
        }
    }
} else if(isset($_POST['remover'])) {
    $id_produto = $_POST['remover'];

    $sql =  " UPDATE produto " .
            " SET registro_valido = FALSE " .
            " WHERE id_produto = $id_produto";
    $result = pg_query($sql);

} else if(isset($_POST['registrar'])) {
    $tipo_produto = $_POST['id_tipo_produto'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];

    if ($tipo_produto == "") {
        echo '[{"erro": "Campo tipo de produto é obrigatório!"}]';
    } else if ($descricao == "") {
        echo '[{"erro": "Campo descricao é obrigatório!"}]';
    } else if ($valor == "") {
        echo '[{"erro": "Campo valor do produto é obrigatório!"}]';
    } else {
        $sql = "INSERT INTO produto (id_tipo_produto, descricao, valor, registro_valido) VALUES ($tipo_produto , '$descricao' , '$valor' , 'true')";
        $result = pg_query($sql);
    }
}
?>