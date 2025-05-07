<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apiKey = '6ec5436c-bd95-4ed0-8689-c169b850fedd'; 

    $data = [
        'subject' => 'Pago de prueba',
        'currency' => 'CLP',
        'amount' => 1000,
        'transaction_id' => uniqid('orden-')
    ];

    $ch = curl_init('https://payment-api.khipu.com/v3/payments');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'x-api-key: ' . $apiKey
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $responseData = json_decode($response, true);

    if ($httpCode === 200 && isset($responseData['payment_url'])) {
        header("Location: " . $responseData['payment_url']);
        exit();
    } else {
        echo "<h3>Error al generar el pago:</h3>";
        echo "<pre>";
        print_r($responseData);
        echo "</pre>";
    }
}
?>

<!-- Interfaz gráfica simple -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago con Khipu</title>
</head>
<body>
    <h2>Formulario de pago</h2>
    <form method="POST">
        <p>Monto: <strong>$1.000 CLP</strong></p>
        <button type="submit">Pagar ahora</button>
    </form>
</body>
</html>
