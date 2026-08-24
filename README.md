# 🏥 Clinic Management System — NTI Final Project

![Laravel Version](https://img.shields.io/badge/Laravel-v11.0-red?style=flat&logo=laravel)
![PHP Version](https://img.shields.io/badge/PHP-v8.2-blue?style=flat&logo=php)
![Bootstrap Version](https://img.shields.io/badge/Bootstrap-v5.3-purple?style=flat&logo=bootstrap)
![License](https://img.shields.io/badge/License-MIT-green)

A comprehensive, full-stack **Clinic Management System** built with **Laravel 11**, **MySQL**, and **Bootstrap 5 (RTL)** as the final graduation project for the **National Telecommunication Institute (NTI)** PHP Full Stack Internship.

Developed with by Mohamed Elbaz**.

---

## 🌟 Key Features

### 👨‍💼 1. Authentication & Role Management
- Secure Login/Logout with **Bcrypt Password Hashing**.
- **Role-Based Access Control (RBAC)** via custom Middleware (`admin`, `doctor`, `patient`).
- Session Fixation & CSRF Protection.

### 📊 2. Interactive Dashboard
- Live Statistics (Total Patients, Doctors, Today's Appointments, Pending Appointments).
- Quick Action Buttons for fast data entry.
- Table of Recent Bookings with status badges.

### 👥 3. Patients Management (CRUD)
- Full Patient Records (Name, Email, Phone, Gender, Blood Group, Address).
- Profile Picture Upload (`Storage::link`).
- Instant Filter & Search by Name, Email, or Phone (No JavaScript).
- Server-side Pagination (`paginate(10)`).

### 👨‍⚕️ 4. Doctors Management (CRUD)
- Doctor Profile with Specialization & Room Number.
- Automatic User Account creation for new doctors.
- Search by Specialization, Name, or Room Number.

### 📅 5. Appointments & Booking Management
- Link Patients with Doctors with Date & Time selection.
- **Instant Status Management** (`Pending` 🟡, `Confirmed` 🟢, `Completed` 🔵, `Cancelled` 🔴).
- Filter Appointments by Status.

### 📄 6. PDF Export & REST APIs
- Official Printable Appointment Ticket Generation in PDF (`barryvdh/laravel-dompdf`).
- **RESTful API Endpoints** returning JSON for External Consumption (`/api/v1/doctors`, `/api/v1/stats`).

---

## 🛠️ Tech Stack & Tools

- **Backend:** PHP 8.2 + Laravel 11 (MVC Architecture)
- **Frontend:** HTML5, CSS3, Bootstrap 5.3.2 RTL, Blade Templates
- **Database:** MySQL / MariaDB (XAMPP)
- **Security:** CSRF Protection, Server-side Validation, Role Middleware
- **Version Control:** Git & GitHub (`elbaz26/NTI-Final-Project`)

---

## 🗄️ Database Schema

```text
users
├── id (PK)
├── name
├── email (unique)
├── password (hashed)
├── role (admin, doctor, patient)
└── image (nullable)

patients
├── id (PK)
├── user_id (FK → users.id, cascade)
├── phone
├── address
├── date_of_birth
├── gender
└── blood_group

doctors
├── id (PK)
├── user_id (FK → users.id, cascade)
├── specialization
├── phone
└── room_number

appointments
├── id (PK)
├── doctor_id (FK → doctors.id, cascade)
├── patient_id (FK → patients.id, cascade)
├── appointment_date
├── appointment_time
├── status (pending, confirmed, completed, cancelled)
└── notes
