# 🧪 Resident Portal - Testing Guide

## Prerequisites

Before testing, ensure:
1. ✅ Laravel development environment is running
2. ✅ Database is migrated (`php artisan migrate`)
3. ✅ You have a test resident user account
4. ✅ The resident user has an associated resident profile in the database

---

## 📋 Test User Setup

### Create a Test Resident Account (if needed)

```bash
# Create resident seeder if it doesn't exist
php artisan make:seeder ResidentUserSeeder

# Run existing seeder
php artisan db:seed --class=ResidentUserSeeder

# Or manually via database:
# INSERT INTO users (name, email, password, role, email_verified_at) 
# VALUES ('John Doe', 'john@example.com', bcrypt('password'), 'resident', NOW());

# INSERT INTO residents (user_id, name, age, address, plate_number, car_model, car_color, contact_number) 
# VALUES (2, 'John Doe', 30, '123 Main St', 'ABC-1234', 'Honda Civic', 'White', '555-1234');
```

### Test Credentials
- **Email**: john@example.com (or your seeded resident email)
- **Password**: password
- **Role**: resident

---

## 🧪 Test Cases

### Test 1: Authentication & Access Control
**Objective**: Verify resident routes are protected

```
✓ Test 1.1: Anonymous user cannot access /resident/dashboard
  - Visit: http://localhost:8000/resident/dashboard
  - Expected: Redirected to login page
  
✓ Test 1.2: Admin user cannot access resident routes
  - Login as admin
  - Visit: http://localhost:8000/resident/dashboard
  - Expected: Access denied or redirect (if using resident role check)
  
✓ Test 1.3: Resident user can access /resident/dashboard
  - Login as resident
  - Visit: http://localhost:8000/resident/dashboard
  - Expected: Dashboard page loads with resident data
```

### Test 2: Dashboard
**Objective**: Verify dashboard displays data correctly

```
✓ Test 2.1: Quick summary cards display
  - Navigate to: /resident/dashboard
  - Expected: Three summary cards visible
    - Last Entry time (or "No entries yet")
    - Last Exit time (or "No exits yet")
    - Access Status (shows total and unauthorized count)
  
✓ Test 2.2: Recent notifications preview
  - Expected: Shows up to 5 notifications
  - Expected: "View All" link present
  - Expected: If no notifications, shows empty state
  
✓ Test 2.3: Quick links section
  - Expected: 3 quick link cards:
    - 👤 My Profile
    - 📊 Gate Logs
    - 📤 Update Request
  - Expected: All links are clickable and route correctly
```

### Test 3: My Profile - View
**Objective**: Verify profile display

```
✓ Test 3.1: Personal information displayed
  - Navigate to: /resident/profile
  - Expected: Shows resident name, age, contact, address
  
✓ Test 3.2: Vehicle information displayed
  - Expected: Shows plate number (in monospace font), car model, color
  
✓ Test 3.3: Account information sidebar
  - Expected: Shows email, member since date, access status (Active/green)
  
✓ Test 3.4: Edit profile button
  - Expected: Button present and links to /resident/profile/edit
```

### Test 4: My Profile - Edit
**Objective**: Verify profile update form and submission

```
✓ Test 4.1: Form loads correctly
  - Navigate to: /resident/profile/edit
  - Expected: Form populated with current resident data
  
✓ Test 4.2: Field validation - required fields
  - Clear "Full Name" field
  - Click "Submit Changes"
  - Expected: Error message "The name field is required"
  
✓ Test 4.3: Field validation - age range
  - Enter age: 200
  - Click "Submit Changes"
  - Expected: Error message about max age
  
✓ Test 4.4: Submit valid changes
  - Change: Name to "John Smith"
  - Change: Plate # to "XYZ-5678"
  - Click "Submit Changes"
  - Expected: Success message and redirect to /resident/update-requests
  
✓ Test 4.5: No changes submitted
  - Load edit form with current data
  - Don't change anything
  - Click "Submit Changes"
  - Expected: Info message "No changes were made"
  
✓ Test 4.6: Cancel button
  - Click "Cancel"
  - Expected: Redirected to /resident/profile
```

### Test 5: Gate Logs
**Objective**: Verify access history display

```
✓ Test 5.1: Summary cards
  - Navigate to: /resident/gate-logs
  - Expected: Three summary cards:
    - Total Entries Today (number)
    - Total Exits Today (number)
    - Unauthorized Attempts (number in red if > 0)
  
✓ Test 5.2: Logs table (if data exists)
  - Expected: Table columns:
    - Date & Time (with timestamp)
    - Status (AUTHORIZED/UNAUTHORIZED with color badge)
    - Access Type (Entry/Exit icon)
    - Plate Number
    - Image (View button if image exists)
  
✓ Test 5.3: No logs message
  - For new resident with no logs:
  - Expected: "📭 No gate logs found" message
  
✓ Test 5.4: Image preview modal
  - If logs with images exist:
  - Click "View" button
  - Expected: Modal opens with image displayed
  - Click X or outside modal: Modal closes
  
✓ Test 5.5: Pagination
  - If > 15 logs exist:
  - Expected: Pagination controls shown
  - Click next page: Loads next 15 logs
```

### Test 6: Notifications
**Objective**: Verify notification display and actions

```
✓ Test 6.1: Notifications display
  - Navigate to: /resident/notifications
  - Expected: List of notifications with:
    - Title/message
    - Type badge (colored)
    - Timestamp (relative time)
    - Unread indicator (blue left border)
  
✓ Test 6.2: Unread count
  - Expected: Badge showing "X Unread" if unread exist
  
✓ Test 6.3: Mark as read button
  - Click "Mark as read" on unread notification
  - Expected: Notification styles change (no blue border)
  
✓ Test 6.4: Mark all as read
  - Click "Mark all as read" button
  - Expected: All unread indicators disappear
  
✓ Test 6.5: Empty state
  - For user with no notifications:
  - Expected: "🎉 No notifications" message
  
✓ Test 6.6: Pagination
  - If > 20 notifications:
  - Expected: Pagination controls shown
```

### Test 7: Update Requests
**Objective**: Verify request tracking

```
✓ Test 7.1: Summary stats
  - Navigate to: /resident/update-requests
  - Expected: Four summary cards:
    - Total Requests (count)
    - Pending (yellow badge)
    - Approved (green badge)
    - Rejected (red badge)
  
✓ Test 7.2: Submit new request button
  - Click "Submit New Request"
  - Expected: Redirected to /resident/profile/edit
  
✓ Test 7.3: Request display (pending)
  - Expected for pending request:
    - Request ID and "PENDING" badge
    - Submission date/time
    - Requested changes in detail cards
    - Status timeline with animated pulse on pending
  
✓ Test 7.4: Request display (approved)
  - Expected: "APPROVED" green badge
  - Expected: Approval timestamp in timeline
  
✓ Test 7.5: Request display (rejected)
  - Expected: "REJECTED" red badge
  - Expected: Admin remarks displayed in red box
  - Expected: "Try Again" button (links to edit profile)
  
✓ Test 7.6: Empty state
  - For new resident with no requests:
  - Expected: "📋 No update requests yet" message
  - Expected: "Submit Request" button visible
```

### Test 8: Help & Support
**Objective**: Verify help content and FAQ

```
✓ Test 8.1: Contact options display
  - Navigate to: /resident/help
  - Expected: Three contact sections:
    - 💬 Live Chat (with button)
    - ☎️ Call Us (with phone number)
    - ✉️ Email Support (with email address)
  
✓ Test 8.2: FAQ expand/collapse
  - Click on FAQ question
  - Expected: Answer expands smoothly
  - Click again: Answer collapses
  - Click different question: Previous closes, new opens
  
✓ Test 8.3: Troubleshooting grid
  - Expected: Four troubleshooting categories visible
  - Expected: Bullet points with solutions readable
  
✓ Test 8.4: Emergency contact
  - Expected: Red alert section visible
  - Expected: Emergency number displayed prominently
```

### Test 9: Navigation & Sidebar
**Objective**: Verify menu navigation

```
✓ Test 9.1: Sidebar menu for resident
  - Login as resident
  - Expected: Sidebar shows resident-specific items:
    - 🏠 Dashboard
    - 👤 My Profile
    - 📊 Gate Logs
    - 🔔 Notifications
    - 📤 Update Requests
    - 📞 Help & Support
  
✓ Test 9.2: Active menu highlighting
  - Navigate to /resident/profile
  - Expected: "My Profile" menu item is highlighted
  
✓ Test 9.3: Admin doesn't see resident menu
  - Login as admin
  - Expected: Admin menu items visible instead
  - Expected: Resident menu items NOT visible
```

### Test 10: Responsive Design
**Objective**: Test on different screen sizes

```
✓ Test 10.1: Desktop view (1200px+)
  - Expected: Multi-column layouts
  - Expected: Sidebars visible
  
✓ Test 10.2: Tablet view (768px - 1024px)
  - Expected: 2-column grids
  - Expected: Proper spacing
  
✓ Test 10.3: Mobile view (< 768px)
  - Expected: Single column
  - Expected: Buttons are touch-friendly
  - Expected: Table is scrollable
  - Expected: Sidebar is collapsible/hidden
```

### Test 11: Dark Mode
**Objective**: Verify dark theme support

```
✓ Test 11.1: Dark mode applies to all pages
  - System set to dark mode
  - Expected: All pages have dark background
  - Expected: Text is readable
  - Expected: Form inputs are properly styled
  
✓ Test 11.2: Color contrast
  - Expected: All text meets WCAG AA standards
```

### Test 12: Form Validation
**Objective**: Test form error handling

```
✓ Test 12.1: Validation messages
  - Submit empty required field
  - Expected: Error message displayed below field
  - Expected: Field has red border
  
✓ Test 12.2: Success messages
  - Submit valid form
  - Expected: Success notification displayed
  - Expected: Redirect to appropriate page
```

---

## 🔄 Database Test Data

### Create Test Gate Logs

```sql
-- For testing gate logs display
INSERT INTO gate_logs (resident_id, plate_number, status, timestamp, image_path) VALUES
(1, 'ABC-1234', 'entry', NOW(), NULL),
(1, 'ABC-1234', 'exit', DATE_SUB(NOW(), INTERVAL 4 HOUR), NULL),
(1, 'ABC-1234', 'entry', DATE_SUB(NOW(), INTERVAL 1 DAY), NULL),
(1, 'ABC-1234', 'unauthorized', DATE_SUB(NOW(), INTERVAL 2 DAY), NULL);
```

### Create Test Notifications

```sql
-- For testing notifications display
INSERT INTO notifications (user_id, title, message, type, read_at) VALUES
(2, 'Gate opened at 10:30 AM', 'You successfully entered the subdivision', 'gate_access', NULL),
(2, 'Unauthorized attempt detected', 'An unauthorized attempt with your plate was detected', 'unauthorized', NULL),
(2, 'Profile Update Approved', 'Your profile changes were approved by admin', 'update_approved', NOW());
```

### Create Test Update Requests

```sql
-- For testing update request tracking
INSERT INTO update_requests (resident_id, status, requested_changes, admin_remarks) VALUES
(1, 'pending', '{"name": "John Smith", "plate_number": "XYZ-5678"}', NULL),
(1, 'approved', '{"car_model": "Toyota Camry"}', NULL),
(1, 'rejected', '{"address": "456 Oak St"}', 'Address verification failed. Please contact admin.');
```

---

## 🐛 Common Issues & Troubleshooting

### Issue: Resident routes not accessible
**Solution**: 
- Verify user role is set to 'resident'
- Check `EnsureUserIsResident` middleware is registered
- Clear route cache: `php artisan route:clear`

### Issue: Profile images not displaying
**Solution**:
- Ensure storage is linked: `php artisan storage:link`
- Check file permissions on storage/app directory
- Verify image paths in database start with "public/"

### Issue: Notifications not showing
**Solution**:
- Verify `Notification` model exists
- Check user has notifications in database
- Clear cache: `php artisan cache:clear`

### Issue: Validation not working
**Solution**:
- Check ProfileController has proper validation
- Verify request is POST/PUT with correct method
- Check for CSRF token in forms

---

## ✅ Quality Checklist

Before deploying to production:

- [ ] All 12 test sections passed
- [ ] No console errors in browser DevTools
- [ ] Dark mode works on all pages
- [ ] Responsive design tested on 3+ devices
- [ ] Database performance acceptable (< 200ms queries)
- [ ] No hardcoded test data in code
- [ ] Support contact info updated with real numbers
- [ ] Error messages are user-friendly
- [ ] CSRF protection enabled
- [ ] Rate limiting configured if needed
- [ ] Backup/restore tested
- [ ] Load tested with multiple concurrent users

---

## 📊 Performance Benchmarks

Expected page load times (first meaningful paint):
- Dashboard: < 1.5s
- Profile: < 1s
- Gate Logs: < 2s (depends on log count)
- Notifications: < 1.5s
- Update Requests: < 1.5s

---

## 🚀 Deployment Checklist

```bash
# Before deploying:
php artisan config:cache      # Cache configuration
php artisan route:cache       # Cache routes
php artisan view:cache        # Cache views
php artisan migrate --force   # Run migrations
php artisan storage:link      # Link storage
```

---

**Test Date**: _____________
**Tested By**: _____________
**Status**: ☐ PASS ☐ FAIL
**Notes**: _________________________________________________________________

---

Generated: December 27, 2025
