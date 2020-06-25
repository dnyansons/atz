<button id="find_btn">Find Me</button>
<div id="result"></div>

<div>
    <form><strong>Enter Zipcode:</strong><br> <input id="zip_code" type="text" autocomplete="off"><strong>City:</strong><br> <input id="city" style="background-color: #efefef;" disabled="disabled" type="text"><br> <strong>State:</strong><br> <input id="state" style="background-color: #efefef;" disabled="disabled" type="text"></form>
    Latitude:<input type="text" id="kkzip_code"><br><br>
    Longitude:<input type="text" id="longitude"><br>
    <br>
    <input type="button" value="Get Location" 

           onclick="getLocationDetails()"></button>
    <br><br>
    <label id="val"></label>
    <label id="city"></label>
    <label id="state"></label>
</div>
<div id="messageBox" 

     style="position:fixed;top:30%;left:30%;
     width:200px;height:100px;border-radius:15px;text-align:center;
     background-color:skyblue;
     ">
    <div style="position:absolute;margin-top:0px;left:2px;
         height:20px;width:98%;border-radius:5px;overflow:hidden;
         background-color:pink; 
         "><label id="title" style="
             color:blue;">Skin Advisor</label></div>
    <div style="position:absolute;margin:2px;top:25px;height:80px;width:100%;">
        <label id="message" style="
               color:blue;font-family:Helvetica;"></label></div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$( document ).ready(function() {
    $.support.cors = true;
    $.ajaxSetup({ cache: false });
    var city = '';
    var hascity = 0;
    var hassub = 0;
    var state = '';
    var nbhd = '';
    var subloc = '';
	
    $('#zip_code').keyup(function() {
      $zval = $('#zip_code').val();
     console.log($zval);
      if($zval.length == 6){
         $jCSval = getCityState($zval, true); 
      }
    });

    
  function getCityState($zip, $blnUSA) {
            
	 var date = new Date();
	 $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=' + $zip + '&key=AIzaSyBkN0wRthzWGnY1ppnijgRhqVwkjY03Eko&type=json&_=' + date.getTime(), function(response){
         //find the city and state
        
	 var address_components = response.results[0].address_components;
         console.log(address_components);
	 $.each(address_components, function(index, component){
		 var types = component.types;
		 $.each(types, function(index, type){
			if(type == 'administrative_area_level_2') {
			  city = component.long_name;
			  hascity = 1;
			}
			if(type == 'administrative_area_level_1') {
			  state = component.long_name;
			}
			if(type == 'neighborhood') {
			  nbhd = component.long_name;
			}
			if(type == 'sublocality') {
			  subloc = component.long_name;
			  hassub = 1;
			}
		 });
	});

	//pre-fill the city and state
        
        if(hascity == 1){
			$('#city').val(city);
        } else if(hassub == 1) {
            $('#city').val(subloc);
        } else {
	    $('#city').val(nbhd);
	}
	$('#state').val(state);
	  //reset
	var hascity = 0;
	var hassub = 0;
    });
  }
});
</script>
<script>
    $("#find_btn").click(function () { //user clicks button
    if ("geolocation" in navigator){ //check geolocation available 
    //try to get user current location using getCurrentPosition() method
    navigator.geolocation.getCurrentPosition(function(position){ 
    $("#result").html("Found your location <br />Lat : "+position.coords.latitude+" </br>Lang :"+ position.coords.longitude);
    });
    }else{
    console.log("Browser doesn't support geolocation!");
    }
    });

    ////////////////////////////////////////////////////////////////////////////////
   var country, state, city, pinCode, address1, address12, address3;

function createCORSRequest(method, url) {
	var xhr = new XMLHttpRequest();

	if ("withCredentials" in xhr) {
		// XHR for Chrome/Firefox/Opera/Safari.
		xhr.open(method, url, true);

	} else if (typeof XDomainRequest != "undefined") {
		// XDomainRequest for IE.
		xhr = new XDomainRequest();
		xhr.open(method, url);

	} else {
		// CORS not supported.
		xhr = null;
	}
	return xhr;
}

function getLocationDetails() {
	if ("geolocation" in navigator) { //check geolocation available 

		navigator.geolocation.getCurrentPosition(function (position) {

			$("#result").html("Found your location <br />Lat : " + position.coords.latitude + " </br>Lang :" + position.coords.longitude);
			latitude1 = position.coords.latitude;
			longitude1 = position.coords.longitude;
			alert(latitude1 + ' ' + longitude1);
                        //latitude1=position.coords.latitude;
	//longitude1=position.coords.longitude;
	var url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" +
		latitude1 + "," + longitude1 + "&sensor=true" + "&key=AIzaSyBkN0wRthzWGnY1ppnijgRhqVwkjY03Eko";
	var xhr = createCORSRequest('POST', url);
	if (!xhr) {
		alert('CORS not supported');
	}

	xhr.onload = function () {

		var data = JSON.parse(xhr.responseText);
		console.log(data);
		if (data.results.length > 0) {

			var locationDetails = data.results[0].formatted_address;
			var value = locationDetails.split(",");

			count = value.length;

			address3 = value[count - 7];
			address2 = value[count - 6];
			address1 = value[count - 5];
			country = value[count - 1];
			state = value[count - 2];
			city = value[count - 3];
			pin = state.split(" ");
			pinCode = pin[pin.length - 1];
			state = state.replace(pinCode, ' ');
			document.getElementById("val").innerHTML = country +
				" | " + state + " | " + address1 + "|" + address2 + "|" + address3 + "|" + pinCode;
		} else {
			document.getElementById("messageBox").style.visibility = "visible";
			document.getElementById("message").innerHTML =
				"No location available for provided details.";
		}

	};

	xhr.onerror = function () {
		alert('Woops, there was an error making the request.');

	};
	xhr.send();
		});


	} else {
		console.log("Browser doesn't support geolocation!");
	}


	

}
</script>
