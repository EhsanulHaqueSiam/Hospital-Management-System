<?php
/**
 * MVC Architecture Documentation
 * Overview of the implemented MVC pattern
 */

# Hospital Management System - MVC Architecture

## Architecture Overview

This application implements a clean **Model-View-Controller (MVC)** architecture for maintainability, scalability, and separation of concerns.

## Directory Structure

```
Progga/
├── core/                    # Core MVC classes
│   ├── BaseController.php   # Base controller for all controllers
│   ├── BaseModel.php        # Base model for all models
│   ├── Router.php           # Application router
│   └── Config.php           # Configuration & autoloader
├── controller/              # Controllers (Business Logic)
│   ├── AdminSigninController.php
│   ├── NoticeController.php
│   └── NotificationController.php
├── models/                  # Models (Data Layer)
│   ├── NoticeModel.php
│   ├── NotificationModel.php
│   └── db.php
├── view/                    # Views (Presentation Layer)
│   ├── admin_signin.php
│   ├── notice/
│   ├── notifications/
│   └── partials/
└── index.php               # Application entry point
```

## MVC Components

### 1. **Models** (`models/` folder)
- Handle all database operations
- Contain business logic for data manipulation
- Extend `BaseModel` for common functionality
- Use prepared statements for security

**Example:**
```php
class NoticeModel extends BaseModel {
    public function getAllNotices() {
        // Database query logic
    }
}
```

### 2. **Controllers** (`controller/` folder)
- Handle HTTP requests
- Call appropriate models to fetch/store data
- Pass data to views for rendering
- Extend `BaseController` for common functionality

**Example:**
```php
class NoticeController extends BaseController {
    public function index() {
        $this->requireAdmin();
        $noticeModel = new NoticeModel();
        $notices = $noticeModel->getAllNotices();
        $this->view('../view/notice/index.php', ['notices' => $notices]);
    }
}
```

### 3. **Views** (`view/` folder)
- Display data to users
- Should contain minimal logic
- Receive data from controllers via `extract()`
- Focus on presentation

**Example:**
```php
<?php foreach ($notices as $notice): ?>
    <div><?php echo $notice['title']; ?></div>
<?php endforeach; ?>
```

## Core Classes

### BaseController
Provides common controller functionality:
- `requireAuth()` - Check user authentication
- `requireAdmin()` - Check admin privileges
- `view()` - Render views
- `redirect()` - Redirect to URL
- `json()` - Return JSON responses
- `getPost()`, `getGet()` - Get request parameters

### BaseModel
Provides common model functionality:
- Database connection management
- Query execution methods
- Error handling
- Row escaping for security

### Router
Maps HTTP requests to controllers:
- Register routes
- Dispatch requests to appropriate controllers
- Handle 404s

### Config
Central configuration and autoloading:
- Application constants
- Database configuration
- Autoloader for classes
- Bootstrap core classes

## Best Practices Implemented

✅ **Separation of Concerns** - Models, Controllers, Views are separate
✅ **Reusable Components** - Base classes for consistency
✅ **Security** - String escaping, session management, auth checks
✅ **Error Handling** - Centralized error management
✅ **Routing** - Request routing to controllers
✅ **Code Organization** - Logical folder structure
✅ **Database Abstraction** - Centralized database access
✅ **Session Management** - Built-in session & cookie support

## How to Extend

### Adding a New Feature

1. **Create Model** - `models/YourFeatureModel.php`
   ```php
   class YourFeatureModel extends BaseModel {
       public function getAll() { /* ... */ }
   }
   ```

2. **Create Controller** - `controller/YourFeatureController.php`
   ```php
   class YourFeatureController extends BaseController {
       public function index() { /* ... */ }
   }
   ```

3. **Create Views** - `view/yourfeature/list.php`, etc.
   ```php
   <?php foreach ($items as $item): ?>
       <!-- Display item -->
   <?php endforeach; ?>
   ```

## Security Features

- ✅ Database string escaping
- ✅ Session validation
- ✅ Authentication checks
- ✅ Admin privilege verification
- ✅ HTTPOnly cookies
- ✅ CSRF-ready structure

## Future Improvements

- [ ] Migrate to prepared statements (mysqli_prepare)
- [ ] Add validation layer
- [ ] Implement dependency injection
- [ ] Add logging system
- [ ] Create API layer
- [ ] Add unit tests
- [ ] Implement caching layer

