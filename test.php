<?php
include('../Models/ConDB.php');
$db1 = new ConDB();


function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

$location = $db1->mongo->selectCollection('location');
$set_marker = $db1->mongo->selectCollection('markers');

$userData = $location->find();
$usedMarker = $set_marker->find();
header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<markers>';

foreach ($usedMarker as $marked) {
  $mongoid = $marked['_id'];
  $stringId = (string)$mongoid;
  echo '<setMarker ';
  echo 'mlat="' . $marked['latitude'] . '" ';
  echo 'mlng="' . $marked['longitude'] . '" ';
  echo 'id="' . $stringId . '"';
  echo ' />';
}
// Iterate through the rows, printing XML nodes for each
foreach ($userData as $drivers){
	if($drivers['status'] == 3 || $drivers['status'] == 5){
		$riderphonenumberQry = "select mobile from master where mas_id = '" . $drivers['user'] . "'";
		$mobile = mysql_query($riderphonenumberQry, $db1->conn);
  // ADD TO XML DOCUMENT NODE
  echo '<marker ';
  echo 'name="' . parseToXML($drivers['name']) . '" ';
  echo 'email="' . parseToXML($drivers['email']) . '" ';
  echo 'lat="' . $drivers['location']['latitude'] . '" ';
  echo 'lng="' . $drivers['location']['longitude'] . '" ';
  echo 'status="' . $drivers['status'] . '" ';
  echo 'bookingStatus="' . $drivers['apptStatus'] . '" ';
  echo 'driverId="' . $drivers['user'] . '" ';
  echo 'mobile="' . $mobile . '" ';

  echo '/>';
}
}

// End XML file
echo '</markers>';
?>
