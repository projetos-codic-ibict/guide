<?php

// URL do endpoint
$endpoint = "http://143.54.112.91:11434/api/generate";

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém a mensagem enviada pelo usuário
    $message = $_POST['message'];

    // Configura os dados para envio
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

    $RSP = explode('}',$response);

    // Decodifica a resposta JSON
    foreach($RSP as $id=>$txt)
        {
            $response_data = json_decode($txt.'}', true);
            if (isset($response_data['response']))
                {
                    echo (string)$response_data['response'];
                }

        }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat com Ollama</title>
</head>

<body>
    <h1>Chat com Ollama</h1>
    <form method="POST">
        <label for="message">Mensagem:</label><br>
        <textarea id="message" name="message" rows="4" cols="50"></textarea><br><br>
        <input type="submit" value="Enviar">
    </form>

    <?php if (isset($reply)): ?>
        <h2>Resposta:</h2>
        <p><?php echo htmlspecialchars($reply); ?></p>
    <?php endif; ?>
</body>

</html>