
# 🛡️ Secure To-Do List Management System (AWS Migration Project)

This is a secure, role-based To-Do List web application developed for the **CCS6344 Database & Cloud Security** course. The system was originally built using XAMPP (PHP + MySQL) and is now fully migrated to **Amazon Web Services (AWS)** with modern cloud-native architecture and security controls.

---

## 📌 Features

### 👤 User Module
- Secure registration and login (with password hashing)
- Task creation, editing, deletion with due dates & categories
- Visual reminders for overdue and due-today tasks
- reCAPTCHA v2 bot protection

### 👮 Admin Module
- Dedicated admin login page
- View registered users and their join dates
- Delete users (cascades all related tasks)
- No access to user task data (role separation enforced)

---

## 🔐 Security Features
- Enforced **role-based access control** (RBAC)
- **Prepared SQL statements** (SQL injection prevention)
- **XSS protection** using output encoding
- **bcrypt password hashing**
- **CAPTCHA** on login forms
- **Cloud-based WAF rules** for input filtering
- Encrypted RDS MySQL database (at rest)
- CloudTrail logs and CloudWatch alerts

---

## 🏗️ AWS Cloud Architecture

- **Amazon EC2** (Apache + PHP app)
- **Amazon RDS** (MySQL 8.0 in private subnet)
- **Application Load Balancer (ALB)** for routing
- **AWS WAF** for threat mitigation
- **IAM roles** with least privilege
- **CloudFormation** for infrastructure-as-code
- **CloudTrail + S3** for logging
- **CloudWatch** for monitoring and alerting

> 💡 See `Diagram 5.1` in the report for full AWS infrastructure layout.

---

## 🚀 How to Deploy on AWS

1. **Launch CloudFormation Stack**  
   Upload `iac-todo-app-stack.yaml` via AWS CloudFormation to create all resources (EC2, RDS, ALB, etc.)

2. **SSH into EC2**  
   Transfer all `.php` files into `/var/www/html/`

3. **Import the Database**  
   Use the `mysql` CLI to connect to RDS and import `database.sql`

4. **Test the App**  
   Access via the ALB DNS (e.g., `http://todo-alb-xxxxxx.ap-southeast-1.elb.amazonaws.com/login.php`)

---

## 🎥 Demo Video

📺 [Click to Watch on YouTube](#)  
*(Insert your demo video link here once uploaded)*

---

## 🧪 Default Admin Login

- Username: `admin`
- Password: `admin123`

---

## 👥 Developed by Group TT4L

- Pravin Kunasegran (1221303877)  
- Ahmad Hykal Hakimi Bin Yusry (1221305344)  
- Sunterresaa Sankar (1211102415)

---

## 📄 Report & Documentation

📄 Project Report (PDF): [reportupdated.pdf](#)  
🗂️ Infrastructure as Code: [`iac-todo-app-stack.yaml`](infrastructure/iac-todo-app-stack.yaml)  
