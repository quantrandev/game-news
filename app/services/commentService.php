<?php

class CommentService
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function all()
    {
        $query = "select * from comments order by createdAt desc";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $comments = array();
        while ($row = $stmt->fetch()) {
            array_push($comments, $row);
        }
        return $comments;
    }

    public function getByPost($condition)
    {
        $postQuery = $this->buildPostQuery($condition);

        $condition = "";
        if (!empty($pageSize)) {
            $condition .= " where "
                . (empty($postQuery) ? 'true' : $postQuery);
        } else
            $condition .= "";

        $sql = "select * from comments"
            . $condition
            . " order by createdAt desc";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = array();
        while ($row = $stmt->fetch()) {
            array_push($result, $row);
        }

        return $result;
    }

    public function get($id)
    {
        $query = "select * from comments where id = " . $id;
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $comment = $stmt->fetch();
        return $comment;
    }

    public function getByPostWithPaging($page, $pageSize, $condition)
    {
        $postQuery = $this->buildPostQuery($condition);

        $condition = "";
        if (!empty($pageSize)) {
            $condition .= " where "
                . (empty($postQuery) ? 'true' : $postQuery);
        } else
            $condition .= "";

        $sql = "select * from comments"
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
        $query = "select count(*) as count from comments" . $condition;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $countResult = $stmt->fetch();

        return array(
            "comments" => $result,
            "count" => $countResult["count"]
        );
    }

    public function search($page, $pageSize, $condition)
    {
        $postQuery = $this->buildPostQuery($condition);

        $condition = "";
        if (!empty($pageSize)) {
            $condition .= " where "
                . (empty($postQuery) ? 'true' : $postQuery);
        } else
            $condition .= "";

        $sql = "select comments.id
, comments.content
, comments.author
, comments.parentId,
comments.createdAt,
 comments.isActive,
  comments.postId,
  news.image as postImage, 
  news.title as postTitle
  from comments inner join news on news.id = comments.postId "
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
        $query = "select count(*) as count from comments" . $condition;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $countResult = $stmt->fetch();

        return array(
            "comments" => $result,
            "count" => $countResult["count"]
        );
    }

    //modify data
    public function insert($data)
    {
        $author = $data["author"];
        $content = $data["content"];
        $postId = $data["postId"];
        $parentId = $data["parentId"];
        $createdAt = $data["createdAt"];

        $query = "insert into comments (author, content, postId, parentId, createdAt) values ("
            . "N'" . $author . "', N'" . $content . "'," . $postId . ", " . $parentId . ", '" . $createdAt . "')";

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

    public function buildPostQuery($condition)
    {
        if (empty($condition["postId"]))
            return "";

        $query = "postId = " . $condition["postId"];
        return $query;
    }
}

?>