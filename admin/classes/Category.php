<?php

require_once 'Database.php';

class Category extends Database {
    public function createCategory($name, $description = null) {
        $sql = "INSERT INTO categories (name, description) VALUES (?, ?)";
        return $this->executeNonQuery($sql, [$name, $description]);
    }

    public function getCategories($id = null) {
        if ($id) {
            $sql = "SELECT * FROM categories WHERE category_id = ?";
            return $this->executeQuerySingle($sql, [$id]);
        }
        $sql = "SELECT * FROM categories ORDER BY name ASC";
        return $this->executeQuery($sql);
    }

    public function updateCategory($id, $name, $description = null) {
        $sql = "UPDATE categories SET name = ?, description = ? WHERE category_id = ?";
        return $this->executeNonQuery($sql, [$name, $description, $id]);
    }

    public function deleteCategory($id) {
        $sql = "DELETE FROM categories WHERE category_id = ?";
        return $this->executeNonQuery($sql, [$id]);
    }

    public function nameExists($name, $exclude_id = null) {
        if ($exclude_id) {
            $sql = "SELECT COUNT(*) as count FROM categories WHERE name = ? AND category_id != ?";
            $result = $this->executeQuerySingle($sql, [$name, $exclude_id]);
        } else {
            $sql = "SELECT COUNT(*) as count FROM categories WHERE name = ?";
            $result = $this->executeQuerySingle($sql, [$name]);
        }
        return $result['count'] > 0;
    }
}
?>
