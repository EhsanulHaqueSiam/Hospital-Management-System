# Staff Management System - Documentation

## Overview
This document describes the complete Staff Management System for Hospital Management System Admin panel.

## Features Implemented

### 1. **View Staff List [Admin]**
A comprehensive staff management page that displays all non-admin users (Nurses, Receptionists, Pharmacists, Technicians, Other Staff).

### 2. **Table Structure**
The staff table displays the following columns:
- **Staff ID**: Unique identifier
- **Name**: Staff member's full name
- **Email**: Contact email
- **Role**: Position (Nurse, Receptionist, Pharmacist, Technician, Other Staff)
- **Department**: Department assigned
- **Phone**: Contact phone number
- **Status**: Active (Green) / Inactive (Gray)
- **Actions**: View, Edit, Activate/Deactivate, Delete

### 3. **Filtering & Search**

#### Role Filter
- Dropdown with options: All, Nurse, Receptionist, Pharmacist, Technician, Other Staff
- Filters staff by selected role

#### Department Filter
- Dynamic dropdown loaded from departments table
- Shows all departments
- Filters staff by selected department

#### AJAX Search Bar
- Real-time search by Name, Email, or Staff ID
- Minimum 2 characters for search trigger
- Displays up to 10 matching results as suggestions
- Click suggestion to navigate to staff view

#### Filter Controls
- **Filter Button**: Apply all selected filters
- **Reset Button**: Clear all filters and show all staff

### 4. **Status Management**

#### Status Display
- **Active Status**: Green badge with ✓ icon
- **Inactive Status**: Gray badge with ✗ icon

#### Status Actions
- **Active Staff**: "Deactivate" button to change status
- **Inactive Staff**: "Activate" button to reactivate
- Confirmation dialog before status change
- AJAX update with real-time feedback

### 5. **Pagination**
- **Records Per Page**: 20 staff members
- **Page Navigation**:
  - First, Previous, Next, Last buttons
  - Direct page number links
  - Disabled buttons for boundary conditions
  - Ellipsis (...) for skipped pages
  - Current page highlighted

### 6. **Actions**

#### View Details
- Navigates to staff profile page
- Shows complete staff information

#### Edit
- Opens edit form for staff information
- Allows updating staff details

#### Deactivate/Activate
- AJAX request to change status
- Immediate page refresh on success
- Confirmation dialog to prevent accidental changes

#### Delete
- Permanent deletion of staff member
- Confirmation dialog with warning message
- AJAX request with success feedback

### 7. **Export to XML**
- **File Name Format**: `staff_YYYY-MM-DD_HH-MM-SS.xml`
- **XML Structure**:
  ```xml
  <staff exportDate="2024-01-10 10:30:45" totalRecords="25">
      <member>
          <staffId>S001</staffId>
          <name>John Doe</name>
          <email>john@hospital.com</email>
          <role>Nurse</role>
          <department>ICU</department>
          <phone>+1234567890</phone>
          <status>Active</status>
          <joinDate>2023-01-15</joinDate>
      </member>
      <!-- more members -->
  </staff>
  ```
- **Respects Filters**: Exports based on current role/department filters

### 8. **Add Staff Button**
- Navigates to staff registration form
- Creates new staff member with validation

## File Structure

### Controllers
- **`admin_staff_router.php`**: Main router handling all staff-related actions
  - `action=list`: Display staff list (default)
  - `action=view`: Display staff details
  - `action=search`: AJAX search endpoint
  - `action=change_status`: AJAX status update
  - `action=delete`: AJAX delete staff
  - `action=export_xml`: Export to XML

- **`admin_staff_list.php`**: Legacy redirect to router

### Models
- **`staffModel.php`**: Database operations for staff management
  - `getAllStaff()`: Get paginated staff with filters
  - `getTotalStaffCount()`: Get total count with filters
  - `getStaffById()`: Get single staff member
  - `updateStaffStatus()`: Change staff status
  - `deleteStaff()`: Delete staff member
  - `searchStaff()`: AJAX search
  - `getAllStaffForExport()`: Get all staff for XML export
  - `isStaff()`: Check if user is staff

### Views
- **`admin_staff_list.php`**: Main staff list page
  - Full HTML with CSS styling
  - Responsive design (mobile-friendly)
  - JavaScript for interactivity
  - AJAX calls for dynamic operations

## Database Requirements

### Users Table Columns Needed
- `user_id`: INT PRIMARY KEY
- `staff_id`: VARCHAR (unique)
- `name`: VARCHAR
- `email`: VARCHAR
- `phone`: VARCHAR
- `role`: VARCHAR (should match staff roles)
- `department_id`: INT (foreign key to departments)
- `status`: TINYINT (0 = inactive, 1 = active)
- `created_at`: TIMESTAMP

### Departments Table Needed
- `department_id`: INT PRIMARY KEY
- `department_name`: VARCHAR

## Staff Roles
The system recognizes these roles:
- Nurse
- Receptionist
- Pharmacist
- Technician
- Other Staff

## Security Features

### Authentication
- Admin-only access check on router
- Session validation on page load
- Redirects unauthorized users to signin

### Authorization
- Admin role required for all operations
- Staff role check using const array

### Data Protection
- Prepared statements in model (mysqli)
- htmlspecialchars() for output escaping
- Input sanitization for search terms

### Confirmation Dialogs
- Delete operations require confirmation
- Status changes require confirmation
- Prevents accidental data loss

## API Endpoints (AJAX)

### Search Staff
```
GET ../controller/admin_staff_router.php?action=search&q=search_term
Response: JSON { results: [...] }
```

### Change Status
```
POST ../controller/admin_staff_router.php?action=change_status
Body: user_id=X&status=Y (0 or 1)
Response: JSON { success: bool, message: string }
```

### Delete Staff
```
POST ../controller/admin_staff_router.php?action=delete
Body: user_id=X
Response: JSON { success: bool, message: string }
```

### Export XML
```
GET ../controller/admin_staff_router.php?action=export_xml&role=X&department=Y
Response: XML file download
```

## Usage

### Access the Page
1. Login as Admin
2. Navigate to Staff Management (add link to main menu)
3. URL: `admin_staff_router.php`

### Filter Staff
1. Select Role from dropdown (optional)
2. Select Department from dropdown (optional)
3. Enter search term (name, email, staff ID)
4. Click "Filter" button
5. Click "Reset" to clear filters

### Manage Status
1. Locate staff member in table
2. Click "Activate" or "Deactivate" button
3. Confirm in dialog
4. Page auto-updates on success

### Delete Staff
1. Locate staff member in table
2. Click "Delete" button
3. Confirm deletion in dialog
4. Staff member removed from system

### Export Data
1. (Optional) Apply filters to select subset
2. Click "Export to XML" button
3. File automatically downloads as `staff_YYYY-MM-DD_HH-MM-SS.xml`

### Search & Navigate
1. Type in search box (min 2 characters)
2. Suggestions appear below input
3. Click suggestion to view staff details
4. Search respects currently applied filters

## Styling

### Responsive Design
- Mobile-first approach
- Grid layout for filters
- Flexible table with horizontal scroll on mobile
- Touch-friendly button sizes

### Color Coding
- **Blue (#2196F3)**: Primary actions (Filter, View, Info buttons)
- **Green (#4CAF50)**: Success actions (Active status, Export, Add)
- **Red (#f44336)**: Danger actions (Delete, Deactivate)
- **Orange (#ff9800)**: Warning actions (Edit)
- **Gray (#9E9E9E)**: Inactive status

### Responsive Breakpoint
- Mobile: < 768px
- Adjusts layout, font sizes, button widths

## Future Enhancements

1. **Bulk Operations**
   - Select multiple staff members
   - Bulk deactivate/activate
   - Bulk delete

2. **Advanced Filters**
   - Date range filtering
   - Status filtering
   - Active/Inactive toggle

3. **Import from CSV**
   - Upload staff data
   - Bulk create staff members

4. **Email Notifications**
   - Send status change notifications
   - Send account creation emails

5. **Activity Logging**
   - Track who modified staff records
   - Timestamp changes
   - Audit trail

6. **Staff Performance Dashboard**
   - Statistics by role/department
   - Active vs inactive counts
   - Hiring trends

## Troubleshooting

### Page Not Loading
- Check if user is authenticated and has Admin role
- Verify session is active
- Check if router file exists at `../controller/admin_staff_router.php`

### Database Errors
- Ensure `users` and `departments` tables exist
- Check column names match in staffModel.php
- Verify foreign key relationships

### Search Not Working
- Check minimum 2 character requirement
- Verify database connection
- Check browser console for JavaScript errors

### Export Not Working
- Check if SimpleXMLElement is enabled (PHP extension)
- Verify file permissions for downloads
- Check browser popup blocker settings

## Integration Checklist

- [ ] Staff model installed
- [ ] Router controller installed
- [ ] View page installed
- [ ] Navigation menu updated
- [ ] Database tables verified
- [ ] Admin authentication working
- [ ] AJAX endpoints tested
- [ ] Export functionality tested
- [ ] Mobile responsiveness verified
- [ ] All filters working
- [ ] Status updates functioning
- [ ] Delete operations confirmed
- [ ] Search suggestions appearing

