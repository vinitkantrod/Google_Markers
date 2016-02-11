
<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title></title>
    <script src="https://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer_compiled.js" type="text/javascript"></script>
    <script src="https://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js" type="text/javascript"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKxNZMw0NfyqXpl8FgVVfGSKVR82LJ3V4" type="text/javascript"></script>
    <style>

    .dispatcher{

    }
    .nav-tabs-fillup li{
        display: none;
    }
    .header{
        display: none;

    }

    html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px;
        overflow: hidden;
    }

    #map-canvas {
        margin: 0;
        padding: 0;
        height: 750px;
        border: 1px solid #ccc;
        width: 100%;
        /*display: none;*/

    }

    #headerpart{
        display: none;
    }
    .nav-tabs-fillup li {
        margin-top: 0px !important;
    }
    .datepicker{z-index:1151 !important;}
    #map_canvas {display:none;}

</style>
<style>
    .panel-controls{
        display: none;
    }

    .mapplic-map{
        position: relative !important;
    }
    #circle {
        width: 28px;
        height: 28px;
        background: #9BCA3E;
        -moz-border-radius: 50px;
        -webkit-border-radius: 50px;
        border-radius: 50px;
        position: absolute;
        margin-left: 15%;
        z-index: 100;
        display: none;
    }
    .nav-tabs-fillup li{
        margin-top: 17px;
    }

</style>
    <script type="text/javascript">
    //<![CDATA[
  var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
var labelIndex = 0;
  var clusters = [];
  var flag = 0;
    var customIcons = {
      6: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png'
      },
      7: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_yellow.png'
      },
      8: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png'
      },
      0: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_green.png'
      },   
      1: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_black.png'
      },
    4: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_black.png'
      },
      5: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png'
      }
    };

    function load() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(12.9100,77.6400),
        zoom: 11,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });
      var infoWindow = new google.maps.InfoWindow;
    var mcOptions = {gridSize: 50, maxZoom: 15};
      

      // Change this depending on the name of your PHP file
      downloadUrl("test.php", function(data) {
        var xml = data.responseXML;
              //------------ Permanent Markers (This should be visible always if any)--------
        var setmarker = xml.documentElement.getElementsByTagName("setMarker");
        for (var j = 0; j < setmarker.length; j++){
          var markerPoint = new google.maps.LatLng(
              parseFloat(setmarker[j].getAttribute("mlat")),
              parseFloat(setmarker[j].getAttribute("mlng")));
  
               
            var marker = new google.maps.Marker({
            map: map,
            position: markerPoint,
            label: labels[labelIndex++ % labels.length]
            //icon: icon.icon
          });
          
           var m_circle = new google.maps.Circle({
               center: markerPoint,
               map: map,
               radius: 250,
               fillColor: '#ff00ff',
               strokeWeight: 0 
           });          

        //  clusters.push(marker);
        }


        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
      var driverId = markers[i].getAttribute("driverId")
          var name = markers[i].getAttribute("name");
          var email = markers[i].getAttribute("email");
      var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var status = markers[i].getAttribute("status");
          var bookingStatus = parseInt(markers[i].getAttribute("bookingStatus"));
          var html = "<b>" + driverId + "</b> <br/>" + name + "</b> <br/>" + email;
          
      if(status == 1){
        var icon = customIcons[status] || {}; 
        flag = 1;
      }
      else if(status == 3 || status == 5){
        flag = 1;
        var icon = customIcons[bookingStatus] || {};  
      }
      else{
        flag = 0;
        var icon = customIcons['4'] || {}; 
      }
      
      
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });
          
          clusters.push(marker);
      bindInfoWindow(marker, map, infoWindow, html);
        }
        var markerCluster = new MarkerClusterer(map, clusters, mcOptions);
      });
      
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}
  
 

  </script>

  </head>

  <body onload="load()">
  <div class="col-md-12">
    
    <div class="col-md-9">

        

        <div class="col-md-8" style="height: 32px;">
            <input type="text" style="background: green;width: 20px;border:none;border-radius: 5px;margin-left: 8px;cursor: pointer" readonly="readonly" onclick="toolcliked(1)"> Available
            <input type="text" style="background: blue;width: 20px;border:none;border-radius: 5px;margin-left: 8px;cursor: pointer" readonly="readonly" onclick="toolcliked(2)"> On the way
            <input type="text" style="background: yellow;width: 20px;border:none;border-radius: 5px;margin-left: 8px;cursor: pointer" readonly="readonly" onclick="toolcliked(3)"> Arrived
            <input type="text" style="background: red;width: 20px;border:none;border-radius: 5px;margin-left: 8px;cursor: pointer" readonly="readonly" onclick="toolcliked(4)"> Started
        </div>
    </div>

    <div class="pull-right">
        <div class="btn-group btn-group-vertical" data-toggle="buttons-radio" id="dynamic_driver_display">



        </div>


    </div>
    <div id="map" style="width: 100% ; height: 600px">
    
    </div>
    
   
    
  </body>

</html>
