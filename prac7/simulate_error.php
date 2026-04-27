<?php
require('extended_error_handler.php');
echo "<h2>Error Simulation</h2>";
echo "Undefined Variable Test:<br>";
echo $nonexistentVariable;
echo "<br>Division-by-Zero Test:<br>";
$result = 10 / 0;
echo "<br>File Include Test:<br>";
include("non_existing_file.php");
echo "<br>Manual Exception Test:<br>";
throw new Exception("This is a test exception thrown manually.");
echo "<br>End of simulation.";
?>