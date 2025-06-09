<?php

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Невірний формат JSON']);
    exit;
}

$name = htmlspecialchars($data['name'] ?? '');
$email = htmlspecialchars($data['email'] ?? '');
$phone = htmlspecialchars($data['phone'] ?? '');
$address = htmlspecialchars($data['address'] ?? '');
$amount = htmlspecialchars($data['amount'] ?? '');

$message = "Нове замовлення з сайту handmade:\n\n";
$message .= "Ім’я: $name\n";
$message .= "Email: $email\n";
$message .= "Телефон: $phone\n";
$message .= "Адреса: $address\n";
$message .= "Сума: $amount грн";

$to = 'vz.web.dev@gmail.com';
$subject = 'Нове замовлення з сайту handmade';
$headers = "From: no-reply@handmade.company\r\n" .
           "Content-Type: text/plain; charset=UTF-8";

$success = mail($to, $subject, $message, $headers);

if ($success) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Не вдалося надіслати лист']);
}
?>
