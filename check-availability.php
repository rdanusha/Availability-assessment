<?php
require_once "EquipmentAvailabilityHelper.php";

if (isset($_GET['equipment-id']) && !empty($_GET['equipment-id']) &&
    isset($_GET['qty']) && !empty($_GET['qty']) &&
    isset($_GET['start']) && !empty($_GET['start']) &&
    isset($_GET['end']) && !empty($_GET['end'])) {

    $equipment_id = (int)$_GET['equipment-id'];
    $quantity = (int)$_GET['qty'];
    $start = new  DateTime($_GET['start']);
    $end = new  DateTime($_GET['end']);

    $equipment_helper = new EquipmentAvailabilityHelper();
    $result = $equipment_helper->isAvailable($equipment_id, $quantity, $start, $end);
    var_dump($result);

} else {
    echo 'Invalid data input';
}

