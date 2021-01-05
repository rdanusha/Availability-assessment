<?php
require_once "EquipmentAvailabilityHelper.php";

if (isset($_GET['start']) && !empty($_GET['start']) &&
    isset($_GET['end']) && !empty($_GET['end'])) {

    $start = new  DateTime($_GET['start']);
    $end = new  DateTime($_GET['end']);

    $equipment_helper = new EquipmentAvailabilityHelper();
    $result = $equipment_helper->getShortages($start, $end);
    var_dump($result);

} else {
    echo 'Invalid data input';
}

