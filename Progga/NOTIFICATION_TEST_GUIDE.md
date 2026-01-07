# Notification Management - Mark as Read Feature Test Guide

## Feature Summary
The "Mark as Read" feature has been fully implemented with AJAX support and real-time UI updates.

## Components Implemented

### 1. Database
- Table: `notifications`
- Columns: `id`, `user_id`, `type`, `message`, `link`, `is_read`, `read_at`, `created_at`
- New column: `read_at TIMESTAMP NULL DEFAULT NULL` - stores when notification was marked as read

### 2. Backend (Controller)
**File**: `Progga/controller/notification_controller.php`
- Action: `mark_read` (POST)
  - Input: `id` (notification ID)
  - Output: JSON with `success` boolean and `unread_count` (updated count after mark)
  - Updates: Sets `is_read=1` and `read_at=NOW()` in database
  
- Action: `mark_all_read` (POST)
  - Input: None
  - Output: JSON with `success` boolean
  - Updates: Marks all unread notifications for user as read with timestamp

- Action: `dropdown` (GET)
  - Returns: Latest 5 notifications + unread count for navbar bell badge

- Action: `view` (GET with ID)
  - Auto-marks notification as read, then redirects to link

### 3. Frontend - Navbar Dropdown
**File**: `Progga/view/partials/notification_dropdown.php`
- Bell icon with unread badge (red circle with count)
- Latest 5 notifications with unread styling (yellow background, bold)
- Click on notification: marks read via AJAX, updates styling, decrements badge, then redirects
- Auto-refresh badge every 30 seconds
- "View All" link to full notifications list

**Features**:
- Badge updates in real-time when notification marked read
- Item styling changes from unread (yellow/bold) to read (gray)
- Unread count decremented automatically

### 4. Frontend - Full Notifications Page
**File**: `Progga/view/notifications/notifications_list.php`
- Displays all notifications with filtering (All/Unread/Read)
- Pagination: 20 per page
- Each unread notification has a checkmark (✓) button to mark read
- Status filters: All / Unread / Read

**Mark Read Features**:
1. Click checkmark button on unread notification
2. AJAX POST to `notification_controller.php?action=mark_read`
3. UI updates WITHOUT page reload:
   - Notification item styling changes from `unread` to `read` class
   - Yellow background removed, text becomes gray
   - Checkmark button is removed
   - Navbar badge count is decremented (if navbar is present)

**Mark All Read Features**:
1. Click "Mark All Read" button
2. AJAX POST to `notification_controller.php?action=mark_all_read`
3. All unread notifications:
   - Styling changes to read
   - Checkmark buttons removed
   - Navbar badge hidden

## How to Test

### Test Case 1: Mark Single Notification as Read
1. Create a test notification for a user (insert into database manually or via system)
2. Login as that user
3. Go to `Progga/controller/notification_controller.php?action=list`
4. Find an unread notification (yellow background, bold text)
5. Click the checkmark (✓) button
6. **Expected Results**:
   - Notification styling changes to gray/read immediately
   - Checkmark button disappears
   - Page doesn't reload
   - If navbar dropdown is visible, badge count decrements

### Test Case 2: Mark All as Read
1. Ensure multiple unread notifications exist for the user
2. Click "Mark All Read" button
3. **Expected Results**:
   - All unread notifications change to read styling
   - All checkmark buttons disappear
   - Navbar badge disappears or shows 0
   - No page reload

### Test Case 3: Navbar Dropdown Integration
1. Include `Progga/view/partials/notification_dropdown.php` in your navbar
2. Click the bell icon (🔔)
3. Click on a notification in the dropdown
4. **Expected Results**:
   - Notification marked read via AJAX
   - Item styling updates immediately
   - Badge decrements
   - User is redirected to notification link (or back to notifications list if no link)

### Test Case 4: Auto-Badge Update
1. Have the navbar dropdown open
2. In another browser tab, mark a notification as read
3. Wait up to 30 seconds for badge to update automatically
4. **Expected Results**:
   - Badge count decreases automatically

## SQL Queries for Testing

### Insert test notification:
```sql
INSERT INTO notifications (user_id, type, message, link, is_read, created_at) 
VALUES (1, 'INFO', 'Test notification', '/test', 0, NOW());
```

### Check notification status:
```sql
SELECT id, user_id, type, message, is_read, read_at, created_at 
FROM notifications 
WHERE user_id = 1 
ORDER BY created_at DESC;
```

### Count unread for user:
```sql
SELECT COUNT(*) as unread FROM notifications 
WHERE user_id = 1 AND is_read = 0;
```

## API Endpoint Reference

### Mark Single Read
```
POST /Project/Hospital-Management-System/Progga/controller/notification_controller.php?action=mark_read
Body: id=123

Response: {"success":true,"unread_count":5}
```

### Mark All Read
```
POST /Project/Hospital-Management-System/Progga/controller/notification_controller.php?action=mark_all_read

Response: {"success":true}
```

### Get Dropdown Data
```
GET /Project/Hospital-Management-System/Progga/controller/notification_controller.php?action=dropdown

Response: {
  "unread_count": 5,
  "notifications": [
    {
      "id": 1,
      "type": "INFO",
      "message": "Test",
      "is_read": 0,
      "created_at": "2024-01-01 12:00:00"
    }
  ]
}
```

## Key Technical Details

### Session Requirements
- `$_SESSION['user_id']` must be set
- `$_SESSION['role']` should be set ('Admin', 'Doctor', 'Patient')

### AJAX Headers
- Content-Type: application/x-www-form-urlencoded
- POST body: `id=123` or empty for mark_all_read

### Database Updates
- Table: `notifications`
- Updates column: `is_read` (1 for read) and `read_at` (timestamp)
- Filter by: `user_id` to ensure user can only mark their own notifications

### Styling Classes
- `.unread` - Yellow background (#fff8e1), bold text
- `.read` - Gray text (#777)

## Troubleshooting

**Issue**: Badge not updating
- Check if navbar dropdown is included in page
- Verify `#notifBadge` element exists in dropdown
- Check browser console for JavaScript errors

**Issue**: Notification not marked read in database
- Verify POST request is being sent (check Network tab)
- Check `notification_controller.php` has `mark_read` action
- Verify `$_SESSION['user_id']` is set

**Issue**: Button not disappearing
- Check if `.mark-read` element is being properly removed
- Verify JavaScript event listener is attached to `#list` element

**Issue**: Styling not changing
- Verify CSS for `.unread` and `.read` classes exists in page
- Check if element classes are being updated with `classList.remove()` and `classList.add()`

## Files Modified/Created

1. `Progga/controller/notification_controller.php` - Added `mark_read` endpoint with unread_count return
2. `Progga/models/notification_model.php` - Updated functions to record `read_at` timestamp
3. `Progga/view/notifications/notifications_list.php` - Enhanced AJAX handlers for UI updates
4. `Progga/view/partials/notification_dropdown.php` - Enhanced mark_read handling with badge decrement
5. Database: Added `read_at TIMESTAMP NULL DEFAULT NULL` column to notifications table

## Completion Status
✅ Backend API fully implemented
✅ Database schema updated
✅ Navbar dropdown component created
✅ Full notifications list page created
✅ AJAX mark-as-read without page reload
✅ Badge auto-decrement on mark read
✅ Styling changes (unread → read)
✅ Button removal on mark read
✅ Timestamp recording for read_at

**Ready for integration into main application!**
