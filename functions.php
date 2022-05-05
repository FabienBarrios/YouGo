<script>


    function fullDataApi(){
        let tab;

        const params = new URLSearchParams({
            'api_key_private': 'pri_1acc048030e44dd5a8d29359720c5e5a',
            'venue_name': 'Novela',
            'venue_address': '662 Mission St San Francisco, CA 94105 United States'
        });

        fetch(`https://besttime.app/api/v1/forecasts?${params}`, {
            method: 'POST'
        }).then(response => {
            return response.json();
        }).then(data => {
            tab = data;
            return console.log(tab);
        });


    }
    a = fullDataApi()
    console.log(a);

</script>
