<?php

class StaffModel extends BaseModel
{
    private $table = 'users';
    
    // Staff roles
    const STAFF_ROLES = ['Nurse', 'Receptionist', 'Pharmacist', 'Technician', 'Other Staff'];
    const ACTIVE_STATUS = 1;
    const INACTIVE_STATUS = 0;
    
    /**
     * Get all staff members with optional filters
     * @param int $page - Pagination page
     * @param int $limit - Records per page
     * @param string $role - Filter by role
     * @param string $department - Filter by department
     * @param string $search - Search by name, email, or staff_id
     * @return array
     */
    public function getAllStaff($page = 1, $limit = 20, $role = null, $department = null, $search = null)
    {
        $offset = ($page - 1) * $limit;
        
        // Base query
        $sql = "SELECT u.*, d.department_name 
                FROM {$this->table} u
                LEFT JOIN departments d ON u.department_id = d.department_id
                WHERE u.role IN ('" . implode("','", self::STAFF_ROLES) . "')";
        
        // Apply role filter
        if ($role && in_array($role, self::STAFF_ROLES)) {
            $sql .= " AND u.role = '" . $this->db->real_escape_string($role) . "'";
        }
        
        // Apply department filter
        if ($department && $department !== 'All') {
            $sql .= " AND u.department_id = " . (int)$department;
        }
        
        // Apply search filter
        if ($search) {
            $searchTerm = $this->db->real_escape_string($search);
            $sql .= " AND (u.name LIKE '%{$searchTerm}%' 
                    OR u.email LIKE '%{$searchTerm}%' 
                    OR u.staff_id LIKE '%{$searchTerm}%')";
        }
        
        // Add sorting and pagination
        $sql .= " ORDER BY u.user_id DESC LIMIT {$limit} OFFSET {$offset}";
        
        $result = $this->db->query($sql);
        
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    
    /**
     * Get total count of staff with filters
     */
    public function getTotalStaffCount($role = null, $department = null, $search = null)
    {
        $sql = "SELECT COUNT(*) as total 
                FROM {$this->table} u
                WHERE u.role IN ('" . implode("','", self::STAFF_ROLES) . "')";
        
        if ($role && in_array($role, self::STAFF_ROLES)) {
            $sql .= " AND u.role = '" . $this->db->real_escape_string($role) . "'";
        }
        
        if ($department && $department !== 'All') {
            $sql .= " AND u.department_id = " . (int)$department;
        }
        
        if ($search) {
            $searchTerm = $this->db->real_escape_string($search);
            $sql .= " AND (u.name LIKE '%{$searchTerm}%' 
                    OR u.email LIKE '%{$searchTerm}%' 
                    OR u.staff_id LIKE '%{$searchTerm}%')";
        }
        
        $result = $this->db->query($sql);
        
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'];
        }
        return 0;
    }
    
    /**
     * Get a single staff member by ID
     */
    public function getStaffById($user_id)
    {
        $sql = "SELECT u.*, d.department_name 
                FROM {$this->table} u
                LEFT JOIN departments d ON u.department_id = d.department_id
                WHERE u.user_id = ? AND u.role IN ('" . implode("','", self::STAFF_ROLES) . "')";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    /**
     * Update staff status (activate/deactivate)
     */
    public function updateStaffStatus($user_id, $status)
    {
        // Validate status
        if (!in_array($status, [self::ACTIVE_STATUS, self::INACTIVE_STATUS])) {
            return false;
        }
        
        $sql = "UPDATE {$this->table} 
                SET status = ? 
                WHERE user_id = ? AND role IN ('" . implode("','", self::STAFF_ROLES) . "')";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $status, $user_id);
        return $stmt->execute();
    }
    
    /**
     * Delete a staff member
     */
    public function deleteStaff($user_id)
    {
        $sql = "DELETE FROM {$this->table} 
                WHERE user_id = ? AND role IN ('" . implode("','", self::STAFF_ROLES) . "')";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }
    
    /**
     * Search staff with AJAX
     */
    public function searchStaff($searchTerm, $limit = 10)
    {
        $searchTerm = $this->db->real_escape_string($searchTerm);
        
        $sql = "SELECT u.user_id, u.staff_id, u.name, u.email, u.role, u.status
                FROM {$this->table} u
                WHERE u.role IN ('" . implode("','", self::STAFF_ROLES) . "')
                AND (u.name LIKE '%{$searchTerm}%' 
                    OR u.email LIKE '%{$searchTerm}%' 
                    OR u.staff_id LIKE '%{$searchTerm}%')
                LIMIT {$limit}";
        
        $result = $this->db->query($sql);
        
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    
    /**
     * Get all staff for XML export
     */
    public function getAllStaffForExport($role = null, $department = null)
    {
        $sql = "SELECT u.*, d.department_name 
                FROM {$this->table} u
                LEFT JOIN departments d ON u.department_id = d.department_id
                WHERE u.role IN ('" . implode("','", self::STAFF_ROLES) . "')";
        
        if ($role && in_array($role, self::STAFF_ROLES)) {
            $sql .= " AND u.role = '" . $this->db->real_escape_string($role) . "'";
        }
        
        if ($department && $department !== 'All') {
            $sql .= " AND u.department_id = " . (int)$department;
        }
        
        $sql .= " ORDER BY u.user_id DESC";
        
        $result = $this->db->query($sql);
        
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    
    /**
     * Check if user is staff
     */
    public function isStaff($user_id)
    {
        $sql = "SELECT 1 FROM {$this->table} 
                WHERE user_id = ? AND role IN ('" . implode("','", self::STAFF_ROLES) . "')";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        
        return $stmt->get_result()->num_rows > 0;
    }
    
    /**
     * Create new staff member
     */
    public function createStaff($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (staff_id, name, email, phone, username, password, role, department_id, designation, joining_date, salary, address, profile_picture, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bind_param(
            "sssssssissssi",
            $data['staff_id'],
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['username'],
            $data['password'],
            $data['role'],
            $data['department_id'],
            $data['designation'],
            $data['joining_date'],
            $data['salary'],
            $data['address'],
            $data['profile_picture'],
            $data['status']
        );
        
        return $stmt->execute();
    }
    
    /**
     * Check if username exists
     */
    public function usernameExists($username)
    {
        $sql = "SELECT 1 FROM {$this->table} WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }
    
    /**
     * Check if email exists (excluding current user)
     */
    public function emailExists($email, $exclude_id = null)
    {
        if ($exclude_id) {
            $sql = "SELECT 1 FROM {$this->table} WHERE email = ? AND user_id != ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("si", $email, $exclude_id);
        } else {
            $sql = "SELECT 1 FROM {$this->table} WHERE email = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("s", $email);
        }
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }
    
    /**
     * Update staff member
     */
    public function updateStaff($user_id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
                name = ?, email = ?, phone = ?, role = ?, department_id = ?, 
                designation = ?, salary = ?, address = ?, status = ?";
        
        $params = [
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['role'],
            $data['department_id'],
            $data['designation'],
            $data['salary'],
            $data['address'],
            $data['status']
        ];
        
        // If profile picture is provided, add it to update
        if (!empty($data['profile_picture'])) {
            $sql .= ", profile_picture = ?";
            $params[] = $data['profile_picture'];
        }
        
        $sql .= " WHERE user_id = ? AND role IN ('" . implode("','", self::STAFF_ROLES) . "')";
        $params[] = $user_id;
        
        $stmt = $this->db->prepare($sql);
        
        // Build type string dynamically
        $types = str_repeat("s", count($params) - 1) . "i";
        $stmt->bind_param($types, ...$params);
        
        return $stmt->execute();
    }
    
    /**
     * Soft delete staff (mark as inactive and deleted)
     */
    public function softDeleteStaff($user_id)
    {
        $sql = "UPDATE {$this->table} SET status = 0, deleted = 1, deleted_at = NOW() 
                WHERE user_id = ? AND role IN ('" . implode("','", self::STAFF_ROLES) . "')";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }
    
    /**
     * Generate unique staff ID
     */
    public function generateStaffId()
    {
        $year = date('Y');
        $sql = "SELECT COUNT(*) + 1 as next_number FROM {$this->table} WHERE staff_id LIKE ?";
        
        $stmt = $this->db->prepare($sql);
        $pattern = "STF{$year}%";
        $stmt->bind_param("s", $pattern);
        $stmt->execute();
        
        $result = $stmt->get_result()->fetch_assoc();
        $number = str_pad($result['next_number'], 4, '0', STR_PAD_LEFT);
        
        return "STF{$year}{$number}";
    }
    
    /**
     * Get staff with deleted records excluded
     */
    public function getAllActiveStaff($page = 1, $limit = 20, $role = null, $department = null, $search = null)
    {
        // Same as getAllStaff but exclude deleted records
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT u.*, d.department_name 
                FROM {$this->table} u
                LEFT JOIN departments d ON u.department_id = d.department_id
                WHERE u.role IN ('" . implode("','", self::STAFF_ROLES) . "') AND (u.deleted = 0 OR u.deleted IS NULL)";
        
        if ($role && in_array($role, self::STAFF_ROLES)) {
            $sql .= " AND u.role = '" . $this->db->real_escape_string($role) . "'";
        }
        
        if ($department && $department !== 'All') {
            $sql .= " AND u.department_id = " . (int)$department;
        }
        
        if ($search) {
            $searchTerm = $this->db->real_escape_string($search);
            $sql .= " AND (u.name LIKE '%{$searchTerm}%' OR u.email LIKE '%{$searchTerm}%' OR u.staff_id LIKE '%{$searchTerm}%')";
        }
        
        $sql .= " ORDER BY u.user_id DESC LIMIT {$limit} OFFSET {$offset}";
        
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}
?>
