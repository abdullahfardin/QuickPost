📝 QuickPost - Simple PHP & HTML Blog System

A lightweight, modern, and simple Content Management System (CMS) built with pure HTML/CSS/JS on the frontend and a PHP/MySQL API on the backend.

This project demonstrates a decoupled architecture where the frontend communicates with the backend asynchronously using the Javascript fetch API.

✨ Features

Decoupled Architecture: 100% pure HTML frontend and a hidden PHP backend (API).

User Authentication: Secure Signup, Login, and Logout functionality with password hashing.

CRUD Operations: Create, Read, Update, and Delete blog posts.

Access Control: Users can view all posts but can only edit or delete their own posts.

Auto-Setup Database: No need to manually create databases or tables in phpMyAdmin; the system builds itself on the first run.

Modern UI: Clean, responsive, and colorful design using the Poppins font and CSS gradients.

🛠️ Tech Stack

Frontend: HTML5, CSS3 (Embedded), Vanilla JavaScript (Fetch API)

Backend: PHP (Procedural)

Database: MySQL

Environment: XAMPP (Apache + MySQL)

📂 File Structure

quickpost/
│
├── Backend (API)
│   ├── db.php        # Database connection & auto-table creation
│   └── api.php       # Handles all data requests (login, posts, CRUD)
│
└── Frontend (UI)
    ├── index.html    # Home page / Feed of all posts
    ├── signup.html   # User registration form
    ├── login.html    # User login form
    ├── create.html   # Form to write a new post
    ├── edit.html     # Form to update an existing post
    └── README.md     # Project documentation


🚀 Installation & Setup

Follow these simple steps to get the project running on your local machine using XAMPP.

1. Start XAMPP

Open your XAMPP Control Panel and start both the Apache and MySQL modules.

2. Add Files to htdocs

Navigate to your XAMPP installation directory (usually C:\xampp\htdocs on Windows or /Applications/XAMPP/htdocs on Mac).
Create a new folder (e.g., quickpost) and place all the project files inside it.

3. Run the App

Do not double-click the HTML files! Because they use an API, they must be run through a local server.

Open your web browser (Chrome, Edge, Safari, etc.).

Type the following into your address bar:

http://localhost/quickpost/


(Note: Change quickpost to whatever you named your folder in step 2).

4. Automatic Database Creation

You do not need to set up the database manually! The very first time you load the app and try to sign up or log in, db.php will automatically create the mini_cms_api database and the required users and posts tables.

💡 Usage Guide

Sign Up: Start by clicking "Signup" to create a new account.

Log In: Use your new credentials to log into the system.

Write a Post: Click "Write Post" in the navigation bar to publish your first article. Add some comma-separated tags!

Edit/Delete: On the Home page, you will see "Edit" and "Delete" buttons under the posts that belong to you.

🔒 Security Notes

Passwords are encrypted in the database using PHP's native password_hash().

SQL injections are prevented by using Prepared Statements (prepare() and bind_param()) in api.php.

Backend ownership checks ensure users cannot delete posts they do not own, even if they manipulate the frontend HTML.

Built with ❤️ using PHP and Vanilla JS.
