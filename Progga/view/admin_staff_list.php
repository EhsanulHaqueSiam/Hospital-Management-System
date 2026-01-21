<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ../controller/admin_signin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Staff List - Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        
        h1 {
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
        }
        
        .staff-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .btn-primary {
            background: #2196F3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s;
        }
        
        .btn-primary:hover {
            background: #1976D2;
        }
        
        .btn-secondary {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s;
        }
        
        .btn-secondary:hover {
            background: #45a049;
        }
        
        .btn-danger {
            background: #f44336;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.3s;
        }
        
        .btn-danger:hover {
            background: #da190b;
        }
        
        .btn-info {
            background: #2196F3;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.3s;
        }
        
        .btn-info:hover {
            background: #1976D2;
        }
        
        .btn-warning {
            background: #ff9800;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.3s;
        }
        
        .btn-warning:hover {
            background: #e68900;
        }
        
        .filters-section {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 25px;
            border: 1px solid #ddd;
        }
        
        .filters-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            align-items: flex-end;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
        }
        
        .filter-group label {
            font-weight: 600;
            margin-bottom: 6px;
            color: #333;
            font-size: 14px;
        }
        
        .filter-group input,
        .filter-group select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            font-family: inherit;
        }
        
        .filter-group input:focus,
        .filter-group select:focus {
            outline: none;
            border-color: #2196F3;
            box-shadow: 0 0 3px rgba(33, 150, 243, 0.3);
        }
        
        .search-suggestions {
            position: absolute;
            background: white;
            border: 1px solid #ddd;
            border-top: none;
            max-height: 300px;
            overflow-y: auto;
            width: 100%;
            z-index: 1000;
            display: none;
        }
        
        .search-suggestions.show {
            display: block;
        }
        
        .suggestion-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background 0.2s;
        }
        
        .suggestion-item:hover {
            background: #f0f0f0;
        }
        
        .search-container {
            position: relative;
            flex: 1;
        }
        
        .btn-filter {
            background: #2196F3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }
        
        .btn-filter:hover {
            background: #1976D2;
        }
        
        .btn-reset {
            background: #757575;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }
        
        .btn-reset:hover {
            background: #616161;
        }
        
        .table-section {
            margin-bottom: 25px;
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        
        table thead {
            background: #2196F3;
            color: white;
        }
        
        table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        
        table tbody tr {
            border-bottom: 1px solid #ddd;
            transition: background 0.2s;
        }
        
        table tbody tr:hover {
            background: #f5f5f5;
        }
        
        table td {
            padding: 12px 15px;
        }
        
        .status-active {
            background: #4CAF50;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        
        .status-inactive {
            background: #9E9E9E;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        
        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 25px;
            flex-wrap: wrap;
        }
        
        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .pagination a {
            color: #2196F3;
            text-decoration: none;
        }
        
        .pagination a:hover {
            background: #2196F3;
            color: white;
        }
        
        .pagination .active {
            background: #2196F3;
            color: white;
            border-color: #2196F3;
        }
        
        .pagination .disabled {
            color: #999;
            cursor: not-allowed;
        }
        
        .info-text {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
            font-size: 16px;
        }
        
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        @media (max-width: 768px) {
            .staff-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .filters-row {
                grid-template-columns: 1fr;
            }
            
            table {
                font-size: 12px;
            }
            
            table th,
            table td {
                padding: 8px 10px;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .actions button,
            .actions a {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php include 'partials/navbar.php'; ?>
    <div class="container">
        <div class="staff-header">
            <h1>👥 View Staff List</h1>
            <div>
                <a href="../controller/admin_staff_router.php?action=add" class="btn-primary">+ Add Staff</a>
                <button onclick="exportToXML()" class="btn-secondary">📥 Export to XML</button>
            </div>
        </div>
        
        <!-- Filters Section -->
        <div class="filters-section">
            <h3 style="margin-bottom: 15px; color: #333;">Filter & Search</h3>
            <form method="GET" action="">
                <input type="hidden" name="action" value="list">
                
                <div class="filters-row">
                    <!-- Search Bar with AJAX -->
                    <div class="filter-group" style="flex: 1;">
                        <label for="search">Search (Name, Email, Staff ID)</label>
                        <div class="search-container">
                            <input 
                                type="text" 
                                id="search" 
                                name="search" 
                                placeholder="Type to search..." 
                                value="<?php echo htmlspecialchars($searchTerm ?? ''); ?>"
                                autocomplete="off"
                            >
                            <div id="searchSuggestions" class="search-suggestions"></div>
                        </div>
                    </div>
                    
                    <!-- Role Filter -->
                    <div class="filter-group">
                        <label for="role">Role</label>
                        <select id="role" name="role">
                            <option value="">All Roles</option>
                            <?php foreach ($roles as $r): ?>
                                <option value="<?php echo htmlspecialchars($r); ?>" 
                                    <?php echo ($selectedRole === $r) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($r); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- Department Filter -->
                    <div class="filter-group">
                        <label for="department">Department</label>
                        <select id="department" name="department">
                            <option value="">All Departments</option>
                            <?php if (isset($departments) && is_array($departments)): ?>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?php echo htmlspecialchars($dept['department_id']); ?>" 
                                        <?php echo ($selectedDepartment == $dept['department_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($dept['department_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <!-- Filter Buttons -->
                    <div style="display: flex; gap: 10px;">
                        <button type="submit" class="btn-filter">🔍 Filter</button>
                        <a href="../controller/admin_staff_router.php" class="btn-reset" style="text-decoration: none; text-align: center;">↻ Reset</a>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Info Text -->
        <div class="info-text">
            Showing <strong><?php echo count($staff); ?></strong> of <strong><?php echo $totalStaff; ?></strong> staff members
            <?php if ($selectedRole): ?> | Role: <strong><?php echo htmlspecialchars($selectedRole); ?></strong><?php endif; ?>
            <?php if ($selectedDepartment): ?> | Department: <strong><?php echo htmlspecialchars($selectedDepartment); ?></strong><?php endif; ?>
        </div>
        
        <!-- Staff Table -->
        <div class="table-section">
            <?php if (!empty($staff)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Staff ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Department</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($staff as $member): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($member['staff_id']); ?></strong></td>
                                <td><?php echo htmlspecialchars($member['name']); ?></td>
                                <td><?php echo htmlspecialchars($member['email']); ?></td>
                                <td>
                                    <span style="background: #e3f2fd; color: #1565c0; padding: 4px 8px; border-radius: 3px; font-size: 12px;">
                                        <?php echo htmlspecialchars($member['role']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($member['department_name'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($member['phone'] ?? 'N/A'); ?></td>
                                <td>
                                    <?php if ($member['status'] == 1): ?>
                                        <span class="status-active">✓ Active</span>
                                    <?php else: ?>
                                        <span class="status-inactive">✗ Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="../controller/admin_staff_router.php?action=view&id=<?php echo $member['user_id']; ?>" class="btn-info">View</a>
                                        <a href="../controller/admin_staff_router.php?action=edit&id=<?php echo $member['user_id']; ?>" class="btn-warning">Edit</a>
                                        <?php if ($member['status'] == 1): ?>
                                            <button class="btn-danger" onclick="deactivateStaff(<?php echo $member['user_id']; ?>)">Deactivate</button>
                                        <?php else: ?>
                                            <button class="btn-info" onclick="activateStaff(<?php echo $member['user_id']; ?>)">Activate</button>
                                        <?php endif; ?>
                                        <button class="btn-danger" onclick="deleteStaff(<?php echo $member['user_id']; ?>)">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-data">
                    <p>📭 No staff members found matching your criteria.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <a href="../controller/admin_staff_router.php?<?php echo http_build_query(array_filter(['role' => $selectedRole, 'department' => $selectedDepartment, 'search' => $searchTerm])); ?>&page=1">« First</a>
                    <a href="../controller/admin_staff_router.php?<?php echo http_build_query(array_filter(['role' => $selectedRole, 'department' => $selectedDepartment, 'search' => $searchTerm])); ?>&page=<?php echo $currentPage - 1; ?>">‹ Previous</a>
                <?php else: ?>
                    <span class="disabled">« First</span>
                    <span class="disabled">‹ Previous</span>
                <?php endif; ?>
                
                <?php
                $start = max(1, $currentPage - 2);
                $end = min($totalPages, $currentPage + 2);
                
                if ($start > 1): ?>
                    <span>...</span>
                <?php endif; ?>
                
                <?php for ($i = $start; $i <= $end; $i++): ?>
                    <?php if ($i == $currentPage): ?>
                        <span class="active"><?php echo $i; ?></span>
                    <?php else: ?>
                        <a href="../controller/admin_staff_router.php?<?php echo http_build_query(array_filter(['role' => $selectedRole, 'department' => $selectedDepartment, 'search' => $searchTerm])); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                
                <?php if ($end < $totalPages): ?>
                    <span>...</span>
                <?php endif; ?>
                
                <?php if ($currentPage < $totalPages): ?>
                    <a href="../controller/admin_staff_router.php?<?php echo http_build_query(array_filter(['role' => $selectedRole, 'department' => $selectedDepartment, 'search' => $searchTerm])); ?>&page=<?php echo $currentPage + 1; ?>">Next ›</a>
                    <a href="../controller/admin_staff_router.php?<?php echo http_build_query(array_filter(['role' => $selectedRole, 'department' => $selectedDepartment, 'search' => $searchTerm])); ?>&page=<?php echo $totalPages; ?>">Last »</a>
                <?php else: ?>
                    <span class="disabled">Next ›</span>
                    <span class="disabled">Last »</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        // AJAX Search
        const searchInput = document.getElementById('search');
        const searchSuggestions = document.getElementById('searchSuggestions');
        
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            
            if (this.value.length < 2) {
                searchSuggestions.classList.remove('show');
                return;
            }
            
            searchTimeout = setTimeout(() => {
                fetch(`../controller/admin_staff_router.php?action=search&q=${encodeURIComponent(this.value)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.results && data.results.length > 0) {
                            searchSuggestions.innerHTML = data.results.map(staff => `
                                <div class="suggestion-item" onclick="selectStaff('${staff.name}', '${staff.user_id}')">
                                    <strong>${escapeHtml(staff.name)}</strong> (${escapeHtml(staff.staff_id)})<br>
                                    <small>${escapeHtml(staff.email)}</small>
                                </div>
                            `).join('');
                            searchSuggestions.classList.add('show');
                        } else {
                            searchSuggestions.classList.remove('show');
                        }
                    })
                    .catch(error => console.error('Search error:', error));
            }, 300);
        });
        
        document.addEventListener('click', function(e) {
            if (e.target !== searchInput) {
                searchSuggestions.classList.remove('show');
            }
        });
        
        function selectStaff(name, userId) {
            searchInput.value = name;
            searchSuggestions.classList.remove('show');
            // Navigate to staff view
            window.location.href = `../controller/admin_staff_router.php?action=view&id=${userId}`;
        }
        
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        // Change Status
        function activateStaff(userId) {
            if (confirm('Activate this staff member?')) {
                changeStatus(userId, 1);
            }
        }
        
        function deactivateStaff(userId) {
            if (confirm('Deactivate this staff member?')) {
                changeStatus(userId, 0);
            }
        }
        
        function changeStatus(userId, status) {
            fetch('../controller/admin_staff_router.php?action=change_status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `user_id=${userId}&status=${status}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred');
            });
        }
        
        // Delete Staff
        function deleteStaff(userId) {
            if (confirm('Are you sure you want to delete this staff member? This action cannot be undone.')) {
                fetch('../controller/admin_staff_router.php?action=delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `user_id=${userId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred');
                });
            }
        }
        
        // Export to XML
        function exportToXML() {
            const role = document.getElementById('role').value;
            const department = document.getElementById('department').value;
            
            let url = '../controller/admin_staff_router.php?action=export_xml';
            if (role) url += `&role=${encodeURIComponent(role)}`;
            if (department) url += `&department=${encodeURIComponent(department)}`;
            
            window.location.href = url;
        }
    </script>
</body>
</html>
