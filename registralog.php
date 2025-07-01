<?php
function registrarLog($pdo, $idUsuario, $nomeUsuario, $tipoAcao, $descricao) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $dataHora = date('Y-m-d H:i:s');

    $sql = "INSERT INTO log_atividades (id_usuario, nome_usuario, acao, descricao, ip, data_hora)
            VALUES (:id_usuario, :nome_usuario, :acao, :descricao, :ip, :data_hora)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_usuario' => $idUsuario,
        ':nome_usuario' => $nomeUsuario,
        ':acao' => $tipoAcao,
        ':descricao' => $descricao,
        ':ip' => $ip,
        ':data_hora' => $dataHora
    ]);
}
?>