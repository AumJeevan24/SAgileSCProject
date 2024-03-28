# SAgile Project Management Tool
SAgile is a project management tool built with Laravel 7. It allows teams to manage projects, tasks, and deadlines in a collaborative environment. The tool is designed to improve team productivity and collaboration, enabling you to easily manage your project from start to finish.

Features:
- SAgile comes with the following features:
- User authentication and authorization
- Project management
- Task management
- Collaborative environment
- Dashboard for overview


# Installation

To run SAgile on your local machine, you need to follow these steps:

**Prerequisites**

Before you start, make sure you have the following software installed on your system:

- XAMPP web server
- MySQL database
- Composer
- Git

Ensure PHP version installed in XAMPP is **v8.0.28**
- [XAMPP PHP Version Change Tutorial](https://www.youtube.com/watch?v=Uto36GI6HIg)
- [XAMPP Version 8.0.28](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.0.28/)

The project must be installed in `C:\path\to\xampp\htdocs\SAgilePMT_UTM`

In your phpMyAdmin create a database `kanban` and import [`kanban.sql`](kanban.sql)


# Start the Server

To start the server, navigate to the root directory of your Laravel project and run the following commands:

```
composer install
```
```
composer update
```
```
cp .env.example .env
```
```
php artisan key:generate
```
```
php artisan serve
```

This will start the server on http://localhost:8000.

# Conclusion

Congratulations! You have successfully installed SAgile Project Management Tool on your local machine. You can now use the tool to manage your projects and tasks, collaborate with your team members, and track deadlines and milestones.
