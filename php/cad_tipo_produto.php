<?php
require("conexao.php");

if (isset($_POST['carregar'])) {
    if(!$con) {
        echo '[{"erro": "Problema com conexão com banco de dados!"}]';
    } else {
        $sql =  " SELECT " .
                    " id_tipo_produto, descricao, tributo " .
                " FROM tipo_produto " .
                " WHERE registro_valido = TRUE " .
                " ORDER BY id_tipo_produto";
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
                echo '[{"erro": "Aperte em \"Cadastrar\" para adicionar tipo de produtos!"}]';
            }
        }
    }
} else if(isset($_POST['remover'])) {
    $id_tipo_produto = $_POST['remover'];

    $sql =  " UPDATE tipo_produto " .
            " SET registro_valido = FALSE " .
            " WHERE id_tipo_produto = $id_tipo_produto";
    $result = pg_query($sql);

} else if(isset($_POST['registrar'])) {
    $descricao = $_POST['descricao'];
    $tributos = $_POST['tributos'];

    if ($descricao == "") {
        echo '[{"erro": "Campo descricao é obrigatório!"}]';
    } else if ($tributos == "") {
        echo '[{"erro": "Campo valor do tributo é obrigatório!"}]';
    } else {
        $sql = "INSERT INTO tipo_produto (descricao, tributo, registro_valido) VALUES ('$descricao' , '$tributos' , 'true')";
        $result = pg_query($sql);
    }
}
?>