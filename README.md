# 🦷 Dental Clinic Management System

A comprehensive dental clinic management system built with Laravel 12.x, featuring patient management, appointment scheduling, and advanced analytics dashboard for doctors and administrators.

## ✨ Features

### 🌐 Public Website
- **Landing Pages**: Home, Services, About, Contact, Gallery, Pricing, Testimonials, FAQ
- **Appointment Booking**: Online booking form with honeypot protection and rate limiting
- **Responsive Design**: Mobile-first design with Bootstrap 5
- **Media Management**: Dynamic image transformation with caching

### 👨‍⚕️ Doctor Dashboard
- **Advanced Analytics**: Revenue tracking, completion rates, lead times
- **Interactive Charts**: Line, doughnut, and bar charts with Chart.js
- **Time Range Filtering**: 7, 30, 90-day views with real-time data
- **Revenue Alerts**: Automatic alerts for significant revenue drops
- **Appointment Management**: View and manage doctor-specific appointments

### 🔐 Admin Panel
- **Role-Based Access**: Admin, Doctor, Staff roles with granular permissions
- **Patient Management**: Complete patient records with notes and prescriptions
- **Appointment Tracking**: Status management and administrative oversight
- **Image Gallery**: Centralized media management for services and doctors
- **Audit Logging**: Comprehensive activity tracking for security and compliance
- **Theme Support**: Dark/Light mode with seamless switching

## 🛠️ Technical Stack

- **Backend**: Laravel 12.x with PHP 8.2+
- **Database**: MySQL 8.x with optimized schema
- **Frontend**: Bootstrap 5 + Chart.js 4.x
- **Caching**: Redis-compatible caching with 60s TTL for dashboards
- **Authentication**: Session-based auth with policy-driven authorization
- **Security**: CSRF protection, rate limiting, audit logging

## 📊 Advanced Features

### Dashboard Metrics
- **Completion Rate**: Ratio of completed to confirmed appointments
- **Average Revenue per Appointment**: Financial performance tracking
- **Lead Time Analysis**: Time between booking and appointment
- **Revenue Drop Alerts**: Automatic notifications for performance issues

### Data Management
- **Migration-Driven Schema**: Version-controlled database changes
- **Seeded Data**: Admin and doctor accounts with sample data
- **Policy-Based Authorization**: Fine-grained access control
- **Audit Trail**: Complete activity logging with user attribution

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/GGTuanAnh/dental-clinic.git
   cd dental-clinic
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed --class=AdminUserSeeder
   php artisan db:seed --class=DoctorUserSeeder
   ```

5. **Start development server**
   ```bash
   php artisan serve
   ```

## 🔑 Default Credentials

- **Admin**: `admin@example.com` / `password123`
- **Doctor**: `doctor@example.com` / `password123`

## 📋 Todo Roadmap

### Upcoming Features
- [ ] Drill-down appointment modals
- [ ] CSV/PDF export functionality  
- [ ] Chart image downloads
- [ ] Real-time polling updates
- [ ] Enhanced RBAC for patients
- [ ] Stacked status charts
- [ ] Skeleton loading animations
- [ ] Dark mode chart palettes

### Advanced Development
- [ ] Cache invalidation strategies
- [ ] WebSocket integration
- [ ] Mobile app API
- [ ] Multi-clinic support

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

Built with ❤️ using Laravel 12.x | © 2025 Dental Clinic Management System
