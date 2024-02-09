<?php
// Database configuration
$host = "localhost";
$username = "root"; // Ganti dengan username yang sesuai
$password = ""; // Ganti dengan password yang sesuai
$database_name = "siakadstite2";

// Get connection object and set the charset
$conn = new mysqli($host, $username, $password, $database_name);

// Check connection
if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}

$conn->set_charset("utf8");

// Function to escape strings and prevent SQL injection
function escapeString($conn, $value) {
    return $conn->real_escape_string($value);
}

// Get All Table Names From the Database
$tables = array();
$sql = "SHOW TABLES";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }
}

$sqlScript = "";
foreach ($tables as $table) {
    // Prepare SQL script for creating table structure
    $query = "SHOW CREATE TABLE $table";
    $result = $conn->query($query);
    
    if ($result) {
        $row = $result->fetch_row();
        $sqlScript .= "\n\n" . $row[1] . ";\n\n";
    }
    
    // Prepare SQL script for dumping data for each table
    $query = "SELECT * FROM $table";
    $result = $conn->query($query);
    
    if ($result) {
        $columnCount = $result->field_count;
        
        while ($row = $result->fetch_row()) {
            $sqlScript .= "INSERT INTO $table VALUES(";
            for ($j = 0; $j < $columnCount; $j++) {
                $row[$j] = escapeString($conn, $row[$j]);
                if (isset($row[$j])) {
                    $sqlScript .= '"' . $row[$j] . '"';
                } else {
                    $sqlScript .= '""';
                }
                if ($j < ($columnCount - 1)) {
                    $sqlScript .= ',';
                }
            }
            $sqlScript .= ");\n";
        }
    }
    
    $sqlScript .= "\n";
}

if (!empty($sqlScript)) {
    // Save the SQL script to a backup file
    $backup_file_name = $database_name . '_backup_' . time() . '.sql';
    $fileHandler = fopen($backup_file_name, 'w+');
    $number_of_lines = fwrite($fileHandler, $sqlScript);
    fclose($fileHandler); 

    // Download the SQL backup file to the browser
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($backup_file_name));
    ob_clean();
    flush();
    readfile($backup_file_name);
    unlink($backup_file_name); // Remove the backup file from the server after download
}

// ...

// Get All Table Names From the Database
$tables = array();
$sql = "SHOW TABLES";
$result = $conn->query($sql);

if (!$result) {
    die("Error mengambil nama-nama tabel: " . $conn->error);
}

while ($row = $result->fetch_row()) {
    $tables[] = $row[0];
}                                                                                           

// ...

?>
