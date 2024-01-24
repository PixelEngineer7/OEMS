<?php
require('../model/pms.php');
session_start();
$database = new DBHandler();

$getPMS = new pms();

$getAll = $getPMS->getPMS($database);





foreach ($getAll as $innerArray) {
    echo "PMS ID: " . $innerArray['pms_id'] . "<br>";
    echo "Employee ID: " . $innerArray['emp_id'] . "<br>";

    // Decode JSON arrays
    $quarterArray = json_decode($innerArray['quarter_array'], true);
    $kpaArray = json_decode($innerArray['kpa_array'], true);
    $kpiArray = json_decode($innerArray['kpi_array'], true);
    $objectiveArray = json_decode($innerArray['objective_array'], true);

    echo "Quarter: " . $quarterArray[0] . "<br>";
    echo "Year: " . $quarterArray[1] . "<br>";

    // Loop through and echo values from other arrays
    for ($i = 0; $i < count($kpaArray); $i++) {
        echo "KPA " . ($i + 1) . ": " . $kpaArray[$i] . "<br>";
        echo "KPI " . ($i + 1) . ": " . $kpiArray[$i] . "<br>";
        echo "Objective " . ($i + 1) . ": " . $objectiveArray[$i] . "<br>";
    }

    echo "<br>";
}
