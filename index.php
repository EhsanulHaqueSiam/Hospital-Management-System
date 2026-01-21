<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System - Home</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        nav {
            background: rgba(0, 0, 0, 0.8);
            padding: 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            position: sticky;
            top: 0;
        }

        nav ul {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            margin: 0;
            padding: 0;
        }

        nav li {
            border-right: 1px solid #555;
        }

        nav li:last-child {
            border-right: none;
        }

        nav a {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 15px 20px;
            transition: background 0.3s;
            font-weight: 500;
        }

        nav a:hover {
            background: #667eea;
        }

        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .hero {
            background: white;
            border-radius: 10px;
            padding: 60px 40px;
            max-width: 600px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .hero h1 {
            color: #333;
            font-size: 36px;
            margin-bottom: 15px;
        }

        .hero p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .cta-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 30px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            font-weight: 600;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #f5f5f5;
            color: #333;
            border: 2px solid #667eea;
        }

        .btn-secondary:hover {
            background: #667eea;
            color: white;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 50px;
        }

        .feature {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }

        .feature h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .feature p {
            color: #666;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
            }

            nav li {
                border-right: none;
                border-bottom: 1px solid #555;
            }

            .hero {
                padding: 40px 30px;
            }

            .hero h1 {
                font-size: 28px;
            }

            .cta-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Menu -->
    <?php include(__DIR__ . '/view/partials/navbar.php'); ?>

    <!-- Main Content -->
    <div class="container">
        <div class="hero">
            <h1>🏥 Hospital Management System</h1>
            <p>
                Welcome to our comprehensive Hospital Management System. 
                Manage staff, schedules, appointments, and patient records efficiently.
            </p>

            <div class="cta-buttons">
                <a href="/controller/admin_signin.php" class="btn btn-primary">Admin Login</a>
                <a href="/view/admin_staff_list.php" class="btn btn-secondary">View Staff</a>
            </div>

            <div class="features">
                <div class="feature">
                    <h3>👥 Staff Management</h3>
                    <p>Add, edit, and manage hospital staff members with ease.</p>
                </div>
                <div class="feature">
                    <h3>📅 Appointments</h3>
                    <p>Schedule and manage patient appointments efficiently.</p>
                </div>
                <div class="feature">
                    <h3>📊 Reports</h3>
                    <p>Generate comprehensive reports on revenue, doctors, and patients.</p>
                </div>
                <div class="feature">
                    <h3>🔒 Secure</h3>
                    <p>Password-protected access with role-based authorization.</p>
                </div>
                <div class="feature">
                    <h3>💾 Database</h3>
                    <p>Reliable MySQL database for all patient and staff information.</p>
                </div>
                <div class="feature">
                    <h3>🎨 Modern UI</h3>
                    <p>Clean and responsive user interface for all devices.</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>