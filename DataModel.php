<?php
require_once "Database.php";


class DataModel
{
    public function __construct()
    {
        $this->db = Database::getInstance();
    }


    /**
     * This function returns rent out quantity of the given equipment item in the passed time frame
     * @param int $equipment_id
     * @param DateTime $start
     * @param DateTime $end
     * @return mixed
     * @throws Exception
     */
    public function getRentOutQuantity(int $equipment_id, DateTime $start, DateTime $end)
    {
        $sql = 'SELECT  SUM(`quantity`) AS rent_out_qty 
                FROM `planning` 
                WHERE `start` <= :end
                AND `end` > :start
                AND `equipment`=:equipment_id 
                GROUP BY `equipment`';
        $params = ['start' => $start->format('Y-m-d'), 'end' => $end->format('Y-m-d'), 'equipment_id' => $equipment_id];
        $result = $this->db->selectRow($sql, $params);
        if (count($result)) {
            return $result['rent_out_qty'];
        }
    }

    /**
     * This function returns stock quantity of the given equipment item
     * @param int $equipment_id
     * @return mixed
     * @throws Exception
     */
    public function getEquipmentStock(int $equipment_id)
    {
        $sql = 'SELECT `stock` 
                FROM `equipment`
                WHERE `id`=:equipment_id';
        $params = ['equipment_id' => $equipment_id];
        $result = $this->db->selectRow($sql, $params);
        if (count($result)) {
            return $result['stock'];
        }
    }


    /**
     * This function returns stock shortages for passed time frame.
     * @param DateTime $start
     * @param DateTime $end
     * @return array
     * @throws Exception
     */
    public function getShortages(DateTime $start, DateTime $end): array
    {
        $sql = 'SELECT E.id, E.stock, (E.stock - SUM(P.quantity)) AS shortage
                FROM `equipment` E
                INNER JOIN planning P ON E.id = P.equipment
                WHERE `start` <= :end
                AND `end` > :start
                GROUP BY E.id
                HAVING E.stock < SUM(P.quantity)';
        $params = ['start' => $start->format('Y-m-d'), 'end' => $end->format('Y-m-d')];
        $result = $this->db->select($sql, $params);

        if (count($result)) {
            return $result;
        }
    }
}