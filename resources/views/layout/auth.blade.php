<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Login') — Perpustakaan</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
body{
    min-height:100vh;
    background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 50%,#1e293b 100%);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
}
.auth-wrapper{
    width:100%;
    max-width:420px;
}
.auth-logo{
    text-align:center;
    margin-bottom:28px;
    color:white;
}
.auth-logo i{
    font-size:42px;
    margin-bottom:8px;
    display:block;
    background:linear-gradient(135deg,#60a5fa,#3b82f6);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}
.auth-logo h1{font-size:22px;font-weight:700;letter-spacing:-0.5px}
.auth-logo p{font-size:13px;color:#94a3b8;margin-top:4px}
.auth-card{
    background:white;
    padding:32px;
    border-radius:16px;
    box-shadow:0 25px 50px -12px rgba(0,0,0,.25);
}
.auth-card h2{
    font-size:22px;
    font-weight:700;
    color:#0f172a;
    margin-bottom:4px;
}
.auth-card .subtitle{
    font-size:14px;
    color:#64748b;
    margin-bottom:24px;
}
.form-group{margin-bottom:16px}
.form-group label{
    display:block;
    margin-bottom:6px;
    font-size:14px;
    color:#334155;
    font-weight:500;
}
.form-group input,
.form-group select{
    width:100%;
    padding:11px 14px;
    border:1.5px solid #e2e8f0;
    border-radius:10px;
    font-size:14px;
    color:#1e293b;
    outline:none;
    transition:border-color .2s;
}
.form-group input:focus{border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.1)}
.form-group .error{color:#ef4444;font-size:12px;margin-top:4px}
.alert-error{
    background:#fef2f2;
    color:#b91c1c;
    padding:12px 14px;
    border-radius:10px;
    margin-bottom:18px;
    font-size:14px;
    border:1px solid #fecaca;
}
.alert-success{
    background:#f0fdf4;
    color:#15803d;
    padding:12px 14px;
    border-radius:10px;
    margin-bottom:18px;
    font-size:14px;
    border:1px solid #bbf7d0;
}
.btn-primary{
    width:100%;
    background:linear-gradient(135deg,#1e3a8a,#2563eb);
    color:white;
    border:none;
    padding:12px;
    border-radius:10px;
    font-weight:600;
    font-size:15px;
    cursor:pointer;
    transition:all .2s;
    box-shadow:0 4px 6px -1px rgba(30,58,138,.3);
    margin-top:4px;
}
.btn-primary:hover{
    transform:translateY(-1px);
    box-shadow:0 8px 15px -3px rgba(30,58,138,.4);
}
.auth-footer{
    text-align:center;
    margin-top:20px;
    font-size:14px;
    color:#64748b;
}
.auth-footer a{color:#3b82f6;text-decoration:none;font-weight:600}
.auth-footer a:hover{text-decoration:underline}
</style>
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Perpustakaan" style="height: 140px; width: auto; object-fit: contain; margin-bottom: 20px;">
        <h1>Perpustakaan</h1>
        <p>Sistem Manajemen Perpustakaan Sekolah</p>
    </div>
    @yield('content')
</div>
</body>
</html>
