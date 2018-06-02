<?php

class AdService
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function get($position)
    {
        $query = "select * from ads where position = " . $position . " order by id desc";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $ad = $stmt->fetch();
        return $ad;
    }

    public function find($id)
    {
        $query = "select * from ads where id = " . $id;
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $ad = $stmt->fetch();
        return $ad;
    }

    public function insert($data)
    {
        $content = $data["content"];
        $position = $data["position"];

        $query = "insert into ads (content, position) values ("
            . "N'" . $content . "', " . $position . ")";

        $result = $this->db->exec($query);
        return empty($result) ? false : true;
    }

    public function delete($id)
    {
        $query = "delete from ads where id = " . $id;
        $result = $this->db->exec($query);

        return empty($result) ? false : true;
    }

    public function update($id, $columns)
    {
        $sql = "update ads set ";

        if (!empty($columns["content"]))
            $sql .= "content = N'" . $columns["content"] . "',";
        if (!empty($columns["position"]))
            $sql .= "position = " . $columns["position"] . ",";

        $sql = substr(trim($sql), 0, strlen($sql) - 1) . " where id = '" . $id . "'";
        $result = $this->db->exec($sql);
        return empty($result) ? false : true;
    }

    public function all($page, $pageSize)
    {
        $sql = "select * from ads"
            . " order by id desc "
            . " limit " . $pageSize . " offset " . (($page - 1) * $pageSize);

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = array();
        while ($row = $stmt->fetch()) {
            array_push($result, $row);
        }

        //get count
        $query = "select count(*) as count from ads";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $countResult = $stmt->fetch();

        return array(
            "ads" => $result,
            "count" => $countResult["count"]
        );
    }

}

?>