<?php
require_once "../script/connessione.php";

$id_conto = 1;

// Recupero il saldo attuale
$sql_saldo = "SELECT saldo FROM conto_bancario WHERE id_conto = ?";
$stmt = $conn->prepare($sql_saldo);
$stmt->bind_param("i", $id_conto);
$stmt->execute();
$result = $stmt->get_result();
$saldo = $result->fetch_assoc()['saldo'];
$stmt->close();

// Recupero tutti i movimenti ordinati per data decrescente
$sql_movimenti = "SELECT importo, tipo, data_movimento FROM movimento WHERE id_conto = ? ORDER BY data_movimento DESC";
$stmt = $conn->prepare($sql_movimenti);
$stmt->bind_param("i", $id_conto);
$stmt->execute();
$result = $stmt->get_result();

$movimenti = [];
while ($row = $result->fetch_assoc()) {
    $movimenti[] = $row;
}

// Ricostruisco il saldo al contrario per mostrarlo cronologicamente
$labels = [];
$data = [];
$current_saldo = floatval($saldo);

// Siccome abbiamo ordinato DESC, percorriamo all'indietro
for ($i = count($movimenti) - 1; $i >= 0; $i--) {
    $row = $movimenti[$i];
    $labels[] = date("Y-m-d", strtotime($row['data_movimento']));
    $data[] = $current_saldo;

    if ($row['tipo'] === 'entrata') {
        $current_saldo -= floatval($row['importo']);
    } else {
        $current_saldo += floatval($row['importo']);
    }
}

// Aggiungo il saldo iniziale
$labels[] = "Inizio";
$data[] = $current_saldo;

// Ordino cronologicamente
$labels = array_reverse($labels);
$data = array_reverse($data);
?>

<div class="grafico">
    <canvas id="saldoChart" width="800" height="400"></canvas>
</div>

<script>
    const ctx = document.getElementById('saldoChart').getContext('2d');
    const saldoChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Saldo (€)',
                data: <?php echo json_encode($data); ?>,
                borderColor: '#003366',
                backgroundColor: 'rgba(0,51,102,0.05)',
                fill: true,
                tension: 0.2
            }]
        },
        options: {
        responsive: true,
        plugins: {
            legend: 
            {
                display: false
            },
            title: 
            {
                display: true,
                text: 'Andamento saldo conto principale'
            }
        },
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });
</script>
