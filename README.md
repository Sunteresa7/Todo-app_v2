# Secure To-Do List Management System

This is a secure, role-based To-Do List web application developed for the CCS6344 Database & Cloud Security course project.

## 📌 Features

### 👤 User Module
- Register and log in securely
- Add, edit, delete tasks
- Tasks have due dates and categories
- Reminders for overdue and due-today tasks
- reCAPTCHA v2 for bot protection
- Passwords hashed with bcrypt

### 👮 Admin Module
- Separate admin login page
- View list of users (with registration date)
- Delete user accounts (cascades tasks)
- Cannot view or manage tasks (privacy enforced)

### 🔐 Security Measures
- Prepared SQL statements to prevent SQL injection
- Session-based role separation (`user_id` vs `admin_id`)
- Output encoding to prevent XSS
- Foreign key constraints for data integrity
- CAPTCHA on all login forms

## 🗃️ Database Structure

Tables:
- `users`: Stores credentials, timestamps
- `tasks`: Linked to users (FK), stores task content, category, due date
- `admins`: Admin-only login table

## 🛠️ Technologies Used

- PHP 8.x
- MySQL 8.x
- Bootstrap 5
- Apache (XAMPP)
- Google reCAPTCHA v2
- phpMyAdmin

## 🚀 How to Run

1. Clone this repository into `htdocs/`
2. Import `database.sql` via phpMyAdmin
3. Open `http://localhost/todo-app/register.php` to test user flow
4. Open `http://localhost/todo-app/admin_login.php` to access admin dashboard

## 🧪 Default Admin Login
- Username: `admin`
- Password: `admin123`

## 🎓 Developed by Group TT4L
- Pravin Kunasegran (1221303877)
- Ahmad Hykal Hakimi Bin Yusry (1221305344)
- Sunterresaa Sankar (1211102415)
