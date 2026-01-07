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

<div id="successMsg" style="display:none;padding:8px;background:#e6ffed;border:1px solid #b7f0c6;margin:8px 0;color:#114b22;"></div>

<!-- Confirmation Modal -->
<div id="confirmModal" style="display:none;position:fixed;left:0;top:0;right:0;bottom:0;background:rgba(0,0,0,0.4);align-items:center;justify-content:center;z-index:2000;">
    <div style="background:white;padding:18px;border-radius:6px;max-width:420px;margin:auto;box-shadow:0 8px 24px rgba(0,0,0,0.2);">
        <h3 style="margin-top:0">Delete all read notifications?</h3>
        <p>Are you sure you want to permanently delete all read notifications? This cannot be undone.</p>
        <div style="text-align:right;margin-top:12px;display:flex;gap:8px;justify-content:flex-end;">
            <button id="confirmCancel" style="background:#f1f1f1;border:1px solid #ddd;padding:6px 10px;border-radius:4px;">Cancel</button>
            <button id="confirmOk" style="background:#e74c3c;color:#fff;border:none;padding:6px 10px;border-radius:4px;">Delete</button>
        </div>
    </div>
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

// Clear All Read with confirmation modal and AJAX removal
const confirmModal = document.getElementById('confirmModal');
const confirmOk = document.getElementById('confirmOk');
const confirmCancel = document.getElementById('confirmCancel');
const successMsg = document.getElementById('successMsg');

document.getElementById('clearAllRead').addEventListener('click', ()=>{
    if (!confirmModal) return;
    confirmModal.style.display = 'flex';
});

function closeConfirm(){ if (confirmModal) confirmModal.style.display = 'none'; }

confirmCancel.addEventListener('click', ()=>{ closeConfirm(); });

confirmOk.addEventListener('click', ()=>{
    confirmOk.disabled = true;
    fetch('notification_controller.php?action=clear_all_read', { method:'POST' })
    .then(r=>r.json())
    .then(j=>{
        confirmOk.disabled = false;
        closeConfirm();
        if (j.success){
            // Remove all read items from DOM
            document.querySelectorAll('.notification-item.read').forEach(it=> it.remove());

            // Show success message
            if (successMsg){
                successMsg.textContent = 'Read notifications cleared!';
                successMsg.style.display = 'block';
                setTimeout(()=>{ successMsg.style.display = 'none'; }, 3500);
            }

            // Refresh dropdown/badge if present
            fetch('notification_controller.php?action=dropdown')
            .then(r=>r.json())
            .then(d=>{
                const badge = document.querySelector('#notifBadge');
                if (badge){
                    if (d.unread_count && d.unread_count > 0){ badge.textContent = d.unread_count; badge.style.display='inline-block'; }
                    else badge.style.display = 'none';
                }
                // Optionally refresh cached dropdown items if open
                if (window._notif_latest !== undefined) window._notif_latest = d.notifications || [];
            }).catch(()=>{});
        }
    })
    .catch(err=>{ confirmOk.disabled=false; closeConfirm(); console.error('Clear all read failed', err); });
});

// auto-refresh every 60s
setInterval(fetchNotifications, 60000);
</script>

</body>
</html>
