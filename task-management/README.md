# Task Management System

A complete, full-featured task management web application built with PHP, JavaScript, CSS, and MySQL. This system allows users to register, login, and manage their daily tasks with priorities, due dates, and status tracking.

## Table of Contents
- [Features](#features)
- [Technologies Used](#technologies-used)
- [System Requirements](#system-requirements)
- [Installation Guide](#installation-guide)
- [Project Structure](#project-structure)
- [Database Schema](#database-schema)
- [Configuration](#configuration)
- [Usage Guide](#usage-guide)
- [Validation Rules](#validation-rules)
- [Security Features](#security-features)
- [Troubleshooting](#troubleshooting)
- [Screenshots](#screenshots)

## Features

### User Management
- **User Registration**: Create new accounts with username, email, and password
- **User Login**: Secure authentication system with session management
- **User Logout**: Clean session termination
- **Form Validation**: Real-time client-side and server-side validation

### Task Management
- **Create Tasks**: Add tasks with title, description, priority, and due date
- **View Tasks**: Display all tasks in an organized list
- **Update Tasks**: Mark tasks as completed or reopen them
- **Delete Tasks**: Remove tasks permanently
- **Filter Tasks**: Filter by status (All, Pending, Completed)
- **Priority Levels**: Low, Medium, High priority color-coding
- **Due Date Tracking**: Set and track task deadlines

### User Interface
- **Responsive Design**: Works on desktop, tablet, and mobile devices
- **Modern UI**: Clean gradient background with card-based layout
- **Color-Coded Priorities**: Visual distinction for task importance
- **Real-time Feedback**: Success and error messages
- **Interactive Forms**: Inline validation with error messages

## Technologies Used

### Frontend
- **HTML5**: Semantic markup structure
- **CSS3**: Modern styling with flexbox and gradients
- **JavaScript (ES6)**: Client-side logic and AJAX requests
  - Fetch API for HTTP requests
  - DOM manipulation
  - Form validation
  - Event handling

### Backend
- **PHP 7+**: Server-side processing
  - Session management
  - Database operations
  - Input validation and sanitization
  - Password hashing (bcrypt)
  - JSON API responses

### Database
- **MySQL**: Relational database management
  - User authentication
  - Task storage
  - Foreign key relationships
  - Indexed queries for performance

### Server
- **XAMPP**: Local development environment
  - Apache web server
  - MySQL database server
  - phpMyAdmin for database management

## System Requirements

- **XAMPP** 7.4 or higher (includes Apache, MySQL, PHP)
- **Web Browser**: Chrome, Firefox, Edge, or Safari (latest versions)
- **Operating System**: Windows, macOS, or Linux
- **Disk Space**: Minimum 50MB
- **RAM**: Minimum 512MB

## Installation Guide

### Step 1: Install XAMPP

1. Download XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Run the installer and follow the installation wizard
3. Install to default location: `C:\xampp\` (Windows) or `/Applications/XAMPP/` (macOS)
4. Complete the installation

### Step 2: Start XAMPP Services

1. Open **XAMPP Control Panel**
2. Click **Start** next to **Apache**
3. Click **Start** next to **MySQL**
4. Verify both services show "Running" status (green highlight)

### Step 3: Create Database

**Option A: Using phpMyAdmin (Recommended)**
1. Open your browser and go to: `http://localhost/phpmyadmin`
2. Click on **"New"** in the left sidebar
3. Enter database name: `task_management`
4. Click **"Create"**
5. Select the `task_management` database
6. Click on **"Import"** tab
7. Click **"Choose File"** and select `database.sql`
8. Click **"Go"** at the bottom
9. Wait for success message

**Option B: Using SQL Commands**
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Click on **"SQL"** tab
3. Copy and paste the contents of `database.sql`
4. Click **"Go"**

### Step 4: Deploy Application Files

1. Navigate to XAMPP's htdocs folder:
   - Windows: `C:\xampp\htdocs\`
   - macOS: `/Applications/XAMPP/htdocs/`
   - Linux: `/opt/lampp/htdocs/`

2. Create a new folder named `task-management`

3. Copy all project files into this folder:
   ```
   C:\xampp\htdocs\task-management\
   ├── index.php
   ├── database.sql
   ├── README.md
   ├── css\
   │   └── style.css
   ├── js\
   │   └── app.js
   └── php\
       ├── config.php
       ├── login.php
       ├── register.php
       ├── check_auth.php
       ├── add_task.php
       ├── get_tasks.php
       ├── update_task.php
       ├── delete_task.php
       └── logout.php
   ```

### Step 5: Configure Database Connection (Optional)

If your MySQL has a password or different settings:

1. Open `php/config.php`
2. Update the database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', 'your_password_here');
   define('DB_NAME', 'task_management');
   ```
3. Save the file

### Step 6: Access the Application

1. Open your web browser
2. Navigate to: `http://localhost/task-management/index.php`
3. You should see the login page
4. Click "Register" to create a new account

## Project Structure

```
task-management/
│
├── index.php                 # Main application page (Frontend UI)
├── database.sql              # Database schema and structure
├── README.md                 # Project documentation
│
├── css/
│   └── style.css            # All styling and responsive design
│
├── js/
│   └── app.js               # Frontend JavaScript logic
│                            # - Form validation
│                            # - AJAX requests
│                            # - DOM manipulation
│                            # - Event handlers
│
└── php/                     # Backend API endpoints
    ├── config.php           # Database configuration and connection
    ├── login.php            # User login authentication
    ├── register.php         # User registration
    ├── check_auth.php       # Session validation
    ├── add_task.php         # Create new task
    ├── get_tasks.php        # Retrieve tasks with filtering
    ├── update_task.php      # Update task status
    ├── delete_task.php      # Delete task
    └── logout.php           # User logout and session destroy
```

## Database Schema

### Users Table
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Fields:**
- `id`: Unique user identifier (auto-increment)
- `username`: Unique username (3-20 characters)
- `email`: Unique email address
- `password`: Hashed password (bcrypt)
- `created_at`: Account creation timestamp

### Tasks Table
```sql
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    priority ENUM('low', 'medium', 'high') DEFAULT 'low',
    status ENUM('pending', 'completed') DEFAULT 'pending',
    due_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

**Fields:**
- `id`: Unique task identifier (auto-increment)
- `user_id`: Foreign key to users table
- `title`: Task title (3-200 characters)
- `description`: Task description (5-1000 characters)
- `priority`: Task priority (low, medium, high)
- `status`: Task status (pending, completed)
- `due_date`: Task deadline
- `created_at`: Task creation timestamp

**Indexes:**
- `idx_user_id`: Fast lookup by user
- `idx_status`: Fast filtering by status
- `idx_priority`: Fast filtering by priority

## Configuration

### Database Configuration (php/config.php)

```php
// Default XAMPP settings
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'task_management');
```

**Modify if needed:**
- Change `DB_PASS` if your MySQL has a password
- Change `DB_HOST` if using remote database
- Change `DB_USER` if using different MySQL user

### Session Configuration

Sessions are automatically started in `config.php`. Session data includes:
- `user_id`: Logged-in user's ID
- `username`: Logged-in user's username

## Usage Guide

### 1. Register a New Account

1. Open the application in your browser
2. Click **"Register"** link below the login form
3. Fill in the registration form:
   - **Username**: 3-20 characters (letters, numbers, underscores only)
   - **Email**: Valid email address
   - **Password**: Minimum 6 characters
   - **Confirm Password**: Must match password
4. Click **"Register"** button
5. Wait for success message
6. You'll be redirected to login page

### 2. Login to Your Account

1. Enter your **username**
2. Enter your **password**
3. Click **"Login"** button
4. You'll be redirected to the task dashboard

### 3. Add a New Task

1. After logging in, locate the "Add New Task" section
2. Fill in the task details:
   - **Title**: 3-200 characters
   - **Description**: 5-1000 characters
   - **Priority**: Select Low, Medium, or High
   - **Due Date**: Select a future date
3. Click **"Add Task"** button
4. Task will appear in the task list below

### 4. Manage Tasks

**Mark as Completed:**
- Click the **"Complete"** button on any pending task
- Task will be marked with strikethrough and reduced opacity

**Reopen Task:**
- Click the **"Reopen"** button on any completed task
- Task will return to pending status

**Delete Task:**
- Click the **"Delete"** button on any task
- Confirm the deletion in the popup
- Task will be permanently removed

### 5. Filter Tasks

Use the filter buttons to view:
- **All**: Show all tasks
- **Pending**: Show only incomplete tasks
- **Completed**: Show only finished tasks

### 6. Logout

Click the **"Logout"** button in the top-right corner to end your session

## Validation Rules

### Registration Validation

**Username:**
- Required field
- Minimum 3 characters
- Maximum 20 characters
- Only letters, numbers, and underscores allowed
- Must be unique (not already registered)

**Email:**
- Required field
- Must be valid email format
- Must be unique (not already registered)

**Password:**
- Required field
- Minimum 6 characters
- Maximum 50 characters

**Confirm Password:**
- Required field
- Must match the password field

### Login Validation

**Username:**
- Required field
- Must exist in database

**Password:**
- Required field
- Must match stored password

### Task Validation

**Title:**
- Required field
- Minimum 3 characters
- Maximum 200 characters

**Description:**
- Required field
- Minimum 5 characters
- Maximum 1000 characters

**Priority:**
- Must be one of: low, medium, high

**Due Date:**
- Required field
- Must be valid date format (YYYY-MM-DD)
- Cannot be in the past

## Security Features

### Password Security
- **Bcrypt Hashing**: Passwords are hashed using PHP's `password_hash()` with bcrypt algorithm
- **Salt**: Automatic salt generation for each password
- **Verification**: Secure password verification using `password_verify()`

### SQL Injection Prevention
- **Prepared Statements**: All database queries use prepared statements with parameter binding
- **Input Sanitization**: All user inputs are trimmed and validated
- **Type Checking**: Numeric values are validated before use

### Session Security
- **Session Management**: PHP sessions track authenticated users
- **Session Validation**: All API endpoints check for valid session
- **Session Destruction**: Proper logout clears all session data

### Input Validation
- **Client-Side**: JavaScript validation for immediate feedback
- **Server-Side**: PHP validation for security (cannot be bypassed)
- **Whitelist Validation**: Enum values checked against allowed values

### XSS Prevention
- **Output Escaping**: User data is properly escaped when displayed
- **Content-Type Headers**: JSON responses use proper content-type headers

## Troubleshooting

### Issue: Cannot access http://localhost/task-management/

**Solution:**
1. Check if Apache is running in XAMPP Control Panel
2. Verify files are in correct location: `C:\xampp\htdocs\task-management\`
3. Try accessing: `http://localhost/` to test Apache
4. Check Apache error logs in XAMPP Control Panel

### Issue: Database connection failed

**Solution:**
1. Check if MySQL is running in XAMPP Control Panel
2. Verify database `task_management` exists in phpMyAdmin
3. Check credentials in `php/config.php`
4. Ensure database was imported correctly

### Issue: Login/Register not working

**Solution:**
1. Open browser console (F12) and check for JavaScript errors
2. Verify `js/app.js` is loading correctly
3. Check Network tab for failed API requests
4. Verify database tables exist and have correct structure

### Issue: Tasks not displaying

**Solution:**
1. Check browser console for errors
2. Verify you're logged in (check session)
3. Ensure tasks exist in database for your user
4. Check `php/get_tasks.php` for errors

### Issue: "Headers already sent" error

**Solution:**
1. Check for any output before `<?php` tags in PHP files
2. Ensure no whitespace before `<?php` in config.php
3. Check file encoding is UTF-8 without BOM

### Issue: Date validation not working

**Solution:**
1. Ensure date input format is YYYY-MM-DD
2. Check browser supports HTML5 date input
3. Verify server timezone settings

### Issue: Session not persisting

**Solution:**
1. Check if cookies are enabled in browser
2. Verify session.save_path is writable
3. Check PHP session configuration in php.ini

## Screenshots

### Login Page
The login page features a clean, modern design with gradient background and form validation.

### Registration Page
User-friendly registration form with real-time validation and helpful error messages.

### Task Dashboard
Main dashboard showing task list with filtering options, priority color-coding, and task management buttons.

### Add Task Form
Intuitive form for creating new tasks with all necessary fields and validation.

## API Endpoints

All API endpoints return JSON responses:

### POST /php/register.php
Register a new user
```json
Request: { "username": "john", "email": "john@example.com", "password": "pass123" }
Response: { "success": true, "message": "Registration successful!" }
```

### POST /php/login.php
Authenticate user
```json
Request: { "username": "john", "password": "pass123" }
Response: { "success": true, "message": "Login successful" }
```

### GET /php/check_auth.php
Check if user is logged in
```json
Response: { "loggedIn": true, "username": "john" }
```

### POST /php/add_task.php
Create new task
```json
Request: { "title": "Task", "description": "Details", "priority": "high", "dueDate": "2024-12-31" }
Response: { "success": true, "message": "Task added successfully" }
```

### GET /php/get_tasks.php?filter=all
Get user's tasks
```json
Response: { "success": true, "tasks": [...] }
```

### POST /php/update_task.php
Update task status
```json
Request: { "id": 1, "status": "completed" }
Response: { "success": true, "message": "Task updated successfully" }
```

### POST /php/delete_task.php
Delete task
```json
Request: { "id": 1 }
Response: { "success": true, "message": "Task deleted successfully" }
```

### POST /php/logout.php
Logout user
```json
Response: { "success": true, "message": "Logged out successfully" }
```

## Future Enhancements

Potential features for future versions:
- Task categories/tags
- Task search functionality
- Task editing (modify title, description, etc.)
- Email notifications for due dates
- Task sharing between users
- File attachments for tasks
- Task comments/notes
- Dark mode theme
- Export tasks to PDF/CSV
- Mobile app version

## License

This project is open-source and available for educational purposes.

## Support

For issues or questions:
1. Check the Troubleshooting section
2. Review the browser console for errors
3. Check XAMPP error logs
4. Verify database structure matches schema

## Credits

Developed using:
- PHP for backend logic
- JavaScript for frontend interactivity
- CSS for modern styling
- MySQL for data storage
- XAMPP for local development environment
