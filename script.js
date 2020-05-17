	var map; //объект самой карты
	var isFromYou=true; //проверка что выбран инпут откуда
	var isWhereYou=false; //проверка что выбран инпут куда
	var fromYou; //координаты откуда
	var whereYou; //координаты куда
	var poly;
	function initialize() {
		var mapOptions = {
			zoom: 8,
			center: new google.maps.LatLng(56, 37)
		};
		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		var lineSymbol = {
		 path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
		};
		google.maps.event.addListener(map, 'click', function(event) {
			var geocoder = new google.maps.Geocoder();
			geocoder.geocode({latLng:event.latLng}, function (results, status) {
			 if (status == 'OK' && results.length > 0) {
			  var address = results[0].formatted_address;
			  if (isFromYou){
				document.getElementById('input_of_from').value=address;
				var tmps=event.latLng.toString();
				document.getElementById('latit').value=tmps.slice(1,tmps.length-2);
			  } else if (isWhereYou){
				  document.getElementById('input_of_where').value=address;
				  var tmps=event.latLng.toString();
				  document.getElementById('lang').value=tmps.slice(1,tmps.length-2);
			  }
			 }else{
			  console.log("Адрес не найден");
			 }
			});
			
		});
		
	}
	document.getElementById('input_of_from').addEventListener('click',function(){ isFromYou=true; isWhereYou=false;});
	document.getElementById('input_of_where').addEventListener('click',function(){ isFromYou=false; isWhereYou=true;});
	document.getElementById('checkCal').addEventListener('click',function(){ 
		if (this.checked==true){
			var node = document.getElementById("calendarwhere");
			if (node.parentNode) {
				node.parentNode.removeChild(node);
				document.getElementById("placeInput").innerHTML="";
				}
		} else {
			var elem = document.createElement("input");
			elem.type = "date";
			elem.name="checkCal"; 
			elem.id='calendarwhere'; 
			elem.className="dateCl";
			elem.style="height: 4%;width: 20%;";
			document.getElementById("placeInput").innerHTML="Обратно:";
			document.getElementById("placeInput").appendChild(elem);
		}
	  });
	//google.maps.event.addDomListener(window, 'load', initialize);