<?php
// Include this partial where your navbar is rendered.
// It expects sessions to be started and user to be logged in. If not logged in, it shows a link to sign in.
if (!isset($_SESSION)) session_start();
?>

<style>
.notif-bell { position: relative; background: none; border: none; cursor: pointer; font-size: 18px; }
.notif-badge { position: absolute; top: -6px; right: -6px; background: #e74c3c; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px; }
.notif-menu { position: absolute; right: 0; top: 28px; width: 320px; max-height: 420px; overflow:auto; border:1px solid #ddd; background:white; box-shadow:0 6px 18px rgba(0,0,0,0.1); display:none; z-index:1000; }
.notif-item { padding:8px 10px; border-bottom:1px solid #f1f1f1; display:flex; gap:8px; align-items:center; }
.notif-item.unread { background:#fff8e1; font-weight:bold; }
.notif-item.read { color:#777; }
.notif-item .msg { flex:1; }
.notif-footer { padding:8px; text-align:center; border-top:1px solid #eee; }
</style>

<div id="notifRoot" style="position:relative; display:inline-block;">
<?php if (isset($_SESSION['user_id'])) { ?>
    <button id="notifBell" class="notif-bell" aria-haspopup="true" aria-expanded="false">🔔 <span id="notifBadge" class="notif-badge" style="display:none">0</span></button>
    <div id="notifMenu" class="notif-menu" role="menu">
        <div id="notifItems">Loading...</div>
        <div class="notif-footer"><a href="/Project/Hospital-Management-System/Progga/controller/notification_controller.php?action=list">View All</a></div>
    </div>
<?php } else { ?>
    <a href="/Project/Hospital-Management-System/Progga/view/admin_signin.php">Sign in to see notifications</a>
<?php } ?>
</div>

<script>
(function(){
    const bell = document.getElementById('notifBell');
    const menu = document.getElementById('notifMenu');
    const itemsEl = document.getElementById('notifItems');
    const badge = document.getElementById('notifBadge');
    let menuOpen = false;

    function renderItems(data){
        if (!itemsEl) return;
        itemsEl.innerHTML = '';
        if (!data || !data.notifications || data.notifications.length === 0){
            itemsEl.innerHTML = '<div style="padding:10px; color:#666">No new notifications</div>';
            return;
        }
        data.notifications.forEach(n=>{
            const div = document.createElement('div');
            div.className = 'notif-item ' + (n.is_read? 'read' : 'unread');
            div.setAttribute('data-id', n.id);
            const icon = document.createElement('div');
            icon.textContent = n.type || '•';
            icon.style.width = '36px';
            icon.style.flex = '0 0 36px';
            icon.style.textAlign = 'center';
            icon.style.opacity = '0.9';
            const msg = document.createElement('div');
            msg.className = 'msg';
            const txt = (n.message.length>50) ? n.message.substring(0,50)+'...' : n.message;
            msg.innerHTML = '<a href="#" class="notif-link">'+escapeHtml(txt)+'</a><div style="font-size:11px;color:#999">'+timeAgo(n.created_at)+'</div>';
            div.appendChild(icon);
            div.appendChild(msg);
            itemsEl.appendChild(div);
        });
    }

    function escapeHtml(s){ return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

    function timeAgo(ts){
        const then = new Date(ts);
        const diff = Math.floor((Date.now() - then.getTime())/1000);
        if (diff < 60) return diff + 's ago';
        if (diff < 3600) return Math.floor(diff/60) + 'm ago';
        if (diff < 86400) return Math.floor(diff/3600) + 'h ago';
        return Math.floor(diff/86400) + 'd ago';
    }

    function updateBadge(count){
        if (!badge) return;
        if (count && count > 0){ badge.style.display='inline-block'; badge.textContent = count; }
        else badge.style.display='none';
    }

    function fetchDropdown(){
        fetch('notification_controller.php?action=dropdown')
        .then(r=>r.json())
        .then(data=>{
            updateBadge(data.unread_count);
            // store latest notifications for menu rendering
            window._notif_latest = data.notifications || [];
            if (menuOpen) renderItems(data);
        }).catch(()=>{});
    }

    function openMenu(){
        if (!menu) return;
        menu.style.display = 'block';
        menuOpen = true;
        // render existing cached notifications if available
        if (window._notif_latest) renderItems({notifications:window._notif_latest});
        else fetchDropdown();
    }
    function closeMenu(){ if (!menu) return; menu.style.display='none'; menuOpen=false; }

    if (bell){
        bell.addEventListener('click', function(e){
            e.stopPropagation();
            if (menuOpen) closeMenu(); else openMenu();
        });
    }

    document.addEventListener('click', function(){ if (menuOpen) closeMenu(); });

    // delegate click on notification link inside menu
    document.addEventListener('click', function(e){
        const link = e.target.closest('.notif-link');
        if (!link) return;
        e.preventDefault();
        const item = e.target.closest('.notif-item');
        if (!item) return;
        const id = item.getAttribute('data-id');
        const wasUnread = item.classList.contains('unread');
        
        // mark read then redirect to view endpoint which will redirect to real link
        fetch('notification_controller.php?action=mark_read', { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'}, body:'id='+encodeURIComponent(id) })
        .then(r=>r.json())
        .then(j=>{
            if (j.success) {
                // Update item styling in menu
                item.classList.remove('unread');
                item.classList.add('read');
                
                // Decrement badge if it was unread
                if (wasUnread && j.unread_count !== undefined) {
                    updateBadge(j.unread_count);
                }
            }
            // close menu and go to view (controller view will redirect to link if exists)
            closeMenu();
            window.location.href = 'notification_controller.php?action=view&id='+encodeURIComponent(id);
        })
        .catch(err=>{
            console.error('Mark read error:', err);
            // close menu and go to view (controller view will redirect to link if exists)
            closeMenu();
            window.location.href = 'notification_controller.php?action=view&id='+encodeURIComponent(id);
        });
    });

    // auto update badge every 30s
    fetchDropdown();
    setInterval(fetchDropdown, 30000);
})();
</script>
