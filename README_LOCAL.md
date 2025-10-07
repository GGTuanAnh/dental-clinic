# Dental Clinic Project (Local Readme)

## Admin Panel

Features:
- Session-based authentication (login/logout) instead of Basic Auth.
- Dark / Light theme toggle persisted via localStorage.
- Breadcrumb component for navigation clarity.
- Role-based authorization (roles: admin, doctor, staff) with Gates:
  - manage-images: admin, doctor
  - view-reports: admin
  - manage-appointments: admin, staff
- Dashboard with key metrics (appointments today, pending, totals for patients, doctors, services).
- Login POST route throttled (5 attempts / minute) to reduce brute force risk.
- Seeder: `php artisan db:seed --class=AdminUserSeeder` creates `admin@example.com` (password: ChangeMe123! — CHANGE after first login!).

## Seeding Default Admin
```
php artisan migrate --seed --class=AdminUserSeeder
```
Or run separately after migrations:
```
php artisan db:seed --class=AdminUserSeeder
```

## Roles Guidance
- admin: Full access to everything.
- doctor: Can manage images (e.g., before/after), view appointments (future granular controls), limited reports (future).
- staff: Operational tasks like managing appointments & patient updates.

## Next Ideas
- Add Policy classes for granular per-model control.
- Track revenue metrics once billing model defined.
- Audit log for critical actions (image delete, report export).
