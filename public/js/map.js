var map;

var myLatLng = {lat: 48.8909964, lng: 2.2345892};

function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 48.8588376, lng: 2.2773461},
    zoom: 12
  });

  var marker = new google.maps.Marker({
    position: myLatLng,
    map: map,
    title: 'hello'
  });
}
