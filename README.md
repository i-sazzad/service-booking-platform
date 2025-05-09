# 🛠️ Service Booking Platform — Sheba Platform Ltd (Interview Assignment)

A mini backend service booking platform built with **Laravel** that allows:

- Customers to view services, book a service, and check booking status.
- Admins to manage services and view bookings via secure JWT-protected routes.

---

## ✅ Features

### Core Features
- ✅ **Service Listing** API
- ✅ **Service Booking** API
- ✅ **Booking Status** API

### Unit Testing
- ✅ Service listing
- ✅ Booking creation
- ✅ Booking status retrieval

### Admin Panel (JWT Protected)
- ✅ Admin Login
- ✅ Add/Edit/Delete Services
- ✅ View All Bookings

---

## 🧪 API Routes

### 🔓 Public Auth Routes
```

POST   /api/register          - Register user
POST   /api/login             - Login user
POST   /api/admin/login       - Admin login

```

### 📂 Public Customer Routes
```

GET    /api/services          - List all available services

```

### 🔐 Customer Protected Routes (JWT)
```

POST   /api/book              - Book a service
GET    /api/booking/{id}      - Check booking status
POST   /api/logout            - Logout

```

### 🔐 Admin Protected Routes (JWT + role:admin)
```

GET    /api/admin/services            - List services
POST   /api/admin/services            - Create service
GET    /api/admin/services/{id}       - Get service details
PUT    /api/admin/services/{id}       - Update service
DELETE /api/admin/services/{id}       - Delete service

GET    /api/admin/bookings            - List all bookings

````

## 🧪 Running Tests

```bash
php artisan test
```

---

## 🐳 Docker Support (Optional)

To use Docker, rename your `Dockerfile.txt` to `Dockerfile` and run:

```bash
docker build -t service-booking .
docker run -p 9000:9000 service-booking
```

---

## 🔐 Authentication

* Uses **JWT** for both customer and admin routes.
* Admin routes are protected with a custom **role-based middleware**.

---

## 📝 Assumptions
* No Docker Compose or Redis setup.
* Admin login is separate from user login for simplicity.

---

