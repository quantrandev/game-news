<?php

class AdsService
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function all()
    {
        $query = "select * from ads order by id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $ads = array();
        while ($row = $stmt->fetch()) {
            array_push($ads, $row);
        }
        return $ads;
    }

    public function get($id)
    {
        $query = "select * from ads where id = " . $id;
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $ad = $stmt->fetch();
        return $ad;
    }

    public function getByPosition($position)
    {
        $query = "select * from ads where position = " . $position . " order by id desc";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $ad = $stmt->fetch();
        return $ad;
    }

    public function allActive()
    {
        $query = "select * from ads where isActive = 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $ads = array();
        while ($row = $stmt->fetch()) {
            array_push($ads, $row);
        }
        return $ads;
    }

    public function insert($data)
    {
        $content = $data["content"];
        $isActive = $data["isActive"];
        $position = $data["position"];

        $query = "insert into ads (content, isActive, position) values ("
            . "'" . $content . "', " . $isActive . "," . $position . ")";

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
        if ($columns["isActive"] != null)
            $sql .= "isActive = " . $columns["isActive"] . ",";
        if (!empty($columns["position"]))
            $sql .= "position = " . $columns["position"] . ",";

        $sql = substr(trim($sql), 0, strlen($sql) - 1) . " where id = '" . $id . "'";
        $result = $this->db->exec($sql);
        return empty($result) ? false : true;
    }

}

?>