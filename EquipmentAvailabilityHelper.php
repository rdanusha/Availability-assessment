<?php
require_once "DataModel.php";

class EquipmentAvailabilityHelper
{
    private $data_model;

    /**
     * EquipmentAvailabilityHelper constructor.
     */
    public function __construct()
    {
        $this->data_model = new DataModel();
    }

    /**
     * This function checks if a given quantity is available in the passed time frame
     * @param int $equipment_id Id of the equipment item
     * @param int $quantity How much should be available
     * @param DateTime $start Start of time window
     * @param DateTime $end End of time window
     * @return bool True if available, false otherwise
     */
    public function isAvailable(int $equipment_id, int $quantity, DateTime $start, DateTime $end): bool
    {
        $stock = $this->data_model->getEquipmentStock($equipment_id); //get current stock of the given equipment

        if ($stock < $quantity) { //check current stock with the input quantity
            return false;
        }

        //get all rent out quantities relevant to the given equipment
        $rent_out_qty = $this->data_model->getRentOutQuantity($equipment_id, $start, $end);
        if ($rent_out_qty) {
            $remain_stock = $stock - $rent_out_qty; //calculate remain stock
            if ($remain_stock < $quantity) { //check remain stock with the input quantity
                return false;
            }
        }

        return true;
    }

    /**
     * Calculate all items that are short in the given period
     * @param DateTime $start Start of time window
     * @param DateTime $end End of time window
     * @return array Key/valyue array with as indices the equipment id's and as values the shortages
     */
    public function getShortages(DateTime $start, DateTime $end): array
    {
        //get shortage details
        $result = $this->data_model->getShortages($start, $end);

        if (count($result)) {
            return array_column($result, 'shortage', 'id');
        }
    }

}
