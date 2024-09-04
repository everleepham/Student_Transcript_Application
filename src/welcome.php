<?php
require_once 'welcome_back.php';
require_once 'student.php';

if(!Student::checkLoggedInUser()){
    header('location: login.php');
    exit;
}


$overall = getOverall();
foreach ($overall as $row) {
    $populations[$row['student_population_code_ref']] = $row['count(s.student_epita_email)'];
    $data[] = [
        'label' => $row['student_population_code_ref'],  
        'value' => $row['count(s.student_epita_email)']
    ];
}
$attendance = getAttendance();
foreach ($attendance as $row) {
    $att[$row['student_population_code_ref']] = $row['percentage'];
    $data_attendance[] = [
        'label' => $row['student_population_code_ref'],  
        'value' => $row['percentage']
    ];
}



$data_Overall = json_encode(getOverall());
$data_Attendance = json_encode(getAttendance());

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="style/main.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>



</head>


<body>
    


    <div id="wrapper">
    <div id="header">
            <div class="header-content">
            
            <h1><b>Welcome!</b></h1> 

            <div class='logout'>
                <span class="material-symbols-outlined">logout</span>
                <a href="logout.php" class="custom">Logout</a>
            </div>
        
        </div>
        <br>
    
        <div id="main-content" class="container">
            <br>
            <br>
            <div id="content">
            
                <h2> Overall Active Populations</h2>
                <ul type="circle">
                    <li><a href="population.php?population=AIs" class="custom_link">ME - Artificial Inteligences (<?php echo $populations['AIs']?>)</a></li>
                    <li><a href="population.php?population=CS" class="custom_link">Msc - Cyber Security (<?php echo $populations['CS']?>)</a></li>
                    <li><a href="population.php?population=ISM" class="custom_link">Msc - Information System Management (<?php echo $populations['ISM']?>)</a></li>
                    <li><a href="population.php?population=DSA" class="custom_link">ME - Data Science (<?php echo $populations['DSA']?>)</a></li>
                    <li><a href="population.php?population=SE" class="custom_link">Msc - Software Engineer (<?php echo $populations['SE']?>)</a></li>
                </ul>
                <br>
                <br>
            
                <h2>Overall Attendance</h2>
            
                <ul type="circle">
                    <li>ME - Artificial Inteligences (<?php echo $att['AIs']?> %)</li>
                    <li>Msc - Cyber Security (<?php echo $att['CS']?>%)</li>
                    <li>Msc - Information System Management (<?php echo $att['ISM']?>%)</li>
                    <li>ME - Data Science (<?php echo $att['DSA']?>%)</li>
                    <li>Msc - Software Engineer (<?php echo $att['SE']?>%)</li>
                </ul>
                   
            </div>

            <div id="sidebar">
            <canvas id="myPieChart" width="10" height="8"></canvas>
            <br>
            <canvas id="myBarChart" width="10" height="8"></canvas>

            </div>
        </div>
    </div>

    
    <script>
    // Biểu đồ tròn
    const pieData = <?php echo json_encode($data); ?>;

    const pieLabels = pieData.map(item => item.label);
    const pieValues = pieData.map(item => item.value);

    const pieCtx = document.getElementById('myPieChart').getContext('2d');
    const myPieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: pieLabels,
            datasets: [{
                data: pieValues,
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
                    display: false,

                },
                title: {
                    display: true,
                    text: 'Populations chart'
                },
                datalabels: {
                    display: true,
                    color: 'rgba(102, 102, 102, 1)',
                    font: {
                        weight: 'bold'
                    },
                    formatter: (value) => value
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    const barData = <?php echo json_encode($data_attendance); ?>;

    const barLabels = barData.map(item => item.label);
    const barValues = barData.map(item => item.value);

    const barCtx = document.getElementById('myBarChart').getContext('2d');
    const myBarChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: barLabels,
            datasets: [{
                data: barValues,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100 
                }
            },
            plugins: {
                legend: {
                    display: false,
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Attendance Percentage'
                }
            }
        }
    });
</script>
</body>
</html>

