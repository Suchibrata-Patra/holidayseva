<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>HolidaySeva</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
        .chart-container {
            width: 45%;
            height: 500px;
            margin: 0 auto;
            display: inline-block;
        }

        .container {
            margin-left: 10%;
        }

        #filter-container {
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include('navigation.php'); ?>
    <section class="home" style="font-weight:400;!important">
        <br>

        <div class="container" >
            <h1 style="font-weight:400;font-size:2rem;">Sales Insights</h1>

            <!-- Date Range Picker -->
            <div id="filter-container">
                <label for="start_date">Start Date:</label>
                <input type="month" id="start_date">
                <label for="end_date">End Date:</label>
                <input type="month" id="end_date">
                <button onclick="updateCharts()">Filter</button>
            </div>

            <!-- Charts -->
            <div class="chart-container" id="revenue_chart_div" style="border-radius:50px !important;"></div>
            <div class="chart-container" id="tour_chart_div"></div>

            <?php
            include 'database.php';

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch month-wise data for revenue
            $revenueResult = $conn->query("
            SELECT 
                DATE_FORMAT(date_of_journey, '%Y-%m') AS month, 
                SUM(pricing) AS total_pricing
            FROM 
                invoice_data 
            WHERE booking_status = 'confirmed'
            GROUP BY 
                month 
            ORDER BY 
                month ASC
        ");

            $revenueData = [];
            while ($row = $revenueResult->fetch_assoc()) {
                $revenueData[] = [$row['month'], (float)$row['total_pricing']];
            }

            // Fetch month-wise data for tours
            $tourResult = $conn->query("
            SELECT 
                DATE_FORMAT(date_of_journey, '%Y-%m') AS month,
                COUNT(CASE WHEN booking_status = 'confirmed' THEN 1 END) AS confirmed_tours,
                COUNT(*) AS total_tours
            FROM 
                invoice_data
            GROUP BY 
                month
            ORDER BY 
                month ASC
        ");

            $tourData = [];
            while ($row = $tourResult->fetch_assoc()) {
                $tourData[] = [$row['month'], (int)$row['confirmed_tours'], (int)$row['total_tours']];
            }
            $conn->close();
            ?>
        </div>
    </section>

    <script>
        // Load Google Charts
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(drawCharts);

        // PHP data to JavaScript
        const revenueChartData = <?php echo json_encode($revenueData); ?>;
        const tourChartData = <?php echo json_encode($tourData); ?>;

        function drawCharts() {
            drawRevenueChart();
            drawTourChart();
        }

        function drawRevenueChart() {
            // Prepare data for the revenue chart
            const data = new google.visualization.DataTable();
            data.addColumn('string', 'Month');
            data.addColumn('number', 'Total Pricing');
            data.addRows(revenueChartData);

            // Chart options
            const options = {
                title: 'Month-wise Revenue',
                width: '100%',
                height: 400,
                hAxis: { title: 'Month' },
                vAxis: { title: 'Revenue' },
                legend: 'none',
                colors: ['#4285F4'],
            };

            // Draw the revenue chart
            const chart = new google.visualization.ColumnChart(document.getElementById('revenue_chart_div'));
            chart.draw(data, options);
        }

        function drawTourChart() {
            // Prepare data for the tour bar chart
            const data = new google.visualization.DataTable();
            data.addColumn('string', 'Month');
            data.addColumn('number', 'Confirmed Tours');
            data.addColumn('number', 'Total Tours');
            data.addRows(tourChartData);

            // Chart options
            const options = {
                title: 'Month-wise Tours (Confirmed vs Total)',
                width: '100%',
                height: 400,
                hAxis: { title: 'Month' },
                vAxis: { title: 'Number of Tours' },
                legend: { position: 'top', alignment: 'center' },
                bar: { groupWidth: '50%' },
                colors: ['#34A853', '#EA4335']
            };

            // Draw the tour bar chart
            const chart = new google.visualization.ColumnChart(document.getElementById('tour_chart_div'));
            chart.draw(data, options);
        }

        // Function to update charts based on date range
        function updateCharts() {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (startDate && endDate) {
                const filteredRevenueData = revenueChartData.filter(row => {
                    const month = row[0];
                    return month >= startDate && month <= endDate;
                });

                const filteredTourData = tourChartData.filter(row => {
                    const month = row[0];
                    return month >= startDate && month <= endDate;
                });

                // Update the charts with the filtered data
                drawChartWithData(filteredRevenueData, 'revenue_chart_div');
                drawChartWithData(filteredTourData, 'tour_chart_div');
            } else {
                alert('Please select both start and end date');
            }
        }

        // Draw the chart with given data
        function drawChartWithData(chartData, chartDivId) {
            const data = new google.visualization.DataTable();
            data.addColumn('string', 'Month');
            data.addColumn('number', 'Total Pricing');
            data.addRows(chartData);

            const options = {
                title: 'Month-wise Revenue',
                width: '100%',
                height: 400,
                hAxis: { title: 'Month' },
                vAxis: { title: 'Revenue' },
                legend: 'none',
                colors: ['#4285F4']
            };

            if (chartDivId === 'tour_chart_div') {
                options.title = 'Month-wise Tours (Confirmed vs Total)';
                options.colors = ['#34A853', '#EA4335'];
                options.bar = { groupWidth: '50%' };
                options.vAxis.title = 'Number of Tours';
                data.addColumn('number', 'Confirmed Tours');
                data.addColumn('number', 'Total Tours');
            }

            const chart = new google.visualization.ColumnChart(document.getElementById(chartDivId));
            chart.draw(data, options);
        }
    </script>
</body>

</html>
