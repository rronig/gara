<?php
$taxBenefitMin = $taxBenefitMax = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $investment = floatval($_POST['amount']);

    // ICT sector: example rate between 1.5% - 4.5% annually
    $taxBenefitMin = round($investment * 0.015, 2);
    $taxBenefitMax = round($investment * 0.045, 2);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quick Investment Calculator</title>
    <style>
        body { font-family: Arial; margin: 30px; }
        input[type="number"] { width: 200px; padding: 8px; }
        button { padding: 8px 16px; margin-top: 10px; }
        .result { margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>

<h2>Quick Investment Calculator</h2>

<form method="post">
    <label><strong>Investment Sector:</strong></label><br>
    <input type="text" value="ICT" readonly><br><br>

    <label><strong>Investment Amount (€):</strong></label><br>
    <input type="number" name="amount" min="10000" max="1000000" required><br><br>

    <button type="submit">Calculate Full Benefits</button>
</form>

<?php if ($taxBenefitMin !== null): ?>
    <div class="result">
        <p>Expected Tax Benefits: <strong>€<?= number_format($taxBenefitMin, 2) ?> - €<?= number_format($taxBenefitMax, 2) ?></strong> annually</p>
    </div>
<?php endif; ?>

</body>
</html>
