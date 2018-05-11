<?php

class PostService
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    //read
    public function all($offset, $take)
    {
        $query = "select * from posts where isActive = 1 order by id desc limit " . $take . " offset " . $offset;
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $posts = array();
        while ($row = $stmt->fetch()) {
            array_push($posts, $row);
        }

        return $posts;
    }

    public function newPostCount(){
        $query = "select count(*) as count from posts where isActive = 0";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $countResult = $stmt->fetch();
        return $countResult["count"];
    }

    public function get($id)
    {
        $query = "select * from posts where id = " . $id;
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $posts = $stmt->fetch();
        return $posts;
    }

    public function getWithCategory($offset, $take, $category)
    {
        $query = "select * from posts where categoryId = " . $category . " and isActive = 1 order by createdAt desc limit " . $take . " offset " . $offset;
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $posts = array();
        while ($row = $stmt->fetch()) {
            array_push($posts, $row);
        }

        return $posts;
    }

    public function getByCategoryWithPaging($page, $pageSize, $category)
    {
        $query = "select * from posts where categoryId = " . $category . " and isActive = 1 order by createdAt desc " .
            "limit " . $pageSize . " offset " . (($page - 1) * $pageSize);
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $posts = array();
        while ($row = $stmt->fetch()) {
            array_push($posts, $row);
        }

        $query = "select count(*) as count from posts where categoryId = " . $category;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $countResult = $stmt->fetch();

        return array(
            "posts" => $posts,
            "count" => $countResult["count"]
        );
    }

    public function clientSearch($page, $pageSize, $condition)
    {
        $categoryQuery = $this->buildCategoryQuery($condition);
        $titleQuery = $this->buildTitleQuery($condition);
        $condition = "";
        if (!empty($categoryQuery) || !empty($titleQuery)) {
            $condition .= " where isActive = 1 and "
                . (empty($titleQuery) ? 'true' : $titleQuery)
                . " and "
                . (empty($categoryQuery) ? 'true' : $categoryQuery);
        } else
            $condition .= " where isActive = 1";

        $sql = "select * from posts"
            . $condition
            . " order by createdAt desc "
            . " limit " . $pageSize . " offset " . (($page - 1) * $pageSize);

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = array();
        while ($row = $stmt->fetch()) {
            array_push($result, $row);
        }

        //get count
        $query = "select count(*) as count from posts" . $condition;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $countResult = $stmt->fetch();

        return array(
            "posts" => $result,
            "count" => $countResult["count"]
        );
    }

    public function search($page, $pageSize, $condition)
    {
        $categoryQuery = $this->buildCategoryQuery($condition);
        $titleQuery = $this->buildTitleQuery($condition);
        $isActiveQuery = $this->buildIsActiveQuery($condition);

        $condition = "";
        if (!empty($categoryQuery) || !empty($titleQuery) || !empty($isActiveQuery)) {
            $condition .= " where "
                . (empty($titleQuery) ? 'true' : $titleQuery)
                . " and "
                . (empty($isActiveQuery) ? 'true' : $isActiveQuery)
                . " and "
                . (empty($categoryQuery) ? 'true' : $categoryQuery);
        } else
            $condition .= "";

        $sql = "select * from posts"
            . $condition
            . " order by createdAt desc "
            . " limit " . $pageSize . " offset " . (($page - 1) * $pageSize);

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = array();
        while ($row = $stmt->fetch()) {
            array_push($result, $row);
        }

        //get count
        $query = "select count(*) as count from posts" . $condition;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $countResult = $stmt->fetch();

        return array(
            "posts" => $result,
            "count" => $countResult["count"]
        );
    }

    public function mostViews($offset, $take)
    {
        $query = "select * from posts where isActive = 1 order by views desc limit " . $take . " offset " . $offset;
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $posts = array();
        while ($row = $stmt->fetch()) {
            array_push($posts, $row);
        }

        return $posts;
    }

    public function getComments($id)
    {
        $query = "select comments.id, count(*) as count from posts left join comments on posts.id = comments.postId where posts.id = " . $id
            . " and comments.isActive = 1 "
            . " having comments.id IS NOT NULL";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $result = $stmt->fetch();

        return $result["count"];
    }

    //update
    public function update($id, $columns)
    {
        $sql = "update posts set ";

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
        $query = "select views from posts where id = " . $id;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();

        //update views
        $query = "update posts set views = " . (intval($result["views"]) + 1) . " where id = " . $id;
        $this->db->exec($query);
    }

    public function approve($id)
    {
        $query = "update posts set isActive = 1 where id = " . $id;
        $result = $this->db->exec($query);

        return empty($result) ? false : true;
    }

    public function disableApprove($id)
    {
        $query = "update posts set isActive = 0 where id = " . $id;
        $result = $this->db->exec($query);

        return empty($result) ? false : true;
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

        $query = "insert into posts (title, image, summary, categoryId, content, author, createdAt) values ("
            . "N'" . $title . "', '" . $image . "', N'" . $summary . "', " . $categoryId . ",N'" . $content . "', N'" . $author . "', '" . $createdAt . "')";

        $result = $this->db->exec($query);
        return empty($result) ? false : true;
    }

    //delete
    public function delete($id)
    {
        $query = "delete from posts where id = " . $id;
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

    public function buildIsActiveQuery($condition)
    {
        if (!isset($condition["isActive"]))
            return "";
        if ($condition["isActive"] == "")
            return "";

        $query = "isActive = " . $condition["isActive"];

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