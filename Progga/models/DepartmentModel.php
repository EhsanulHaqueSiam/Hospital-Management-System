<?php

class DepartmentModel extends BaseModel
{
    private $table = 'departments';

    /**
     * Get all departments
     */
    public function getAllDepartments()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY department_name ASC";
        $result = $this->db->query($sql);
        
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    /**
     * Get a single department by ID
     */
    public function getDepartmentById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE department_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Create a new department
     */
    public function createDepartment($data)
    {
        $sql = "INSERT INTO {$this->table} (department_name, description) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $data['department_name'], $data['description']);
        
        return $stmt->execute();
    }

    /**
     * Update a department
     */
    public function updateDepartment($id, $data)
    {
        $sql = "UPDATE {$this->table} SET department_name = ?, description = ? WHERE department_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssi", $data['department_name'], $data['description'], $id);
        
        return $stmt->execute();
    }

    /**
     * Delete a department
     */
    public function deleteDepartment($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE department_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
}
?>
