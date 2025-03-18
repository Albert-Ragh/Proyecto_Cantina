<?php
class db_testModel extends Model
{
    public function getAllUsers()
    {
        $result = array();
        $sql = "SELECT id, firstname, lastname FROM MyGuest";
        $select = $this->conn->query($sql);
        if ($select->num_rows > 0) {
            // output data of each row
            while ($row = $select->fetch_assoc()) {
                $result[] = $row;
                //echo "id: " . $row["id"] . " - Name: " . $row["firstname"] . " " . $row["lastname"] . "<br>";
            }
        }
        return $result;
    }
}
