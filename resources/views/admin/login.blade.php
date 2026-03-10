<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin Login – MariaBakes</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Nunito:wght@400;700;800;900&display=swap" rel="stylesheet">
  <style>
    *{margin:0;padding:0;box-sizing:border-box;}
    body{font-family:'Nunito',sans-serif;background:#fff8f0;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;}
    .card{background:white;border-radius:28px;padding:48px 40px;max-width:400px;width:100%;box-shadow:0 8px 40px rgba(61,31,15,.1);}
    .logo{text-align:center;margin-bottom:32px;}
    .logo-icon{width:64px;height:64px;border-radius:50%;background:#f9b8c4;display:inline-flex;align-items:center;justify-content:center;font-size:28px;margin-bottom:12px;}
    .brand{font-family:'Playfair Display',serif;font-size:24px;color:#3d1f0f;}<br>    .brand span{color:#c45c7a;}
    .sub{font-size:12px;color:rgba(61,31,15,.4);text-transform:uppercase;letter-spacing:.1em;margin-top:4px;}
    label{display:block;font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:rgba(61,31,15,.5);margin-bottom:6px;}
    input[type=password]{width:100%;background:#fff8f0;border:2px solid rgba(61,31,15,.12);border-radius:14px;padding:14px 18px;font-family:'Nunito',sans-serif;font-size:15px;color:#3d1f0f;outline:none;transition:border-color .2s;}
    input[type=password]:focus{border-color:#e8849a;}
    .err{color:#e84545;font-size:13px;font-weight:700;margin-top:6px;}
    button{width:100%;margin-top:20px;padding:16px;background:#3d1f0f;color:white;border:none;border-radius:100px;font-family:'Nunito',sans-serif;font-weight:800;font-size:15px;cursor:pointer;transition:all .25s;}
    button:hover{background:#7a3e1e;}
  </style>
</head>
<body>
  <div class="card">
    <div class="logo">
      <div class="logo-icon">🍪</div>
      <div class="brand"><span>Maria</span>Bakes</div>
      <div class="sub">Admin Panel</div>
    </div>
    <form method="POST" action="{{ route('admin.login.post') }}">
      @csrf
      <label>Password</label>
      <input type="password" name="password" placeholder="Enter admin password" autofocus>
      @error('password')<div class="err">{{ $message }}</div>@enderror
      <button type="submit">Log In →</button>
    </form>
  </div>
</body>
</html>
