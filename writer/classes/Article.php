<?php  

require_once 'Database.php';
require_once 'User.php';

class Article extends Database {
    public function createArticle($title, $content, $author_id, $image_path = null, $category_id = null) {
        $sql = "INSERT INTO articles (title, content, author_id, image_path, category_id, is_active) VALUES (?, ?, ?, ?, ?, 0)";
        return $this->executeNonQuery($sql, [$title, $content, $author_id, $image_path, $category_id]);
    }

    public function getArticles($id = null) {
        if ($id) {
            $sql = "SELECT a.*, u.username, u.is_admin, c.name as category_name 
                    FROM articles a 
                    LEFT JOIN school_publication_users u ON a.author_id = u.user_id 
                    LEFT JOIN categories c ON a.category_id = c.category_id 
                    WHERE a.article_id = ?";
            return $this->executeQuerySingle($sql, [$id]);
        }
        $sql = "SELECT a.*, u.username, u.is_admin, c.name as category_name 
                FROM articles a 
                LEFT JOIN school_publication_users u ON a.author_id = u.user_id 
                LEFT JOIN categories c ON a.category_id = c.category_id 
                ORDER BY a.created_at DESC";
        return $this->executeQuery($sql);
    }

    public function getActiveArticles($id = null) {
        if ($id) {
            $sql = "SELECT a.*, u.username, u.is_admin, c.name as category_name 
                    FROM articles a 
                    LEFT JOIN school_publication_users u ON a.author_id = u.user_id 
                    LEFT JOIN categories c ON a.category_id = c.category_id 
                    WHERE a.article_id = ?";
            return $this->executeQuerySingle($sql, [$id]);
        }
        $sql = "SELECT a.*, u.username, u.is_admin, c.name as category_name 
                FROM articles a 
                LEFT JOIN school_publication_users u ON a.author_id = u.user_id 
                LEFT JOIN categories c ON a.category_id = c.category_id 
                WHERE a.is_active = 1 ORDER BY a.created_at DESC";
                
        return $this->executeQuery($sql);
    }

    public function getArticlesByUserID($user_id) {
        $sql = "SELECT a.*, u.username, c.name as category_name 
                FROM articles a 
                LEFT JOIN school_publication_users u ON a.author_id = u.user_id 
                LEFT JOIN categories c ON a.category_id = c.category_id 
                WHERE a.author_id = ? ORDER BY a.created_at DESC";
        return $this->executeQuery($sql, [$user_id]);
    }

    public function updateArticle($id, $title, $content, $image_path = null, $category_id = null) {
        if ($image_path) {
            $sql = "UPDATE articles SET title = ?, content = ?, image_path = ?, category_id = ? WHERE article_id = ?";
            return $this->executeNonQuery($sql, [$title, $content, $image_path, $category_id, $id]);
        } else {
            $sql = "UPDATE articles SET title = ?, content = ?, category_id = ? WHERE article_id = ?";
            return $this->executeNonQuery($sql, [$title, $content, $category_id, $id]);
        }
    }
    
    public function updateArticleVisibility($id, $is_active) {
        $userModel = new User();
        if (!$userModel->isAdmin()) {
            return 0;
        }
        $sql = "UPDATE articles SET is_active = ? WHERE article_id = ?";
        return $this->executeNonQuery($sql, [(int)$is_active, $id]);
    }

    public function deleteArticle($id) {
        $sql = "DELETE FROM articles WHERE article_id = ?";
        return $this->executeNonQuery($sql, [$id]);
    }

    public function getSharedForWriter($writer_id) {
        $sql = "SELECT a.* , u.username FROM shared_articles s
                JOIN articles a ON s.article_id = a.article_id
                JOIN school_publication_users u ON a.author_id = u.user_id
                WHERE s.writer_id = ? ORDER BY a.created_at DESC";
        return $this->executeQuery($sql, [$writer_id]);
    }

    public function getEditRequestsForArticle($article_id) {
        $sql = "SELECT er.*, u.username FROM edit_requests er 
                JOIN school_publication_users u ON er.requester_id = u.user_id 
                WHERE er.article_id = ? AND er.status = 'pending'";
        return $this->executeQuery($sql, [$article_id]);
    }

    public function createEditRequest($article_id, $requester_id) {
        $sql = "INSERT INTO edit_requests (article_id, requester_id) VALUES (?, ?)";
        return $this->executeNonQuery($sql, [$article_id, $requester_id]);
    }

    public function createNotification($user_id, $message) {
        $sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
        return $this->executeNonQuery($sql, [$user_id, $message]);
    }
}
?>