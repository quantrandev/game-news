<?php

class NewsService
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

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
}

?>