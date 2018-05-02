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
        $query = "select * from news where isActive = 1 order by id desc limit " . $take . " offset " . $offset;
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
        $query = "select * from news where categoryId = " . $category . " and isActive = 1 order by createdAt desc limit " . $take . " offset " . $offset;
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
        $query = "select * from news where categoryId = " . $category . " and isActive = 1 order by createdAt desc " .
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

    public function search($page, $pageSize, $condition)
    {
        $categoryQuery = $this->buildCategoryQuery($condition);
        $titleQuery = $this->buildTitleQuery($condition);

        $condition = "";
        if (!empty($categoryQuery) || !empty($titleQuery)) {
            $condition .= " where "
                . (empty($titleQuery) ? 'true' : $titleQuery)
                . " and "
                . (empty($categoryQuery) ? 'true' : $categoryQuery);
        } else
            $condition .= "";

        $sql = "select * from news"
            . $condition
            . " limit " . $pageSize . " offset " . (($page - 1) * $pageSize);

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = array();
        while ($row = $stmt->fetch()) {
            array_push($result, $row);
        }

        //get count
        $query = "select count(*) as count from news" . $condition;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $countResult = $stmt->fetch();

        return array(
            "news" => $result,
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

        if (!empty($columns["title"]))
            $sql .= "title = N'" . $columns["title"] . "',";
        if (!empty($columns["summary"]))
            $sql .= "summary = N'" . $columns["summary"] . "',";
        if (!empty($columns["author"]))
            $sql .= "author = N'" . $columns["author"] . "',";
        if (!empty($columns["content"]))
            $sql .= "content = '" . $columns["content"] . "',";
        if (!empty($columns["image"]))
            $sql .= "image = '" . $columns["image"] . "',";
        if (!empty($columns["categoryId"]))
            $sql .= "categoryId = " . $columns["categoryId"] . ",";

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

    //delete
    public function delete($id)
    {
        $query = "delete from news where id = " . $id;
        $result = $this->db->exec($query);
        return empty($result) ? false : true;
    }

    //helpers
    public function buildCategoryQuery($condition)
    {
        if (empty($condition["category"]))
            return "";

        $query = "categoryId = " . $condition["category"];

        return $query;
    }

    public function buildTitleQuery($condition)
    {
        $searchName = isset($condition["title"]) ? $condition["title"] : null;
        if (empty($searchName))
            return '';

        //name
        $nameQuery = "";
        $nameParts = explode(" ", $searchName);
        if (count($nameParts) != 0) {
            foreach ($nameParts as $part) {
                $nameQuery .= "title like N'%" . $part . "%' and ";
            }
            $nameQuery = substr($nameQuery, 0, strlen($nameQuery) - 4);
        }

        return $nameQuery;
    }
}

?>