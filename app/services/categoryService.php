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

    public function get($id)
    {
        $query = "select * from categories where id = " . $id;
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $category = $stmt->fetch();
        return $category;
    }

    public function allActive()
    {
        $query = "select * from categories order by position where isActive = 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $categories = array();
        while ($row = $stmt->fetch()) {
            array_push($categories, $row);
        }
        return $categories;
    }

    public function insert($data)
    {
        $name = $data["name"];
        $isActive = $data["isActive"];
        $position = $data["position"];

        $query = "insert into categories (name, isActive, position) values ("
            . "N'" . $name . "', " . $isActive . "," . $position . ")";

        $result = $this->db->exec($query);
        return empty($result) ? false : true;
    }

    public function delete($id)
    {
        $query = "delete from categories where id = " . $id;
        $result = $this->db->exec($query);

        return empty($result) ? false : true;
    }

    public function update($id, $columns)
    {
        $sql = "update categories set ";

        if (!empty($columns["name"]))
            $sql .= "name = N'" . $columns["name"] . "',";
        if (!empty($columns["isActive"]))
            $sql .= "isActive = " . $columns["isActive"] . ",";
        if (!empty($columns["position"]))
            $sql .= "position = " . $columns["position"] . ",";

        $sql = substr(trim($sql), 0, strlen($sql) - 1) . " where id = '" . $id . "'";
        $result = $this->db->exec($sql);
        return empty($result) ? false : true;
    }

}

?>