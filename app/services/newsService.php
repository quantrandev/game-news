<?php

class NewsService
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    //read
    public function all($offset, $take)
    {
        $query = "select * from news order by id desc limit " . $take . " offset " . $offset;
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $news = array();
        while ($row = $stmt->fetch()) {
            array_push($news, $row);
        }

        return $news;
    }

    public function get($id)
    {
        $query = "select * from news where id = " . $id;
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $news = $stmt->fetch();
        return $news;
    }

    public function getWithCategory($offset, $take, $category)
    {
        $query = "select * from news where categoryId = " . $category . " order by createdAt desc limit " . $take . " offset " . $offset;
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $news = array();
        while ($row = $stmt->fetch()) {
            array_push($news, $row);
        }

        return $news;
    }

    public function getByCategoryWithPaging($page, $pageSize, $category)
    {
        $query = "select * from news where categoryId = " . $category . " order by createdAt desc " .
            "limit " . $pageSize . " offset " . (($page - 1) * $pageSize);
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $news = array();
        while ($row = $stmt->fetch()) {
            array_push($news, $row);
        }

        $query = "select count(*) as count from news where categoryId = " . $category;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $countResult = $stmt->fetch();

        return array(
            "news" => $news,
            "count" => $countResult["count"]
        );
    }

    public function mostViews($offset, $take)
    {
        $query = "select * from news order by views desc limit " . $take . " offset " . $offset;
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $news = array();
        while ($row = $stmt->fetch()) {
            array_push($news, $row);
        }

        return $news;
    }

    //update
    public function update($id, $columns)
    {
        $sql = "update news set ";

        if (!empty($columns["categoryId"]))
            $sql .= "categoryId = " . $columns["categoryId"] . ",";
        if (!empty($columns["name"]))
            $sql .= "name = N'" . $columns["name"] . "',";
        if (!empty($columns["basicPrice"]))
            $sql .= "basicPrice = " . $columns["basicPrice"] . ",";
        if (!empty($columns["description"]))
            $sql .= "description = '" . $columns["description"] . "',";

        $sql = substr(trim($sql), 0, strlen($sql) - 1) . " where id = '" . $id . "'";
        $result = $this->db->exec($sql);
        return empty($result) ? false : true;
    }

    public function view($id)
    {
        //get views
        $query = "select views from news where id = " . $id;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();

        //update views
        $query = "update news set views = " . (intval($result["views"]) + 1) . " where id = " . $id;
        $this->db->exec($query);
    }

    //create
    public function insert($data)
    {
        $title = $data["title"];
        $summary = $data["summary"];
        $image = $data["image"];
        $categoryId = $data["categoryId"];
        $content = $data["content"];
        $author = $data["author"];
        $createdAt = $data["createdAt"];

        $query = "insert into news (title, image, summary, categoryId, content, author, createdAt) values ("
            . "N'" . $title . "', '" . $image . "', N'" . $summary . "', " . $categoryId . ",N'" . $content . "', N'" . $author . "', '" . $createdAt . "')";

        $result = $this->db->exec($query);
        return empty($result) ? false : true;
    }
}

?>