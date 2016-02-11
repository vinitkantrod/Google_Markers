<?php 
function generateAddressFromLatLng($lat, $lng){

    $geolocation = $lat.','.$lng;
    $request = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.$geolocation.'&sensor=false'; 

    $file_contents = file_get_contents($request);
    $json_decode = json_decode($file_contents);

    if(isset($json_decode->results[0])) {

        $response = array();

        foreach($json_decode->results[0]->address_components as $addressComponet) {
            if(in_array('political', $addressComponet->types)) {
                    $response[] = $addressComponet->long_name; 
        //            echo $response;
            }
        }

        // if(isset($response[0])){ $first  =  $response[0];  } else { $first  = 'null'; }
        // if(isset($response[1])){ $second =  $response[1];  } else { $second = 'null'; } 
        // if(isset($response[2])){ $third  =  $response[2];  } else { $third  = 'null'; }
        if(isset($response[3])){ $fourth =  $response[3];  } else { $fourth = 'null'; }
        //if(isset($response[4])){ $fifth  =  $response[4];  } else { $fifth  = 'null'; }
        //echo $fourth;
        //return array('city' => $fourth);
        return $fourth;
      }
}

$lat = 12.9667;
$lng = 77.5667;
echo generateAddressFromLatLng($lat, $lng);
?>