<!DOCTYPE html>
<html lang="vi" data-theme="admin">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title','Auth') • Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="/assets/css/admin.css?v=1" rel="stylesheet">
  <style>
    body{min-height:100vh;display:flex;align-items:center;justify-content:center;background:#0f172a;color:#f1f5f9;font-family:Inter,system-ui,sans-serif;padding:1.5rem;}
    .auth-card{width:100%;max-width:380px;background:#1e293b;border:1px solid #334155;border-radius:12px;padding:2rem 1.75rem;box-shadow:0 8px 30px -8px rgba(0,0,0,.5);}
    .form-control{background:#0f172a;color:#f1f5f9;border-color:#334155;}
    .form-control:focus{border-color:#1d4ed8;box-shadow:0 0 0 .15rem rgba(29,78,216,.25)}
    .btn-primary{background:#1d4ed8;border-color:#1d4ed8}
    .btn-primary:hover{background:#2563eb;border-color:#2563eb}
  </style>
  @stack('head')
</head>
<body>
  @yield('content')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>