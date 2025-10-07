# 🦷 Dental Clinic Management System

A comprehensive dental clinic management system built with Laravel 12.x, featuring patient management, appointment scheduling, and advanced analytics dashboard for doctors and administrators.

## 🏥 Single Doctor/Admin Workflow

This system is designed for single-doctor dental clinics where one person manages both administrative tasks and medical consultations.

## 🚀 Quick Start

### Default Login Credentials

**Admin/Doctor Dashboard:** `/admin`
- **Email:** `bsviet@clinic.com`
- **Password:** `password`
- **Role:** BS. Nguyễn Văn Việt (Admin + Doctor)

### View Login Info
```bash
php artisan clinic:show-login
```

### Environment Configuration

Update `.env` file to customize doctor information:
```bash
DOCTOR_NAME="BS. Nguyễn Văn Việt"
DOCTOR_EMAIL=bsviet@clinic.com
DOCTOR_PASSWORD=password
```

### Setup Database
```bash
php artisan migrate:fresh --seed
```

### Aiven Cloud Integration

Check Aiven service status:
```bash
php artisan aiven:status
```

Configure Aiven API in `.env`:
```bash
AIVEN_API_TOKEN=your-api-token
AIVEN_PROJECT_NAME=dentalclinic
```

## 🔧 Features

- **Single Doctor Workflow** - Unified admin/doctor dashboard
- **Patient Management** - Complete patient records and history
- **Appointment Scheduling** - Online booking with automatic doctor assignment
- **Analytics Dashboard** - Real-time clinic metrics and insights
- **Responsive Design** - Works on desktop and mobile devices
- **Optimized Database** - Clean schema with only essential tables (10 tables)
