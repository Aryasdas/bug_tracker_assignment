# 🐞 Bug Tracker Web Application

A full-featured Bug Tracking Web Application developed using **PHP**, **MySQL**, **Bootstrap**, and **jQuery**. This project allows users with different roles (Manager, Tester, Developer) to manage and track software bugs efficiently in real-time.

## 📌 Features

### 🔐 Authentication & User Roles
- Registration and Login functionality
- Role-based access control for:
  - **Manager**
  - **Tester**
  - **Developer**
- Secure session management

### 🐞 Bug Management
- Add new bugs with priority and status
- Assign bugs to developers
- Update bug status and track resolution
- Delete or close bugs once fixed

### 🧠 AI Task Placeholder (Optional/Extendable)
- Placeholder section for integrating AI-based task recommendations or classification

### 📁 File Management
- Upload supporting files/screenshots with bug reports
- Download attachments for reference

### 📊 Dashboard & Activity Overview
- Role-specific dashboards:
  - **Manager:** Overview of all users, bugs, and activity
  - **Tester:** Report new bugs and monitor progress
  - **Developer:** View assigned bugs and update status

---

## 🚀 Tech Stack

| Layer             | Technology           |
|------------------|----------------------|
| Frontend         | HTML, CSS, Bootstrap, jQuery |
| Backend          | PHP (v8.x)           |
| Database         | MySQL (v8.x)         |
| Version Control  | Git & GitHub         |

---

## 📂 Project Structure
Bug_Tracker-/
│
├── config/ # Database and session configuration
├── includes/ # Header, footer, and utility files
├── manager/ # Manager dashboard & functionalities
├── tester/ # Tester dashboard & functionalities
├── developer/ # Developer dashboard & functionalities
├── assets/ # CSS, JS, image files
├── login/ # Login and registration
├── dashboard/ # Common dashboard redirects
├── uploads/ # Uploaded files by users
├── index.php # Homepage/Login redirect
├── logout.php # Session logout
└── README.md # Project documentation


---

## ⚙️ Setup Instructions

1. **Clone the Repository**
 bash
   git clone https://github.com/Aryasdas/Bug_Tracker-.git
Import the Database

Open phpMyAdmin or use MySQL CLI

Create a new database, e.g., bug_tracker_db

Import the provided .sql file (if available inside the project)

Configure Database

Open config/db.php

Update DB credentials:

php
Copy
Edit
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bug_tracker_db";
Run the Project

Start XAMPP or WAMP

Place the project folder in htdocs

Visit in browser:
http://localhost/Bug_Tracker-/login/

👥 User Roles & Sample Credentials
Role	    Email	            Password
Manager	manager@mail.com	manager123
Tester	tester@mail.com	   tester123
Developer	developer@mail.com	dev123

(Or register new users via the registration page)
o Do / Improvements
 Basic AI Task integration (placeholder)

 Email Notifications for bug assignment

Graphical bug statistics and charts
 CSRF protection and improved validation

📱 Mobile responsive design polish

📄 License
This project is created as part of an academic assignment.
You may use or modify it for learning and development purposes

License
This project is created as part of an academic assignment.
You may use or modify it for learning and development purposes.

Author
Arya Sundar Das

