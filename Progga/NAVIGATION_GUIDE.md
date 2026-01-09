# Web Page Navigation Guide

## Application Flow

### 1. **Entry Point** - `Progga/index.php`
```
Redirects to → Admin Sign In Page
```

### 2. **Admin Sign In** - `Progga/view/admin_signin.php`
```
Form submits to → Progga/controller/admin_signin.php
```
**Navigation Links:**
- View Public Notices → `notice_user_controller.php`
- Create new admin account → `admin_signup.php`

**On Success (POST):**
- Redirects to → `notice_controller.php` (Admin Dashboard)

**On Failure:**
- Shows error message on same page

**URL Parameters:**
- `?session_expired=1` - Shows "Session expired" message
- `?created=1` - Shows "Admin account created successfully" message

---

### 3. **Admin Sign Up** - `Progga/view/admin_signup.php`
```
Form submits to → Progga/controller/admin_signup.php
```
**Navigation Links:**
- Back to Admin Sign In → `admin_signin.php`

**On Success (POST):**
- Saves admin to `models/admins.json`
- Redirects to → `admin_signin.php?created=1`

**On Failure:**
- Shows validation errors on same page

---

### 4. **Admin Notice Board** - `Progga/controller/notice_controller.php`
```
Actions:
- index (list) → Progga/view/notice/index.php
- create → Progga/view/notice/create.php
- store (POST) → Save & Redirect to index
- edit → Progga/view/notice/edit.php
- update (POST) → Save & Redirect to index
- delete → Delete & Redirect to index
- details → Progga/view/notice/details.php
```

---

### 5. **Public Notice Board** - `Progga/controller/notice_user_controller.php`
```
View Only - No admin login required
Shows all active notices
```

---

## Testing the Connection

### **Quick Test:**
1. Go to: `http://localhost/Progga/`
2. You'll be redirected to Sign In page
3. Use credentials:
   - Username: `admin`
   - Email: `admin@hospital.com`
   - Password: `admin123`
4. Click Sign In → Goes to Admin Notice Board
5. Click "Create new admin account" → Goes to Sign Up
6. Fill the form → Submits → Redirects back to Sign In with success message

---

## File Connections Summary

| Page | Controller | View |
|------|-----------|------|
| Sign In | `controller/admin_signin.php` | `view/admin_signin.php` |
| Sign Up | `controller/admin_signup.php` | `view/admin_signup.php` |
| Notice Board | `controller/notice_controller.php` | `view/notice/*.php` |
| Public Notices | `controller/notice_user_controller.php` | `view/notice_board.php` |

---

## How Page Navigation Works

### **Form-based Navigation (POST)**
```php
<form method="post" action="../controller/admin_signin.php">
    <!-- Form fields -->
</form>
```
→ Controller processes → Redirects to next page

### **Link-based Navigation (GET)**
```html
<a href="./admin_signup.php">Go to Sign Up</a>
```
→ Directly loads the page

### **Controller Redirects (After processing)**
```php
header('Location: ./notice_controller.php');
exit;
```
→ Sends user to new page after successful POST

---

## Common Issues & Fixes

| Issue | Solution |
|-------|----------|
| "Page not found" error | Check file paths use `../` correctly |
| Form not submitting | Ensure `action` attribute points to correct controller |
| Blank page after login | Check `notice_controller.php` has view files |
| Session timeout | Use "Remember me" checkbox to persist session |

