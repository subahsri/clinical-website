<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// DB connection
$servername = "localhost";
$username = "root";
$password = "suba";
$dbname = "hospital_bd";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $age = intval($_POST['age']);
    $gmail = filter_var($_POST['gmail'], FILTER_SANITIZE_EMAIL);
    $symptoms = $_POST['symptoms'];
    $current_medication = $_POST['current_medication'];
    $previous_medication = $_POST['previous_medication'];
    $hospital_name = $_POST['hospital_name'];
    $last_checkup = !empty($_POST['last_checkup']) ? $_POST['last_checkup'] : null;

    $appointment_booked = isset($_POST['appointment_booked']) ? 1 : 0;
    $appointment_date = $appointment_booked ? $_POST['appointment_date'] : null;

    $sql = "INSERT INTO patient_report 
            (age, gmail, symptoms, current_medication, previous_medication, hospital_name, last_checkup, appointment_booked, appointment_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssis", 
        $age, 
        $gmail, 
        $symptoms, 
        $current_medication, 
        $previous_medication, 
        $hospital_name, 
        $last_checkup, 
        $appointment_booked, 
        $appointment_date
    );

    if ($stmt->execute()) {
        echo "<script>alert('Report Submitted Successfully'); window.location='history.html';</script>";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
