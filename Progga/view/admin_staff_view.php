<?php
// Check admin access
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ../view/auth_signin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Details - <?php echo htmlspecialchars($display_staff['name']); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
            color: white;
            padding: 40px;
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 8px;
            border: 4px solid white;
            object-fit: cover;
            background: #f5f5f5;
        }

        .header-info h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .header-info .meta {
            font-size: 14px;
            opacity: 0.9;
        }

        .header-info .meta span {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 5px;
        }

        .header-info .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-right: 10px;
        }

        .badge-role {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .badge-status-active {
            background: #4CAF50;
            color: white;
        }

        .badge-status-inactive {
            background: #f44336;
            color: white;
        }

        .content {
            padding: 40px;
        }

        .section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #2196F3;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            color: #333;
            word-break: break-word;
        }

        .info-value.empty {
            color: #999;
            font-style: italic;
        }

        .action-bar {
            display: flex;
            gap: 10px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            margin-top: 40px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: #2196F3;
            color: white;
            flex: 1;
        }

        .btn-primary:hover {
            background: #1976D2;
        }

        .btn-danger {
            background: #f44336;
            color: white;
            flex: 1;
        }

        .btn-danger:hover {
            background: #d32f2f;
        }

        .btn-success {
            background: #4CAF50;
            color: white;
            flex: 1;
        }

        .btn-success:hover {
            background: #388E3C;
        }

        .btn-secondary {
            background: #757575;
            color: white;
            flex: 1;
        }

        .btn-secondary:hover {
            background: #616161;
        }

        .employment-card {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 6px;
            border-left: 4px solid #2196F3;
        }

        .employment-card .info-grid {
            gap: 20px;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }

        .yos-highlight {
            background: #E3F2FD;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 20px;
        }

        .yos-highlight .info-value {
            font-size: 28px;
            font-weight: 700;
            color: #2196F3;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                padding: 20px;
                text-align: center;
            }

            .header-info h1 {
                font-size: 22px;
            }

            .header-info .meta {
                text-align: center;
            }

            .content {
                padding: 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .action-bar {
                flex-direction: column;
            }

            .btn {
                flex: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with Profile -->
        <div class="header">
            <?php if ($display_staff['profile_picture']): ?>
                <img 
                    src="../../uploads/profiles/<?php echo htmlspecialchars($display_staff['profile_picture']); ?>" 
                    alt="Profile" 
                    class="profile-picture"
                    onerror="this.style.display='none'"
                >
            <?php else: ?>
                <div class="profile-picture" style="background: #ddd; display: flex; align-items: center; justify-content: center; font-size: 40px;">
                    👤
                </div>
            <?php endif; ?>

            <div class="header-info">
                <h1><?php echo htmlspecialchars($display_staff['name']); ?></h1>
                <div class="meta">
                    <span class="badge badge-role"><?php echo htmlspecialchars($display_staff['role']); ?></span>
                    <span class="badge <?php echo $display_staff['status'] == 1 ? 'badge-status-active' : 'badge-status-inactive'; ?>">
                        <?php echo $display_staff['status'] == 1 ? '✓ Active' : '✗ Inactive'; ?>
                    </span>
                </div>
                <div class="meta" style="margin-top: 15px;">
                    <span><strong>Staff ID:</strong> <?php echo htmlspecialchars($display_staff['staff_id']); ?></span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Personal Information Section -->
            <div class="section">
                <h2 class="section-title">📋 Personal Information</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Full Name</div>
                        <div class="info-value"><?php echo htmlspecialchars($display_staff['name']); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">
                            <a href="mailto:<?php echo htmlspecialchars($display_staff['email']); ?>" style="color: #2196F3; text-decoration: none;">
                                <?php echo htmlspecialchars($display_staff['email']); ?>
                            </a>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Phone</div>
                        <div class="info-value">
                            <a href="tel:<?php echo htmlspecialchars($display_staff['phone']); ?>" style="color: #2196F3; text-decoration: none;">
                                <?php echo htmlspecialchars($display_staff['phone']); ?>
                            </a>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Address</div>
                        <div class="info-value"><?php echo htmlspecialchars($display_staff['address']); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Department</div>
                        <div class="info-value">
                            <?php 
                            if ($department) {
                                echo htmlspecialchars($department['department_name']);
                            } else {
                                echo '<span class="empty">Not assigned</span>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Designation</div>
                        <div class="info-value"><?php echo htmlspecialchars($display_staff['designation']); ?></div>
                    </div>
                </div>
            </div>
            <!-- Employment Information Section -->
            <div class="section">
                <h2 class="section-title">💼 Employment Information</h2>

                <div class="yos-highlight">
                    <div class="info-label">Years of Service</div>
                    <div class="info-value">
                        <?php echo $display_staff['years_of_service']; ?> years <?php echo $display_staff['months_of_service']; ?> months
                    </div>
                </div>

                <div class="employment-card">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Joining Date</div>
                            <div class="info-value">
                                <?php 
                                $date = new DateTime($display_staff['joining_date']);
                                echo $date->format('d M, Y');
                                ?>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Salary</div>
                            <div class="info-value">
                                <?php 
                                if ($display_staff['salary'] > 0) {
                                    echo '₹ ' . number_format($display_staff['salary'], 2);
                                } else {
                                    echo '<span class="empty">Not set</span>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                <span class="badge <?php echo $display_staff['status'] == 1 ? 'badge-status-active' : 'badge-status-inactive'; ?>">
                                    <?php echo $display_staff['status'] == 1 ? '✓ Active' : '✗ Inactive'; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-bar">
                <a href="admin_staff_edit.php?id=<?php echo $display_staff['user_id']; ?>" class="btn btn-primary">
                    ✏️ Edit Staff
                </a>
                <?php if ($display_staff['status'] == 1): ?>
                    <button class="btn btn-danger" onclick="deactivateStaff(<?php echo $display_staff['user_id']; ?>)">
                        ✗ Deactivate
                    </button>
                <?php else: ?>
                    <button class="btn btn-success" onclick="activateStaff(<?php echo $display_staff['user_id']; ?>)">
                        ✓ Activate
                    </button>
                <?php endif; ?>
                <a href="admin_staff_router.php" class="btn btn-secondary">
                    ← Back to Staff List
                </a>
            </div>
        </div>
    </div>

    <script>
        function deactivateStaff(userId) {
            if (!confirm('Are you sure you want to deactivate this staff member? They will not be able to login.')) {
                return;
            }

            fetch('admin_staff_router.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=deactivate&id=' + userId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Staff member deactivated successfully.');
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Unable to deactivate staff.'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }

        function activateStaff(userId) {
            if (!confirm('Are you sure you want to activate this staff member?')) {
                return;
            }

            fetch('admin_staff_router.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=activate&id=' + userId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Staff member activated successfully.');
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Unable to activate staff.'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }
    </script>
</body>
</html>
