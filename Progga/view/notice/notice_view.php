<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Please login first.";
    exit;
}
if (!isset($notice) || !$notice) {
    echo "Notice not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($notice['title']); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        
        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 8px 16px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .back-btn:hover {
            background: #764ba2;
        }
        
        .notice-header {
            border-bottom: 2px solid #667eea;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .notice-title {
            font-size: 2em;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }
        
        .notice-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .notice-date {
            color: #666;
            font-size: 0.95em;
        }
        
        .category-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: bold;
            color: white;
        }
        
        .badge-general {
            background: #3498db;
        }
        
        .badge-emergency {
            background: #e74c3c;
        }
        
        .badge-holiday {
            background: #2ecc71;
        }
        
        .badge-maintenance {
            background: #f39c12;
        }
        
        .badge-event {
            background: #9b59b6;
        }
        
        .badge-other {
            background: #95a5a6;
        }
        
        .important-badge {
            background: #ff6b6b;
            padding: 8px 16px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            font-size: 0.9em;
        }
        
        .notice-content {
            color: #555;
            line-height: 1.8;
            font-size: 1.05em;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="notice_user_controller.php" class="back-btn">← Back to Notices</a>
    
    <div class="notice-header">
        <div class="notice-title"><?php echo htmlspecialchars($notice['title']); ?></div>
        <div class="notice-meta">
            <div class="notice-date">
                📅 <?php echo date("F d, Y - H:i A", strtotime($notice['created_at'])); ?>
            </div>
            <span class="category-badge badge-<?php echo strtolower(str_replace(' ', '-', $notice['category'] ?? 'other')); ?>">
                <?php echo htmlspecialchars($notice['category'] ?? 'Other'); ?>
            </span>
            <?php if ($notice['is_important']) { ?>
                <span class="important-badge">⭐ IMPORTANT</span>
            <?php } ?>
        </div>
    </div>
    
    <div class="notice-content">
        <?php echo htmlspecialchars($notice['content']); ?>
    </div>
</div>

</body>
</html>
