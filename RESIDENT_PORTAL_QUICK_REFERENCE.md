# 🏘️ Resident Portal - Quick Reference Guide

## 📍 Access Points

| Feature | URL | Icon | Description |
|---------|-----|------|-------------|
| Dashboard | `/resident/dashboard` | 🏠 | Overview of gate activity & notifications |
| My Profile | `/resident/profile` | 👤 | View personal & vehicle information |
| Edit Profile | `/resident/profile/edit` | ✏️ | Submit changes for admin approval |
| Gate Logs | `/resident/gate-logs` | 📊 | View access history with plate images |
| Notifications | `/resident/notifications` | 🔔 | System alerts & access notifications |
| Update Requests | `/resident/update-requests` | 📤 | Track profile change requests |
| Help & Support | `/resident/help` | 📞 | FAQ, troubleshooting, contact info |

---

## 🎨 Page Overview

### 1️⃣ Dashboard (`/resident/dashboard`)
```
┌─────────────────────────────────────┐
│ Welcome, [Name]!                    │
├─────────────────────────────────────┤
│ [Last Entry] [Last Exit] [Status]   │  Quick summary cards
├─────────────────────────────────────┤
│                      │               │
│  Recent              │  Quick Links  │
│  Notifications       │  - Profile    │
│  Preview             │  - Gate Logs  │
│  (5 items)           │  - Updates    │
│                      │               │
└─────────────────────────────────────┘
```

### 2️⃣ My Profile (`/resident/profile`)
```
┌─────────────────────────────────────────┐
│ 👤 My Profile                           │
├──────────────────────┬──────────────────┤
│ Personal Info        │  Account Info    │
│ ├─ Full Name        │  ├─ Email        │
│ ├─ Age              │  ├─ Member Since │
│ ├─ Gender           │  └─ Access Status│
│ ├─ Birthdate        │                  │
│ ├─ Contact Number   │ [Edit Button]    │
│ └─ Address          │                  │
│                      │                  │
│ 🚗 Vehicle Info      │                  │
│ ├─ Plate Number     │                  │
│ ├─ Car Model        │                  │
│ └─ Car Color        │                  │
└──────────────────────┴──────────────────┘
```

### 3️⃣ Edit Profile (`/resident/profile/edit`)
```
┌─────────────────────────────────────┐
│ ✏️ Edit Profile                     │
├─────────────────────────────────────┤
│ 👤 Personal Information             │
│ ┌──────────────────────────────┐   │
│ │ Full Name: [input]           │   │
│ │ Age:       [input]           │   │
│ │ Contact:   [input]           │   │
│ │ Address:   [textarea]        │   │
│ └──────────────────────────────┘   │
│                                     │
│ 🚗 Vehicle Information              │
│ ┌──────────────────────────────┐   │
│ │ Plate #:  [input]            │   │
│ │ Model:    [input]            │   │
│ │ Color:    [input]            │   │
│ └──────────────────────────────┘   │
│                                     │
│ [Submit] [Cancel]                   │
└─────────────────────────────────────┘
```

### 4️⃣ Gate Logs (`/resident/gate-logs`)
```
┌──────────────────────────────────────────┐
│ 📊 Gate Access Logs                      │
├──────────────────────────────────────────┤
│ [Entries Today] [Exits Today] [Unauth.]  │  Summary Cards
├──────────────────────────────────────────┤
│ Date & Time │ Status │ Type │ Plate │Img│
│─────────────┼────────┼──────┼───────┼───│
│ Dec 27 10:30│ ✓ AUTH │ ⬇ EN │ABC123│[V]│
│ Dec 27 10:15│ ✓ AUTH │ ⬆ EX │ABC123│[V]│
│ Dec 27 10:00│ ⚠ UNAU │ ⬇ EN │XYZ789│[V]│
│             │        │      │       │   │
│ [< Prev] [Next >]                        │
└──────────────────────────────────────────┘
```

### 5️⃣ Notifications (`/resident/notifications`)
```
┌──────────────────────────────────────────┐
│ 🔔 Notifications        [Unread: 3]      │
│                    [Mark all as read]    │
├──────────────────────────────────────────┤
│ 🔵 Gate opened at 6:45 PM                │  Unread
│    ✓ Gate Access | 2 hours ago           │
│    [Mark as read]                        │
│                                          │
│ ⚠ Unauthorized attempt detected!        │  Unread
│    ⚠ Unauthorized | 5 hours ago          │
│    [Mark as read]                        │
│                                          │
│ ✓ Your profile update was approved       │  Read
│    ✓ Approved | 1 day ago                │
│                                          │
│ [< Prev] [Next >]                        │
└──────────────────────────────────────────┘
```

### 6️⃣ Update Requests (`/resident/update-requests`)
```
┌──────────────────────────────────────────┐
│ 📤 Update Requests    [Submit New]        │
├──────────────────────────────────────────┤
│ [Total: 5] [Pending: 2] [Appr: 2] [Rej:1]│
├──────────────────────────────────────────┤
│                                          │
│ Update Request #3        ⏳ PENDING      │
│ Submitted: Dec 27, 10:30 AM              │
│                                          │
│ Requested Changes:                       │
│ ┌──────────────┬─────────────────────┐  │
│ │ Car Model    │ Honda Civic 2021     │  │
│ │ Plate Number │ ABC-5678             │  │
│ └──────────────┴─────────────────────┘  │
│                                          │
│ Status Timeline:                         │
│ 🔵 Submitted: Dec 27, 10:30 AM          │
│ ⏳ Pending review...                     │
│                                          │
│ [< Prev] [Next >]                        │
└──────────────────────────────────────────┘
```

### 7️⃣ Help & Support (`/resident/help`)
```
┌──────────────────────────────────────────┐
│ 📞 Help & Support                        │
├──────────┬──────────────────────────────┤
│ CONTACT  │ FAQs                         │
│          │                              │
│ 💬 Chat  │ 1. Why denied access?        │
│ ☎️ Call  │ 2. How long for approval?    │
│ ✉️ Email │ 3. View gate history?        │
│          │ 4. Unauthorized attempts?    │
│ Emergency│ 5. Update vehicle?           │
│ 🚨 911   │                              │
│          │ Troubleshooting Guide        │
│          │ - Can't login                │
│          │ - No notifications           │
│          │ - Update rejected            │
│          │ - Gate access slow           │
└──────────┴──────────────────────────────┘
```

---

## 🔄 User Workflows

### Workflow 1: View Profile
```
Login → Dashboard → Click [My Profile] → View Details
```

### Workflow 2: Submit Profile Changes
```
Login → Dashboard → [My Profile] → Click [Edit Profile] → 
Fill Form → Click [Submit Changes] → Confirmation → 
[Update Requests] → Track Status
```

### Workflow 3: Check Gate Access
```
Login → Dashboard → Click [Gate Logs] → 
View Table (Search/Filter) → Click [View] on image →
Image Modal appears
```

### Workflow 4: Monitor Requests
```
Login → [Update Requests] → See all requests → 
View details (changes, status, timeline) →
If rejected: [Try Again] button → [Edit Profile]
```

### Workflow 5: Get Help
```
Login → [Help & Support] → 
Browse FAQs (expand) / Troubleshooting /
Call / Email / Chat support
```

---

## 📊 Data Display Formats

### Status Badges
- ✅ **AUTHORIZED** - Green background
- ⚠️ **UNAUTHORIZED** - Red background  
- ⏳ **PENDING** - Yellow background
- ✓ **APPROVED** - Green background
- ✗ **REJECTED** - Red background

### Access Types
- ⬇️ **Entry** - Resident entering (green)
- ⬆️ **Exit** - Resident exiting (blue)

### Notification Types
- ✓ Gate Access - Green badge
- ⚠ Unauthorized - Red badge
- ✓ Approved - Green badge
- ✗ Rejected - Red badge
- ⚙ System - Slate badge

---

## 🎯 Key Features at a Glance

| Feature | Where | What It Does |
|---------|-------|--------------|
| Quick Stats | Dashboard | Shows last entry/exit & status |
| Profile View | My Profile | Display all personal details |
| Edit Form | Edit Profile | Submit changes for approval |
| Access History | Gate Logs | Complete IN/OUT record with images |
| Notifications | Notifications | System alerts & gate events |
| Request Tracking | Update Requests | Monitor status of profile changes |
| Support | Help & Support | FAQ, troubleshooting, contact |

---

## 🔐 Security Features

✅ Authentication required (login)
✅ Email verification required  
✅ Role-based access (resident only)
✅ Changes require admin approval
✅ Input validation on all forms
✅ CSRF protection on forms
✅ Secure notification system
✅ Encrypted sensitive data

---

## 📱 Device Support

- **Desktop**: Full width, multi-column layouts
- **Tablet**: 2-column grids, optimized spacing
- **Mobile**: Single column, touch-friendly buttons, swipeable tables

---

## 🎨 Color Scheme

- **Primary**: Blue (#2563eb)
- **Success**: Green (#16a34a)
- **Warning**: Yellow (#eab308)
- **Danger**: Red (#dc2626)
- **Background**: White light / Zinc-900 dark
- **Text**: Zinc-900 light / Zinc-100 dark

---

## ⚡ Performance Notes

- Gate logs use pagination (15 per page)
- Notifications paginated (20 per page)
- Update requests paginated (10 per page)
- Lazy-loaded images with preview modals
- Optimized database queries with eager loading

---

## 📞 Support Contacts (Customizable)

- **Phone**: +1 (555) 123-4567
- **Email**: security@subdivision.com
- **Emergency**: 911 or +1 (555) 999-9999
- **Chat**: Available during business hours

*(Update these in the help.blade.php file)*

---

**Version**: 1.0
**Last Updated**: December 27, 2025
