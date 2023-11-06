<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login_page.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cashier_page.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Daily Reports</title>
</head>
<body>
<!-- <header>
    <h1>Cashier</h1>
</header>

<nav class="navbar">
    <div class="nav-links">
        <a href="cashier.php">Queue</a>
        <a href="daily_reports.php">Daily Reports</a>
    </div>
    <a href="logout.php">Logout</a>
</nav> -->

<?php include('navbar-cashier.php'); ?>
    <div class="container">
        <h2>Daily Reports</h2>
    <div class="report-table-container">
    </div>
        <div>
            <form method="post">
                <button type="button" onclick="exportToExcel()">Export to Excel</button>
                <button onclick="printData()">Print</button>
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Search by Customer Name">
                    <button type="button" id="searchButton" onclick="searchData()">Search</button>
                </div>
            </form>
        </div>
        

        <?php
        // Database connection configuration
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "queuing_system";

        // Create a connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // SQL query to fetch data from your table
        $sql = "SELECT * FROM queue_data";
        $result = $conn->query($sql);
        
        if ($result !== false && $result->num_rows > 0) {
            echo '<div class="table-container">'; // Add this line
            echo "<table>";
            echo "<tr><th>Customer Type</th><th>Service</th><th>Payment for</th><th>Mode of Payment</th><th>Customer Name</th><th>Status</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["customer_type"] . "</td>";
                echo "<td>" . $row["choose_service"] . "</td>";
                echo "<td>" . $row["payment_for"] . "</td>";
                echo "<td>" . $row["mode_of_payment"] . "</td>";
                echo "<td>" . $row["customer_name"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                
              
                echo "</tr>";
            }
            echo "</table>";
            echo '</div>'; // Close the div here
            echo "</table>";
        } else {
            echo '<p style="text-align: center; margin-top: 2rem; font-size: 18px; color: #555;">No records found.</p>';
        }
        
        ?>
        
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
    <script>
        document.getElementById('searchInput').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault(); // Prevent the default form submission
        searchData(); // Call your search function
    }
});

      function searchData() {
        // Get the search input value
        var searchValue = document.getElementById("searchInput").value;

        // Send an AJAX request to search for data
        fetch('search.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `searchValue=${searchValue}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Display the search results in the table
                displaySearchResults(data.results);
            } else {
                alert('No records found.');
            }
        });
    }

    // Function to display search results in the table
    function displaySearchResults(results) {
        var table = document.querySelector("table");
        // Clear existing table rows
        while (table.rows.length > 1) {
            table.deleteRow(1);
        }
        
        // Add search results to the table
        for (var i = 0; i < results.length; i++) {
            var row = table.insertRow(i + 1);
            var rowData = results[i];
            for (var j = 0; j < rowData.length; j++) {
                var cell = row.insertCell(j);
                cell.textContent = rowData[j];
            }
        }
    }

        function exportToExcel() {
            // Get table as an array of arrays
            var table = document.querySelector("table");
            var tableData = [];
            for (var i = 0, row; row = table.rows[i]; i++) {
                var rowData = [];
                for (var j = 0, col; col = row.cells[j]; j++) {
                    rowData.push(col.textContent.trim());
                }
                tableData.push(rowData);
            }

            // Create a worksheet and populate it
            var ws = XLSX.utils.aoa_to_sheet(tableData);

            // Create a workbook and add the worksheet
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

            // Save the workbook as an XLSX file
            XLSX.writeFile(wb, 'daily_reports.xlsx');
        }

        function printData() {
            // Open a new window for printing
            let printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.open();
            printWindow.document.write('<html><head><title>Print</title></head><body>');

            // Append the table with print-specific styles
            printWindow.document.write('<style>@media print { table { width: 100%; border-collapse: collapse; margin: 0; border: 1px solid #ddd; } th, td { border: 1px solid #ddd; padding: 8px; text-align: left; } th { background-color: #f2f2f2; } }</style>');
            printWindow.document.write(document.querySelector('table').outerHTML);

            // Close the print window
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        }
    </script>
</body>
</html>
