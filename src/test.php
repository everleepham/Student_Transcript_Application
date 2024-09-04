<?php
require_once 'welcome_back.php';


$data_Overall = json_encode(getOverall());
$data_Attendance = json_encode(getAttendance());

echo $data_Overall


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Pie Chart with PHP</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="myPieChart" width="400" height="400"></canvas>

    <script>
    // Nhận dữ liệu từ PHP
    const data = <?php echo json_encode($data_Overall); ?>;

    // Chuẩn bị dữ liệu cho biểu đồ
    const labels = data.map(item => item.label);
    const values = data.map(item => item.value);

    // Tạo biểu đồ tròn
    const ctx = document.getElementById('myPieChart').getContext('2d');
    const myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Dynamic Pie Chart with PHP'
                }
            }
        }
    });
</script>
</body>
</html>