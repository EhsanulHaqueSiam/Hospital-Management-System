function initDashboardRefresh() {
    var statsContainer = document.getElementById('stats-container');
    if (statsContainer) {
        setInterval(function () {
            console.log('Dashboard auto-refresh triggered');
        }, 30000);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    initDashboardRefresh();
});
