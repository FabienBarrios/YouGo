function initialize() {
    var input = document.getElementById('venue_name');
    var options = {
        types: ['establishment']
    };
    var autocomplete = new google.maps.places.Autocomplete(input, options);

    autocomplete.addListener('place_changed', function() {

        var place = autocomplete.getPlace();

        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }
        $("#venue_name").val(place.name);
        $("#venue_address").val(address);

    });
}

google.maps.event.addDomListener(window, 'load', initialize);