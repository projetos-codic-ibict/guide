<?php

// URL do endpoint
$endpoint = "http://143.54.112.91:11434/api/generate";

// Verifica se a requisição AJAX foi feita
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém a mensagem enviada pelo usuário
    $message = $_POST['message'];

    // Configura os dados para envio
    echo "Processando.....<br>";
    $data = array(
            'model' => 'llama3',
            'prompt' => $message
        );

    // Inicializa o cURL
    $ch = curl_init($endpoint);

    // Configura as opções do cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    // Executa a requisição e obtém a resposta
    $response = curl_exec($ch);

    // Fecha a sessão do cURL
    curl_close($ch);

    $RSP = explode('}', $response);

    // Decodifica a resposta JSON
    foreach ($RSP as $id => $txt) {
        $response_data = json_decode($txt . '}',
            true
        );
        if (isset($response_data['response'])) {
            echo (string)$response_data['response'];
        }
    }
}
