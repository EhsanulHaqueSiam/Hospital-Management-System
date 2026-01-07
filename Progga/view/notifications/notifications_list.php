<?php
// $notifications, $totalPages, $page, $status may be provided by controller
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Please login first.";
    exit;
}
$page = isset($page) ? (int)$page : 1;
$totalPages = isset($totalPages) ? (int)$totalPages : 1;
$status = isset($status) ? $status : 'all';
$notifications = isset($notifications) ? $notifications : [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Notifications</title>
    <style>
        .notification-item { padding:10px; border-bottom:1px solid #eee; }
        .notification-item.unread { background:#fff8e1; font-weight:bold; }
        .notification-item.read { color:#777; }
        .controls { margin-bottom:10px; }
    </style>
</head>
<body>
<h2>Notifications</h2>

<div class="controls">
    <label>Status:</label>
    <select id="statusFilter">
        <option value="all" <?php if(($status ?? '')=='all') echo 'selected'; ?>>All</option>
        <option value="unread" <?php if(($status ?? '')=='unread') echo 'selected'; ?>>Unread</option>
        <option value="read" <?php if(($status ?? '')=='read') echo 'selected'; ?>>Read</option>
    </select>
    <button id="markAllRead">Mark All Read</button>
    <button id="clearAllRead">Clear All Read</button>
</div>

<div id="list">
<?php if (empty($notifications)) { ?>
    <div>No notifications</div>
<?php } else { ?>
    <?php foreach($notifications as $n){ ?>
        <div class="notification-item <?php echo $n['is_read']? 'read':'unread'; ?>" data-id="<?php echo $n['id']; ?>">
            <span class="icon">[<?php echo htmlspecialchars($n['type']); ?>]</span>
            <a href="notification_controller.php?action=view&id=<?=$n['id']?>" class="notif-link"> <?php echo htmlspecialchars($n['message']); ?></a>
            <span class="time" data-ts="<?php echo $n['created_at']; ?>">just now</span>
            <?php if(!$n['is_read']){ ?>
                <button class="mark-read" title="Mark as read">✓</button>
            <?php } ?>
        </div>
    <?php } ?>
<?php } ?>
</div>

<div class="pagination">
    <?php if ($page > 1) { ?>
        <a href="?page=<?=$page-1?>&status=<?=$status?>">Previous</a>
    <?php } ?>
    Page <?=$page?> of <?=$totalPages?>
    <?php if ($page < $totalPages) { ?>
        <a href="?page=<?=$page+1?>&status=<?=$status?>">Next</a>
    <?php } ?>
</div>

<script>
function timeAgo(ts){
    const then = new Date(ts);
    const diff = Math.floor((Date.now() - then.getTime())/1000);
    if (diff < 60) return diff + 's ago';
    if (diff < 3600) return Math.floor(diff/60) + 'm ago';
    if (diff < 86400) return Math.floor(diff/3600) + 'h ago';
    return Math.floor(diff/86400) + 'd ago';
}
function refreshTimes(){
    document.querySelectorAll('.time').forEach(el=>{
        el.textContent = timeAgo(el.getAttribute('data-ts'));
    });
}
refreshTimes();

// AJAX handlers
function fetchNotifications(){
    const status = document.getElementById('statusFilter').value;
    const page = <?=$page?>;
    fetch('notification_controller.php?action=fetch&status='+status+'&page='+page)
    .then(r=>r.json())
    .then(data=>{
        const list = document.getElementById('list');
        if (!data.length) { list.innerHTML = '<div>No notifications</div>'; return; }
        list.innerHTML = '';
        data.forEach(n=>{
            const div = document.createElement('div');
            div.className = 'notification-item ' + (n.is_read? 'read':'unread');
            div.setAttribute('data-id', n.id);
            div.innerHTML = `<span class="icon">[${n.type}]</span> <a href="notification_controller.php?action=view&id=${n.id}" class="notif-link"> ${n.message}</a> <span class="time" data-ts="${n.created_at}">${n.created_at}</span> ${n.is_read? '': '<button class="mark-read" title="Mark as read">✓</button>'}`;
            list.appendChild(div);
        });
        refreshTimes();
    });
}

document.getElementById('statusFilter').addEventListener('change', ()=>{ location.href='?status='+document.getElementById('statusFilter').value; });

document.getElementById('list').addEventListener('click', e=>{
    if (e.target.classList.contains('mark-read')){
        const item = e.target.closest('.notification-item');
        const id = item.getAttribute('data-id');
        const isUnread = item.classList.contains('unread');
        
        fetch('notification_controller.php?action=mark_read', { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'}, body:'id='+id })
        .then(r=>r.json())
        .then(j=>{ 
            if (j.success) {
                // Update item styling
                item.classList.remove('unread');
                item.classList.add('read');
                
                // Remove the mark-read button
                e.target.remove();
                
                // Decrement unread badge if was unread (badge in dropdown navbar)
                if (isUnread && j.unread_count !== undefined) {
                    const badge = document.querySelector('#notifBadge');
                    if (badge) {
                        if (j.unread_count > 0) {
                            badge.textContent = j.unread_count;
                            badge.style.display = 'inline-block';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                }
            }
        })
        .catch(err=>console.error('Mark read failed:', err));
    }
});

document.getElementById('markAllRead').addEventListener('click', ()=>{
    fetch('notification_controller.php?action=mark_all_read', { method:'POST' })
    .then(r=>r.json())
    .then(j=>{ 
        if (j.success) {
            // Update all items from unread to read
            document.querySelectorAll('.notification-item.unread').forEach(item=>{
                item.classList.remove('unread');
                item.classList.add('read');
                const btn = item.querySelector('.mark-read');
                if (btn) btn.remove();
            });
            
            // Hide badge in dropdown navbar
            const badge = document.querySelector('#notifBadge');
            if (badge) badge.style.display = 'none';
        }
    });
});

document.getElementById('clearAllRead').addEventListener('click', ()=>{
    if (!confirm('Clear all read notifications?')) return;
    fetch('notification_controller.php?action=clear_all_read', { method:'POST' })
    .then(r=>r.json()).then(j=>{ if (j.success) fetchNotifications(); });
});

// auto-refresh every 60s
setInterval(fetchNotifications, 60000);
</script>

</body>
</html>
