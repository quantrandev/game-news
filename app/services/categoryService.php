<?php

class CategoryService
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function all()
    {
        $query = "select * from categories order by position";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $categories = array();
        while ($row = $stmt->fetch()) {
            array_push($categories, $row);
        }
        return $categories;
    }

}

?>