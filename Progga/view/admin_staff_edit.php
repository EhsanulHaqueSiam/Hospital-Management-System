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
    <title>Edit Staff - Admin</title>
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
            max-width: 700px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        label .required {
            color: #f44336;
        }

        label .read-only-badge {
            background: #f5f5f5;
            color: #666;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: 600;
            margin-left: 10px;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        input[type="file"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #2196F3;
            box-shadow: 0 0 5px rgba(33, 150, 243, 0.3);
        }

        input[type="text"]:disabled,
        input[type="date"]:disabled {
            background: #f5f5f5;
            color: #999;
            cursor: not-allowed;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-row.full {
            grid-template-columns: 1fr;
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

        .alert ul {
            margin: 10px 0 0 20px;
        }

        .alert li {
            margin: 5px 0;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
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

        .btn-secondary {
            background: #757575;
            color: white;
            flex: 1;
        }

        .btn-secondary:hover {
            background: #616161;
        }

        .btn-danger {
            background: #f44336;
            color: white;
            flex: 1;
        }

        .btn-danger:hover {
            background: #d32f2f;
        }

        .note {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .profile-preview {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .profile-preview img {
            width: 80px;
            height: 80px;
            border-radius: 4px;
            object-fit: cover;
            background: #ddd;
        }

        .profile-preview .info h3 {
            margin: 0 0 5px 0;
            color: #333;
            font-size: 14px;
        }

        .profile-preview .info p {
            margin: 0;
            color: #666;
            font-size: 12px;
        }

        .file-input-wrapper {
            position: relative;
        }

        .file-input-wrapper input[type="file"] {
            position: absolute;
            left: -9999px;
        }

        .file-input-label {
            display: block;
            padding: 12px;
            background: #f5f5f5;
            border: 2px dashed #ddd;
            border-radius: 4px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .file-input-label:hover {
            background: #efefef;
            border-color: #2196F3;
        }

        .success-message {
            text-align: center;
            padding: 40px 20px;
        }

        .success-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }

        .success-message h2 {
            color: #4CAF50;
            margin-bottom: 10px;
        }

        .success-message a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            background: #2196F3;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.3s;
        }

        .success-message a:hover {
            background: #1976D2;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 22px;
                margin-bottom: 20px;
            }

            .profile-preview {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($success): ?>
            <div class="success-message">
                <div class="success-icon">✓</div>
                <h2>Staff Updated Successfully!</h2>
                <p>Staff information has been updated in the system.</p>
                <a href="admin_staff_view.php?id=<?php echo htmlspecialchars($staff_id); ?>">← View Staff Details</a>
            </div>
        <?php else: ?>
            <h1>✏️ Edit Staff Member</h1>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <strong>Please fix the following errors:</strong>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Profile Preview -->
            <?php if ($staff && isset($staff['profile_picture']) && $staff['profile_picture']): ?>
                <div class="profile-preview">
                    <img 
                        src="../../uploads/profiles/<?php echo htmlspecialchars($staff['profile_picture']); ?>" 
                        alt="Profile"
                        onerror="this.style.display='none'"
                    >
                    <div class="info">
                        <h3><?php echo htmlspecialchars($staff['name'] ?? 'Staff Member'); ?></h3>
                        <p><strong>Staff ID:</strong> <?php echo htmlspecialchars($staff['staff_id'] ?? 'N/A'); ?></p>
                        <p><strong>Role:</strong> <?php echo htmlspecialchars($staff['role'] ?? 'N/A'); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" id="editStaffForm">
                <!-- Personal Information Section -->
                <h3 style="color: #333; margin-top: 0; margin-bottom: 15px;">Personal Information</h3>

                <div class="form-group">
                    <label for="full_name">Full Name <span class="required">*</span></label>
                    <input 
                        type="text" 
                        id="full_name" 
                        name="full_name" 
                        value="<?php echo htmlspecialchars($staff['name'] ?? ''); ?>"
                        required
                    >
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="<?php echo htmlspecialchars($staff['email'] ?? ''); ?>"
                            required
                        >
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone <span class="required">*</span></label>
                        <input 
                            type="text" 
                            id="phone" 
                            name="phone" 
                            value="<?php echo htmlspecialchars($staff['phone'] ?? ''); ?>"
                            maxlength="10"
                            required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Address <span class="required">*</span></label>
                    <textarea 
                        id="address" 
                        name="address" 
                        required
                    ><?php echo htmlspecialchars($staff['address'] ?? ''); ?></textarea>
                </div>

                <!-- Job Information Section -->
                <h3 style="color: #333; margin-top: 30px; margin-bottom: 15px;">Job Information</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="role">Role <span class="required">*</span></label>
                        <select id="role" name="role" required>
                            <option value="">-- Select Role --</option>
                            <?php foreach ($roles as $r): ?>
                                <option value="<?php echo htmlspecialchars($r); ?>" 
                                    <?php echo (isset($staff['role']) && $staff['role'] === $r) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($r); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="department_id">Department <span class="required">*</span></label>
                        <select id="department_id" name="department_id" required>
                            <option value="">-- Select Department --</option>
                            <?php if (is_array($departments)): ?>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?php echo $dept['department_id']; ?>" 
                                        <?php echo (isset($staff['department_id']) && $staff['department_id'] == $dept['department_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($dept['department_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="designation">Designation <span class="required">*</span></label>
                        <input 
                            type="text" 
                            id="designation" 
                            name="designation" 
                            value="<?php echo htmlspecialchars($staff['designation'] ?? ''); ?>"
                            required
                        >
                    </div>
                    <div class="form-group">
                        <label for="joining_date">Joining Date <span class="required">*</span> <span class="read-only-badge">READ-ONLY</span></label>
                        <input 
                            type="date" 
                            id="joining_date" 
                            name="joining_date" 
                            value="<?php echo htmlspecialchars($staff['joining_date'] ?? ''); ?>"
                            disabled
                        >
                        <div class="note">This field cannot be changed after creation.</div>
                    </div>
                </div>

                <!-- Additional Information Section -->
                <h3 style="color: #333; margin-top: 30px; margin-bottom: 15px;">Additional Information</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="salary">Salary</label>
                        <input 
                            type="number" 
                            id="salary" 
                            name="salary" 
                            step="0.01"
                            value="<?php echo htmlspecialchars($staff['salary'] ?? '0'); ?>"
                        >
                    </div>
                    <div class="form-group">
                        <label for="status">Status <span class="required">*</span></label>
                        <select id="status" name="status" required>
                            <option value="1" <?php echo (isset($staff['status']) && $staff['status'] == 1) ? 'selected' : ''; ?>>Active</option>
                            <option value="0" <?php echo (isset($staff['status']) && $staff['status'] == 0) ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="profile_picture">Profile Picture (Optional)</label>
                    <div class="file-input-wrapper">
                        <input 
                            type="file" 
                            id="profile_picture" 
                            name="profile_picture" 
                            accept="image/jpeg,image/png,image/gif"
                        >
                        <label for="profile_picture" class="file-input-label">
                            📷 Click to upload new profile picture
                            <div class="note" style="margin-top: 5px;">Max 2MB. Formats: JPEG, PNG, GIF</div>
                        </label>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">✓ Update Staff</button>
                    <a href="admin_staff_view.php?id=<?php echo htmlspecialchars($staff_id); ?>" class="btn btn-secondary">✕ Cancel</a>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <script>
        // Update file input label with selected file name
        document.getElementById('profile_picture')?.addEventListener('change', function(e) {
            const label = this.nextElementSibling;
            if (this.files && this.files[0]) {
                label.textContent = '✓ ' + this.files[0].name;
            } else {
                label.innerHTML = '📷 Click to upload new profile picture<div class="note" style="margin-top: 5px;">Max 2MB. Formats: JPEG, PNG, GIF</div>';
            }
        });

        // Phone number formatting (10 digits only)
        document.getElementById('phone').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '').slice(0, 10);
        });

        // Form validation (client-side)
        document.getElementById('editStaffForm')?.addEventListener('submit', function(e) {
            const phone = document.getElementById('phone').value;
            
            if (phone.length !== 10) {
                e.preventDefault();
                alert('Phone number must be exactly 10 digits.');
                return;
            }
        });
    </script>
</body>
</html>
