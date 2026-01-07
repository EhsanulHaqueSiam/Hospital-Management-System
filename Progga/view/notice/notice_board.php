<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Please login first.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hospital Notice Board</title>
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
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #333;
            font-size: 2.5em;
        }
        
        .admin-btn {
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s;
        }
        
        .admin-btn:hover {
            background: #764ba2;
        }
        
        .filters {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .search-box {
            flex: 1;
            min-width: 200px;
        }
        
        .search-box input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            transition: border-color 0.3s;
        }
        
        .search-box input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .category-filter {
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            background: white;
            transition: border-color 0.3s;
        }
        
        .category-filter:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .refresh-info {
            color: #666;
            font-size: 0.9em;
            padding: 10px;
            background: #f0f0f0;
            border-radius: 5px;
            text-align: center;
        }
        
        .notices-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .notice-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .notice-card:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .notice-card.important {
            border: 2px solid #ff6b6b;
            background: #fff5f5;
        }
        
        .notice-card.important::before {
            content: '⭐ IMPORTANT';
            display: block;
            color: #ff6b6b;
            font-weight: bold;
            font-size: 0.8em;
            margin-bottom: 10px;
        }
        
        .notice-title {
            font-size: 1.4em;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        
        .notice-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            font-size: 0.9em;
            color: #666;
        }
        
        .notice-date {
            color: #999;
            font-size: 0.85em;
        }
        
        .category-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8em;
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
        
        .notice-content {
            color: #555;
            line-height: 1.6;
            margin-bottom: 15px;
            font-size: 0.95em;
        }
        
        .read-more-btn {
            background: #667eea;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
            transition: background 0.3s;
        }
        
        .read-more-btn:hover {
            background: #764ba2;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 30px;
        }
        
        .pagination a, .pagination span {
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #667eea;
            transition: all 0.3s;
        }
        
        .pagination a:hover {
            background: #667eea;
            color: white;
        }
        
        .pagination span.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }
        
        .no-notices {
            text-align: center;
            padding: 40px;
            color: #999;
            font-size: 1.1em;
        }
        
        .loading {
            text-align: center;
            padding: 20px;
            color: #667eea;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>🏥 Hospital Notice Board</h1>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin') { ?>
            <a href="notice_controller.php?action=create" class="admin-btn">+ Create Notice</a>
        <?php } ?>
    </div>
    
    <div class="filters">
        <div class="search-box">
            <input type="text" id="search" placeholder="Search notices by title or content..." onkeyup="searchNotices()">
        </div>
        <select class="category-filter" id="categoryFilter" onchange="filterByCategory()">
            <option value="all">All Categories</option>
            <option value="General">General</option>
            <option value="Emergency">Emergency</option>
            <option value="Holiday">Holiday</option>
            <option value="Maintenance">Maintenance</option>
            <option value="Event">Event</option>
            <option value="Other">Other</option>
        </select>
    </div>
    
    <div class="refresh-info">
        ⏰ This page auto-refreshes every 5 minutes to show latest notices
    </div>
    
    <div id="noticesContainer">
        <div class="notices-grid" id="noticesGrid">
            <?php if (empty($notices)) { ?>
                <div class="no-notices">No notices found</div>
            <?php } else { ?>
                <?php foreach ($notices as $notice) { ?>
                    <div class="notice-card <?php echo $notice['is_important'] ? 'important' : ''; ?>">
                        <div class="notice-title"><?php echo htmlspecialchars($notice['title']); ?></div>
                        <div class="notice-meta">
                            <div class="notice-date"><?php echo date("M d, Y - H:i", strtotime($notice['created_at'])); ?></div>
                            <span class="category-badge badge-<?php echo strtolower(str_replace(' ', '-', $notice['category'] ?? 'other')); ?>">
                                <?php echo htmlspecialchars($notice['category'] ?? 'Other'); ?>
                            </span>
                        </div>
                        <div class="notice-content">
                            <?php 
                            $preview = substr($notice['content'], 0, 150);
                            echo htmlspecialchars($preview) . (strlen($notice['content']) > 150 ? '...' : '');
                            ?>
                        </div>
                        <a href="notice_user_controller.php?action=view&id=<?=$notice['id']?>">
                            <button class="read-more-btn">Read More</button>
                        </a>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    
    <?php if ($totalPages > 1) { ?>
        <div class="pagination">
            <?php if ($page > 1) { ?>
                <a href="?page=1&category=<?=$category?>&search=<?=$search?>">« First</a>
                <a href="?page=<?=$page-1?>&category=<?=$category?>&search=<?=$search?>">‹ Previous</a>
            <?php } ?>
            
            <?php 
            $start = max(1, $page - 2);
            $end = min($totalPages, $page + 2);
            if ($start > 1) echo '<span>...</span>';
            
            for ($i = $start; $i <= $end; $i++) { 
            ?>
                <?php if ($i == $page) { ?>
                    <span class="active"><?=$i?></span>
                <?php } else { ?>
                    <a href="?page=<?=$i?>&category=<?=$category?>&search=<?=$search?>"><?=$i?></a>
                <?php } ?>
            <?php } ?>
            
            <?php if ($end < $totalPages) echo '<span>...</span>'; ?>
            
            <?php if ($page < $totalPages) { ?>
                <a href="?page=<?=$page+1?>&category=<?=$category?>&search=<?=$search?>">Next ›</a>
                <a href="?page=<?=$totalPages?>&category=<?=$category?>&search=<?=$search?>">Last »</a>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<script>
// Auto-refresh every 5 minutes
setInterval(function() {
    location.reload();
}, 300000); // 300000 ms = 5 minutes

function searchNotices() {
    const search = document.getElementById('search').value;
    const category = document.getElementById('categoryFilter').value;
    
    if (search.length < 2) {
        location.href = '?search=&category=' + category;
        return;
    }
    
    fetch('notice_user_controller.php?action=search&key=' + encodeURIComponent(search))
    .then(res => res.json())
    .then(data => {
        const grid = document.getElementById('noticesGrid');
        grid.innerHTML = '';
        
        if (data.length === 0) {
            grid.innerHTML = '<div class="no-notices">No notices found</div>';
            return;
        }
        
        data.forEach(notice => {
            const categoryClass = 'badge-' + (notice.category || 'other').toLowerCase().replace(' ', '-');
            const importantClass = notice.is_important ? 'important' : '';
            const preview = notice.content.substring(0, 150) + (notice.content.length > 150 ? '...' : '');
            const date = new Date(notice.created_at).toLocaleDateString() + ' - ' + new Date(notice.created_at).toLocaleTimeString();
            
            const card = document.createElement('div');
            card.className = 'notice-card ' + importantClass;
            card.innerHTML = `
                <div class="notice-title">${notice.title}</div>
                <div class="notice-meta">
                    <div class="notice-date">${date}</div>
                    <span class="category-badge ${categoryClass}">${notice.category || 'Other'}</span>
                </div>
                <div class="notice-content">${preview}</div>
                <a href="notice_user_controller.php?action=view&id=${notice.id}">
                    <button class="read-more-btn">Read More</button>
                </a>
            `;
            grid.appendChild(card);
        });
    });
}

function filterByCategory() {
    const category = document.getElementById('categoryFilter').value;
    location.href = '?category=' + category;
}
</script>

</body>
</html>
