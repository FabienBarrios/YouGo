<?php
include "../functions.php";

$tab_data_venue_bestime = json_decode($_POST['json'], true);
$venue_id = $_POST['venue_id'];

$competur = 0;
foreach ($tab_data_venue_bestime['venue_info']['venue_types'] as $data){
    add_venue_type($venue_id, $data);
}
foreach ($tab_data_venue_bestime['analysis'] as $data){
        foreach ($data['hour_analysis'] as $data2){
            if($competur == 23){
                $competur=0;
            }
            $competur++;
            add_hours_analysis($venue_id, $data2['hour'], $data['day_raw'][$competur], $data2['intensity_txt'], $data['day_info']['day_int']);
        }
}

