# 🏥 Hospital Management System API

RESTful Backend API untuk Sistem Manajemen Rumah Sakit yang dibangun menggunakan **Laravel 11**.  
Project ini dirancang sebagai **portfolio backend** dengan fokus pada autentikasi, role-based access control, manajemen data terstruktur, dan audit logging.

---

## 📌 Project Overview

Hospital Management System API adalah backend service yang mengelola data **user**, **dokter**, dan **pasien** dalam satu sistem terintegrasi.  
API ini mendukung autentikasi berbasis token, kontrol akses berdasarkan role, pencatatan aktivitas (audit trail), serta endpoint statistik untuk dashboard.

Project ini dibuat untuk mensimulasikan **kebutuhan backend dunia nyata** pada sistem skala kecil hingga menengah.

---

## 🏗️ Tech Stack

- **Framework**: Laravel 11
- **Language**: PHP 8.2+
- **Database**: MySQL 8.0+
- **Authentication**: Laravel Sanctum (Token-based)
- **ORM**: Eloquent ORM
- **API Format**: JSON (konsisten dengan ApiResponse Trait)

---

## 🔐 Authentication & Authorization

### Authentication
- Register & Login menggunakan email dan password
- Token-based authentication dengan Laravel Sanctum
- Protected routes menggunakan middleware `auth:sanctum`

### Role-Based Access Control (RBAC)
Menggunakan custom middleware `CheckRole`

| Role  | Access |
|------|-------|
| Admin | Full access (users, doctors, patients, logs, dashboard) |
| Staff | Limited access (patients management, view doctors & logs) |

---

## 👥 User Roles

### Admin
- Mengelola user
- CRUD dokter
- CRUD pasien
- Melihat activity log
- Mengakses dashboard statistik

### Staff
- CRUD pasien
- Melihat data dokter
- Melihat activity log

---

## 🏥 Manajemen Dokter

**Model: `Dokter`**
- `nama` – Nama lengkap dokter
- `spesialis` – Spesialisasi (Anak, Jantung, dll)
- `no_telepon` – Nomor kontak
- `jadwal` – Hari praktik (JSON array)

**Relasi**
- One-to-Many dengan Pasien

### Endpoints (Admin only)

| Method | Endpoint | Description |
|------|---------|------------|
| GET | `/api/dokters` | List dokter (search & pagination) |
| POST | `/api/dokters` | Tambah dokter |
| GET | `/api/dokters/{id}` | Detail dokter |
| PUT | `/api/dokters/{id}` | Update dokter |
| DELETE | `/api/dokters/{id}` | Hapus dokter |
| GET | `/api/dokters/{id}/pasiens` | List pasien per dokter |

---

## 🧑‍⚕️ Manajemen Pasien

**Model: `Pasien`**
- `nama` – Nama pasien
- `umur` – Usia pasien
- `penyakit` – Diagnosis
- `dokter_id` – Relasi dokter
- `tanggal_masuk` – Tanggal masuk rumah sakit

**Relasi**
- Many-to-One dengan Dokter

### Endpoints (Admin & Staff)

| Method | Endpoint | Description |
|------|---------|------------|
| GET | `/api/pasiens` | List pasien (filter & search) |
| POST | `/api/pasiens` | Tambah pasien |
| GET | `/api/pasiens/{id}` | Detail pasien |
| PUT | `/api/pasiens/{id}` | Update pasien |
| DELETE | `/api/pasiens/{id}` | Hapus pasien |
| POST | `/api/pasiens/{id}/change-dokter` | Pindah dokter |

---

## 📊 Dashboard & Statistik

**Endpoint**
`GET /api/dashboard/statistics`

**Data yang ditampilkan**
- Total dokter
- Total pasien
- Distribusi pasien per dokter
- Statistik pasien bulanan
- 5 pasien terbaru

---

## 📝 Activity Logging (Audit Trail)

Sistem pencatatan aktivitas otomatis menggunakan **Laravel Observer**.

**Observer**
- `UserObserver`
- `DokterObserver`
- `PasienObserver`

**Model: `ActivityLog`**
- `user_id`
- `action` (create, update, delete)
- `model`
- `model_id`
- `changes` (JSON)

**Endpoint**
`GET /api/activity-logs`

---

## 📦 Database Schema

**Tables**
- `users`
- `dokters`
- `pasiens`
- `activity_logs`
- `personal_access_tokens`

---

## 🌱 Seeder (Dummy Data)

DatabaseSeeder menyediakan:
- 1 Admin user  
  `admin@hospital.com / password`
- 1 Staff user  
  `staff@hospital.com / password`
- 5 Dokter
- 8 Pasien

---

## 📋 API Response Format

### Success
```json
{
  "success": true,
  "message": "Data retrieved successfully",
  "data": {}
}
```
### Error
```
{
  "success": false,
  "message": "Unauthorized access",
  "errors": []
}
```
---
## 🚀 Installation & Setup
```
git clone https://github.com/yourusername/hospital-api.git
cd hospital-api
composer install
cp .env.example .env
php artisan key:generate
```
### Database
```
php artisan migrate --seed
```
### Run Server
```
php artisan serve
```
---
## 🧪 Testing
- Feature & Unit tests menggunakan Laravel Testing
- API testing menggunakan Postman / Insomnia
- Authentication menggunakan Bearer Token

---
