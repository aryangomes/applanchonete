var endereco = 'Porto Alegre - RS';
geocoder = new google.maps.Geocoder();      
geocoder.geocode({'address':endereco}, function(results, status){ 
    if( status = google.maps.GeocoderStatus.OK){
        latlng = results[0].geometry.location;
        markerInicio = new google.maps.Marker({position: latlng,map: map});     
        map.setCenter(latlng); 
    }           
});