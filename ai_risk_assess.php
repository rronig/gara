<?php
// ai_risk_assess.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
include_once 'config.php';

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$sector = $data['sector'] ?? '';
$capital_min = $data['capital_min'] ?? '';
$capital_max = $data['capital_max'] ?? '';
$timeline = $data['timeline'] ?? '';

// Compose prompt for OpenAI
$default_prompt = "Assess the investment risk (Low, Medium, High) for an opportunity in the following sector: $sector, with a capital range of $capital_min to $capital_max euros, and a timeline of $timeline months. Only reply with one word: Low, Medium, or High.";

// Call OpenAI API (replace YOUR_OPENAI_API_KEY with your key)
$apiKey = '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';
$ch = curl_init('https://api.openai.com/v1/chat/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey,
]);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        ['role' => 'user', 'content' => $default_prompt]
    ],
    'max_tokens' => 1,
]));
$response = curl_exec($ch);
$curl_error = curl_error($ch);
curl_close($ch);

$result = json_decode($response, true);
$ai_reply = $result['choices'][0]['message']['content'] ?? null;

if (!$ai_reply) {
    // Output debug info if something went wrong
    http_response_code(500);
    echo '<pre>';
    echo "OpenAI API Debug Info:\n";
    echo "cURL Error: ".$curl_error."\n";
    echo "Raw Response: ".$response."\n";
    echo "Decoded Result: ".print_r($result, true)."\n";
    echo '</pre>';
    exit;
}

// Save risk to database if opportunity_id is provided
$opportunity_id = $data['opportunity_id'] ?? null;
if ($opportunity_id && in_array(strtolower(trim($ai_reply)), ['low','medium','high'])) {
    $stmt = $pdo->prepare("UPDATE investment_opportunities SET risk_level = ? WHERE opportunity_id = ?");
    $stmt->execute([strtolower(trim($ai_reply)), $opportunity_id]);
}

echo json_encode(['risk' => trim($ai_reply)]);

// Final catch-all error output
if (!headers_sent()) {
    http_response_code(500);
    echo json_encode(['risk' => 'Unknown', 'error' => 'Script ended unexpectedly.']);
}
?>