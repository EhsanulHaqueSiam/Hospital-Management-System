<!DOCTYPE html>
<html>
<head>
    <title>Hospital Notice Board</title>
</head>
<body>

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../admin_signin.php');
    exit;
}

$notices = isset($notices) ? $notices : [];
$totalPages = isset($totalPages) ? $totalPages : 1;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$search = isset($_GET['search']) ? $_GET['search'] : '';
?>

<?php include '../partials/navbar.php'; ?>

<h2>Hospital Notice Board</h2>

<p>
    <input type="text" id="search" placeholder="Search notices..." onkeyup="searchNotices()">
    <select id="categoryFilter" onchange="filterByCategory()">
        <option value="all">All Categories</option>
        <option value="General">General</option>
        <option value="Emergency">Emergency</option>
        <option value="Holiday">Holiday</option>
        <option value="Maintenance">Maintenance</option>
        <option value="Event">Event</option>
        <option value="Other">Other</option>
    </select>
</p>

<p style="color: #666; font-size: 0.9em;">Auto-refresh every 5 minutes</p>

<div id="noticesContainer">
    <table border="1" width="100%" cellpadding="10">
        <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Date</th>
            <th>Important</th>
            <th>Preview</th>
            <th>Action</th>
        </tr>

        <?php if (empty($notices)) { ?>
            <tr>
                <td colspan="6" align="center">No notices found</td>
            </tr>
        <?php } else { ?>
            <?php foreach ($notices as $notice) { ?>
                <tr style="<?php echo $notice['is_important'] ? 'background-color:#ffe6e6;' : ''; ?>">
                    <td><strong><?php echo htmlspecialchars($notice['title']); ?></strong></td>
                    <td><?php echo htmlspecialchars($notice['category'] ?? 'Other'); ?></td>
                    <td><?php echo date("M d, Y", strtotime($notice['created_at'])); ?></td>
                    <td><?php echo $notice['is_important'] ? 'YES' : 'NO'; ?></td>
                    <td><?php 
                        $preview = substr($notice['content'], 0, 100);
                        echo htmlspecialchars($preview) . (strlen($notice['content']) > 100 ? '...' : '');
                    ?></td>
                    <td>
                        <a href="notice_user_controller.php?action=view&id=<?=$notice['id']?>">View</a>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    </table>
</div>

<?php if (isset($totalPages) && $totalPages > 1) { ?>
    <p style="text-align: center; margin-top: 20px;">
        <?php if ($page > 1) { ?>
            <a href="?page=1&category=<?=$category?>&search=<?=$search?>">First</a> |
            <a href="?page=<?=$page-1?>&category=<?=$category?>&search=<?=$search?>">Previous</a> |
        <?php } ?>
        
        Page <?=$page?> of <?=$totalPages?>
        
        <?php if ($page < $totalPages) { ?>
            | <a href="?page=<?=$page+1?>&category=<?=$category?>&search=<?=$search?>">Next</a>
            | <a href="?page=<?=$totalPages?>&category=<?=$category?>&search=<?=$search?>">Last</a>
        <?php } ?>
    </p>
<?php } ?>

<script>
setInterval(function() {
    location.reload();
}, 300000);

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
        const table = document.querySelector('table tbody');
        if (!table) {
            const container = document.getElementById('noticesContainer');
            container.innerHTML = '<p>No notices found</p>';
            return;
        }
        
        let html = '<tr><th>Title</th><th>Category</th><th>Date</th><th>Important</th><th>Preview</th><th>Action</th></tr>';
        
        if (data.length === 0) {
            html += '<tr><td colspan="6" align="center">No notices found</td></tr>';
        } else {
            data.forEach(notice => {
                const bg = notice.is_important ? 'background-color:#ffe6e6;' : '';
                const preview = notice.content.substring(0, 100) + (notice.content.length > 100 ? '...' : '');
                const date = new Date(notice.created_at).toLocaleDateString();
                html += `
                    <tr style="${bg}">
                        <td><strong>${notice.title}</strong></td>
                        <td>${notice.category || 'Other'}</td>
                        <td>${date}</td>
                        <td>${notice.is_important ? 'YES' : 'NO'}</td>
                        <td>${preview}</td>
                        <td><a href="notice_user_controller.php?action=view&id=${notice.id}">View</a></td>
                    </tr>
                `;
            });
        }
        
        const container = document.getElementById('noticesContainer');
        container.innerHTML = '<table border="1" width="100%" cellpadding="10">' + html + '</table>';
    });
}

function filterByCategory() {
    const category = document.getElementById('categoryFilter').value;
    location.href = '?category=' + category;
}
</script>

</body>
</html>
