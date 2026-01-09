# Progga Folder Structure Summary

## Overview
All files in `Progga` are now properly connected with:
- **Lowercase filenames** in `core/` folder (snake_case convention)
- **Consistent require paths** using `__DIR__` for portability
- **Front controller** (`index.php`) for unified entry point
- **MVC architecture** with models, views, and controllers properly linked

---

## Directory Structure

```
Progga/
├── core/                          # Core framework files (lowercase names)
│   ├── base_model.php            # Base class for models
│   ├── base_controller.php       # Base class for controllers
│   ├── router.php                # Application router
│   ├── validator.php             # Form validation class
│   └── config.php                # Configuration & autoloader
│
├── controller/                    # Application controllers (procedural + classes)
│   ├── admin_signin.php          # Admin login controller
│   ├── admin_signup.php          # Admin registration controller
│   ├── notification_controller.php
│   ├── notice_controller.php
│   ├── notice_user_controller.php
│   ├── doctor_report_controller.php
│   ├── patient_report_controller.php
│   ├── revenue_report_controller.php
│   └── report_controller.php
│
├── models/                        # Database models
│   ├── db.php
│   ├── session_helper.php
│   ├── notification_model.php
│   ├── notice_model.php
│   ├── patient_model.php
│   ├── doctor_report_model.php
│   ├── revenue_report_model.php
│   └── admins.json
│
├── view/                          # View templates
│   ├── admin_signin.php
│   ├── admin_signup.php
│   ├── notice/
│   ├── notifications/
│   ├── partials/
│   └── reports/
│
├── public/                        # Static assets
│   ├── css/
│   │   └── validation.css
│   └── js/
│       └── validator.js
│
├── index.php                      # Front controller & explorer
├── config.xml                     # Configuration file
├── schema.sql                     # Database schema
├── MVC_ARCHITECTURE.md            # MVC documentation
├── NOTIFICATION_TEST_GUIDE.md     # Notification feature guide
├── MARK_AS_READ_IMPLEMENTATION.md # Mark-as-read implementation
├── JS_VALIDATION_GUIDE.md         # Validation documentation
└── test_login.php                 # Login test script
```

---

## Key Features Implemented

### 1. **File Naming Convention**
- All core files use **lowercase snake_case** (e.g., `base_model.php`, `base_controller.php`)
- Controllers use descriptive names ending in `_controller.php`
- Models use descriptive names ending in `_model.php`

### 2. **Consistent Path Resolution**
- All `require_once()` use `__DIR__` for reliable path resolution
- Example: `require_once(__DIR__ . '/../models/notification_model.php');`
- Eliminates path issues when scripts are moved or run from different locations

### 3. **Routing System**
- `core/router.php` provides URL-based request routing
- Fallback support for both class-based and procedural controllers
- Easy to extend for new routes

### 4. **Core Classes**
- **BaseModel**: Common database operations (query, fetch, escape)
- **BaseController**: Common controller functionality (auth, redirects, JSON responses)
- **Validator**: Server-side form validation and sanitization
- **Config**: Centralized configuration and autoloading

### 5. **Front Controller**
- `index.php` serves as the main entry point
- Provides explorer interface listing all controllers, models, and views
- Routes requests to appropriate controllers

### 6. **Security Features**
- ✅ Prepared statements / parameterized queries (models)
- ✅ Output escaping with `htmlspecialchars()` (views & Validator)
- ✅ Session security with HTTPOnly cookies (session_helper.php)
- ✅ Server-side validation (Validator class)
- ✅ AJAX/JSON support with Content-Type headers

### 7. **AJAX & JSON Implementation**
- Controllers return JSON responses with proper headers
- Notification dropdown with real-time updates
- Mark-as-read without page reload
- Search endpoints for notices

---

## Connection Map

### Admin Signin Flow
```
admin_signin.php (controller)
  ├── requires: session_helper.php (model)
  ├── requires: validator.php (core)
  ├── includes: admin_signin.php (view)
  └── sets session & redirects to notice_controller.php
```

### Notification Management Flow
```
notification_controller.php (controller)
  ├── requires: notification_model.php (model)
  ├── requires: validator.php (core)
  ├── AJAX endpoints:
  │   ├── /fetch - returns JSON list of notifications
  │   ├── /mark_read - marks single notification as read (POST)
  │   ├── /mark_all_read - marks all as read (POST)
  │   └── /dropdown - returns latest 5 + unread count (for navbar)
  └── includes: notifications_list.php (view)

notification_dropdown.php (partial view)
  └── JavaScript fetch() calls to notification_controller.php?action=dropdown
```

### Notice Management Flow
```
notice_controller.php (controller - Admin only)
  ├── requires: session_helper.php (model)
  ├── requires: notice_model.php (model)
  ├── requires: validator.php (core)
  ├── validates input with Validator::validate()
  ├── sanitizes with Validator::sanitize()
  └── includes: notice/*.php (views)

notice_user_controller.php (controller - Public board)
  ├── requires: notice_model.php (model)
  └── includes: notice/*.php (views)
```

---

## How to Use

### 1. **Access via Front Controller**
```
http://localhost/Hospital-Management-System/Progga/
```
Shows explorer with all available controllers, models, and views.

### 2. **Direct Controller Access**
```
http://localhost/Hospital-Management-System/Progga/admin_signin.php
http://localhost/Hospital-Management-System/Progga/notice_controller.php?action=index
```

### 3. **AJAX Calls**
```javascript
// JavaScript in views
fetch('notification_controller.php?action=dropdown')
  .then(r => r.json())
  .then(data => console.log(data));
```

---

## Database Connection
- **Host**: 127.0.0.1
- **Database**: hospital_management
- **User**: root
- **Password**: (empty)
- **Charset**: utf8mb4

Configured in: `models/db.php` and `core/config.php`

---

## Documentation Files
- **MVC_ARCHITECTURE.md** - Detailed architecture explanation
- **NOTIFICATION_TEST_GUIDE.md** - How to test notification features
- **MARK_AS_READ_IMPLEMENTATION.md** - Mark-as-read feature details
- **JS_VALIDATION_GUIDE.md** - Client-side validation documentation

---

## File Status Check
✅ All files in `core/` use lowercase names
✅ All controllers use `__DIR__`-based requires
✅ All models properly connected to controllers
✅ AJAX/JSON endpoints implemented
✅ Session & security features in place
✅ Front controller ready
✅ No duplicate file content in core files
