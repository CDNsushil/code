<?php 
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="sampleCSV.csv"');
//$path = base_url().'media/csvFile/sampleCSV.csv';
readfile(MEDIAUPLOADPATH.'csvFile/sampleCSV.csv');
?>
