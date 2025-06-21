# Secure Registration & Login System

A simple PHP, MySQL, and JavaScript-based registration and login system with modern UI, password strength meter, and captcha.

---

## Features

- User registration with email, password, and captcha
- Password strength indicator
- User login with session management
- Dashboard with personalized greeting
- Logout functionality
- Responsive and modern UI (CSS/FontAwesome)
- Environment-based configuration

---

## Prerequisites

- PHP 7.4+ (with PDO extension)
- MySQL 8+ (Docker or local)
- Nginx or Apache web server
- Docker (optional, for MySQL)

---

## Setup Instructions

### 1. **Clone the Repository**

```sh
git clone <your-repo-url>
cd assignment
```

### 2. **Configure Environment Variables**

Copy the example `.env` file and edit as needed:

```sh
cp .env.example .env
```

Edit `.env` to match your MySQL setup (especially if using Docker):

```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=database_name
DB_USER=db_user_name
DB_PASSWORD=db_password
```

### 3. **Start MySQL with Docker (Optional)**

If you want to use Docker for MySQL, add this to your `docker-compose.yml`:

```yaml
version: '3'
services:
  mysql84:
    container_name: mysql-db84
    image: mysql:8.4
    env_file:
      - .env
    ports:
      - "3306:3306"
    networks:
      - local_default
networks:
  local_default:
    driver: bridge
```

Then run:

```sh
docker-compose up -d
```

### 4. **Create the Database Table**

Connect to MySQL and run:

```sql
CREATE DATABASE IF NOT EXISTS database_name;
USE database_name;
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255)
);
```

### 5. **Configure Web Server**

#### **Nginx Example**

```nginx
server {
    listen 80;
    server_name localhost;

    root /var/www/assignment;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~* \.(css|js|png|jpg|jpeg|gif|ico)$ {
        try_files $uri =404;
        expires 1d;
        add_header Cache-Control "public";
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock; # Adjust PHP version if needed
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

#### **Apache Example**

Place the project in `/var/www/assignment` and ensure `mod_rewrite` is enabled.

---

## Usage

1. Visit [http://localhost/assignment/](http://localhost/assignment/) in your browser.
2. Register a new account.
3. Login with your credentials.
4. On successful login, you'll be redirected to the dashboard.
5. Use the logout link to end your session.

---

## File Structure

```
assignment/
├── index.php
├── dashboard.php
├── login.php
├── register.php
├── logout.php
├── db.php
├── style.css
├── script.js
├── .env
└── .env.example
```

---

## Security Notes

- Never commit your real `.env` file to public repositories.
- Use HTTPS in production.
- Passwords are hashed using PHP's `password_hash`.
- Captcha is implemented in JS for demo purposes; for production, use a server-side or third-party solution.

---

## License

MIT

---
