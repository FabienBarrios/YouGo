<?php

function connect_API(){
    $pathEC2 = "ec2-54-175-42-87.compute-1.amazonaws.com";
    $prefixe = "http://";
    $port = ":5000";
    return $prefixe.$pathEC2.$port;
}

function heureOuverture($tab){
    $tab_index = [];
    foreach($tab as $key => $value) {
        if($value == 0){
            $tab_index[] = $key;
        }
    }
    return min($tab_index)."h-".(max($tab_index)+1)."h";
}

function get_day_row($tab_horaire){
    $tab = "";
    $compteur = 0;
    foreach ($tab_horaire as $data){
        if ($compteur == 0){
            $tab .= $data['day_row'];
        }else{
            $tab .= ", ".$data['day_row'];
        }
        $compteur++;
    }
    return $tab;
}

function urlparam($chaine){
    $search  = array(' ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
    $replace = array('%20', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
    return str_replace($search, $replace, $chaine);
}

function get_venue_all($address){
    $url_api_yougo = connect_API();
    $url_address = urlparam($address);
    $json = file_get_contents($url_api_yougo."/venue/".$url_address);
    return json_decode($json, true);
}

function get_hour($venue_id, $day){
    $url_api_yougo = connect_API();
    $json = file_get_contents($url_api_yougo."/venue/".$venue_id."/hours?day=".$day);
    return json_decode($json, true);
}

function get_api_bestime($name, $address){?>
    <script>test_api_bestime("<?php echo $name; ?>", "<?php echo $address; ?>");</script>
<?php
}

function get_api_bestime2($venue_id, $name, $address){?>
    <script>test_api_bestime2("<?php echo $venue_id; ?>", "<?php echo $name; ?>", "<?php echo $address; ?>");</script>
    <?php
}

function add_venue($venue_address, $venue_name, $venue_lon, $venue_lat, $venue_timezone){
    $url_api_yougo = connect_API();
    $url_address = urlparam($venue_address);
    $url_name = urlparam($venue_name);
    $url_timezone = urlparam($venue_timezone);
    $url_complet = $url_address."?venue_name=".$url_name."&venue_lon=".$venue_lon."&venue_lat=".$venue_lat."&venue_timezone=".$url_timezone;
    $json = file_get_contents($url_api_yougo."/add/venue/".$url_complet);
    return json_decode($json, true);
}

function add_hours_analysis($venue_id, $hour, $day_row, $intensity_txt, $day_int){
    $url_api_yougo = connect_API();
    $url_complet = $venue_id."?hour=".$hour."&day_row=".$day_row."&intensity_txt=".urlparam($intensity_txt)."&day_int=".$day_int;
    $json = file_get_contents($url_api_yougo."/add/hours_analysis/".str_replace("&amp;", "&", $url_complet));
    return json_decode($json, true);
}

function add_venue_type($venue_id, $venue_tag){
    $url_api_yougo = connect_API();
    $url_complet = $venue_id."?venue_tag=".$venue_tag;
    $json = file_get_contents($url_api_yougo."/add/venue_type/".$url_complet);
    return json_decode($json, true);
}
?>
<script onerror="console.log('Erreur chargement dashboard.js')" onload="console.log('Chargement de dashboard.js réussi')" src="js/dashboard.js"></script>
<script>
    let url_api_bestime = "https://besttime.app/api/v1/"

    function test_api_bestime(name, address){
        let tab;
        let tab_data;

        const params = new URLSearchParams({
            'api_key_private': 'pri_7dbb369a964f46f2988a3210f5a1153d',
            'venue_name': name,
            'venue_address': address
        });

        fetch(url_api_bestime+`forecasts?${params}`, {
            method: 'POST'
        }).then(response => {
            return response.json();
        }).then(data => {
            tab = JSON.stringify(data);
            tab_data = JSON.parse(tab)
            let venue_name = tab_data.venue_info.venue_name;
            let venue_address = address;
            let venue_lon = tab_data.venue_info.venue_lon;
            let venue_lat = tab_data.venue_info.venue_lat;
            let venue_timezone = tab_data.venue_info.venue_timezone;
            let venue_type = tab_data.venue_info.venue_type;
            let venue_id = 1; //retour api

            let tab_values_1 = concactTab(tab_data['analysis'][0]['day_raw']);
            let tab_values_2 = concactTab(tab_data['analysis'][1]['day_raw']);
            let tab_values_3 = concactTab(tab_data['analysis'][2]['day_raw']);
            let tab_values_4 = concactTab(tab_data['analysis'][3]['day_raw']);
            let tab_values_5 = concactTab(tab_data['analysis'][4]['day_raw']);
            let tab_values_6 = concactTab(tab_data['analysis'][5]['day_raw']);
            let tab_values_7 = concactTab(tab_data['analysis'][6]['day_raw']);


            location.href = "./dashboard.php?venue_name=" + venue_name + "&venue_address=" + venue_address + "&venue_lon=" + venue_lon
                + "&venue_lat=" + venue_lat + "&venue_timezone=" + venue_timezone + "&venue_type=" + venue_type
                + "&venue_id=" + venue_id + "&monday=" + tab_values_1 + "&tuesday=" + tab_values_2 + "&wednesday=" + tab_values_3
                + "&thursday=" + tab_values_4 + "&friday=" + tab_values_5 + "&saturday=" + tab_values_6 + "&sunday=" + tab_values_7;

            //console.log(tab);
        });

    }

    function test_api_bestime2(venue_id, name, address){
        let tab;

        const params = new URLSearchParams({
            'api_key_private': 'pri_7dbb369a964f46f2988a3210f5a1153d',
            'venue_name': name,
            'venue_address': address
        });

        fetch(url_api_bestime+`forecasts?${params}`, {
            method: 'POST'
        }).then(response => {
            return response.json();
        }).then(data => {
            tab = JSON.stringify(data);
            console.log(tab);
            $.ajax({
                url : 'AJAX/ajaxApiBesttime.php',
                type : 'POST',
                data : 'json=' + tab +'&venue_id=' + venue_id,
                dataType : 'html',
                success : function(code_html){
                    //console.log(code_html);
                }
            });
        });

    }

    function concactTab(tab){
        let array1 = tab.slice(0,-6);
        let array2 = [];
        for (let i = 19; i < tab.length; i++) {
            array2.push(tab[i]);

        }
        return array2.concat(array1)
    }
</script>
