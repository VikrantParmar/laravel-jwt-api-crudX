# ![Laravel](https://img.shields.io/badge/Laravel-%23FF2D20.svg?style=flat&logo=laravel&logoColor=white) Laravel 10 JWT Authentication REST API 🚀

This project is a backend application built with the PHP Laravel framework, MySQL, and JWT (JSON Web Tokens) authentication. It provides a robust REST API for managing user authentication, category, and blog features, with multi-language support for English (EN), French (FR), and German (DE). 

---

This is a login system with two types of users:
- **Admin**
- **User**


## ⭐ Features

###  🔒 Authentication APIs
- **Login:** Secure login using JWT tokens.
- **Register:** New user registration. Sends email notifications to the user and the system admin.
- **Forgot Password:** Sends an email to the registered user with a password reset link.
- **Reset Password:** Allows users to securely reset their password.
- **Profile:** Fetch, update, and manage user profile data.

### 📧 Email Notifications
- **User Registration:** Email notifications are sent to both the newly registered user and the system admin.
- **Forgot Password Request:** Email with a reset link is sent to the registered user.

### 📂 Category APIs [Only Access By Admin Role]
- **List Categories:** Retrieve a list of all categories.
- **Add Category:** Add a new category to the system.
- **Update Category:** Update an existing category.
- **Category Details:** Fetch details of a specific category.
- **Delete Category:** Delete a category.

### 📝 Blog APIs
- **List Blogs:** Retrieve a list of all blogs.
- **Add Blog:** Add a new blog post to the system.
- **Update Blog:** Update an existing blog post.
- **Blog Details:** Fetch details of a specific blog post.
- **Delete Blog:** Delete a blog post.

### 🌐 Multi-Language Support
- Supports three languages: English (EN), French (FR), and German (DE).
- Language selection can be done via API headers.

---

## ⚙ Installation and Setup Instructions

Follow these steps to set up the Laravel application:

1. **Clone the Repository**
   ```bash
   git clone https://github.com/VikrantParmar/laravel-jwt-api-crudX.git
   cd laravel-jwt-api-crudX

2. **Install Dependencies**
   ```bash
   composer install

4. **Create Environment File**
   ```bash
   cp .env.example .env
   - Update the .env file with your database credentials and email configuration.

5. Generate Application Key
   ```bash
   php artisan key:generate

6. Run Database Migrations
   ```bash
   php artisan migrate

7. Run Seeders
   ```bash
   php artisan db:seed

8. Run the Application
   ```bash
   php artisan serve

9. Access the Application Open your browser and navigate to
   ```bash
   http://127.0.0.1:8000

## Default Credentials for Testing

| **Role**   | **Username**                      | **Password**   |
|------------|-----------------------------------|----------------|
| **Admin**  | vikrant-admin@example.com         | 123456789      |
| **User**   | vikrant-user@example.com          | 123456789      |



## 📋 API Documentation [<img src="https://voyager.postman.com/logo/postman-logo-icon-orange.svg" width="20" height="20" />](https://documenter.getpostman.com/view/39353609/2sAYJ7geHA)
#### 🔗 Visit the Postman Docs for more details [Postman Docs](https://documenter.getpostman.com/view/39353609/2sAYJ7geHA)

### Endpoints Overview

#### 🔒 Authentication
- `POST /api/v1/login` - User login.
- `POST /api/v1/register` - User registration.
- `POST /api/v1/forgot-password` - Request password reset.
- `POST /api/v1/reset-password` - Reset password.
- `GET /api/v1/profile` - Get user profile.

#### Category Management
- `GET /api/v1/categories` - List categories.
- `POST /api/v1/categories` - Add a new category.
- `PUT /api/v1/categories/{id}` - Update a category.
- `GET /api/v1/categories/{id}` - Get category details.
- `DELETE /api/v1/categories/{id}` - Delete a category.

#### Blog Management
- `GET /api/v1/blogs` - List blogs.
- `POST /api/v1/blogs` - Add a new blog post.
- `PUT /api/v1/blogs/{id}` - Update a blog post.
- `GET /api/v1/blogs/{id}` - Get blog details.
- `DELETE /api/v1/blogs/{id}` - Delete a blog post.

---

### 🌐 Multi-Language Support
Set the `Accept-Language` header in your API requests to one of the following values:

- `en` for English
- `fr` for French
- `de` for German

> [!NOTE]
> Include additional setup instructions if you use third-party services (e.g., mail providers or APIs).  
> Multi-Language for only api reponse msg like success and error.


### 🌎 Contact
For questions, feedback, or collaboration inquiries, please contact:

Name: Vikrant Parmar  
Email: vikrant.parmar91@gmail.com




Thank you for using this application! 😊