<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Form Login Sederhana</title>
  <style>
    :root{--bg:#f4f7fb;--card:#ffffff;--accent:#2563eb;--muted:#6b7280}
    *{box-sizing:border-box}
    body{margin:0;font-family:Inter,ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,'Helvetica Neue',Arial;background:var(--bg);display:flex;align-items:center;justify-content:center;height:100vh}
    .card{background:var(--card);width:360px;border-radius:12px;box-shadow:0 8px 30px rgba(2,6,23,0.08);padding:28px}
    h1{margin:0 0 12px;font-size:20px;color:#111827}
    p.lead{margin:0 0 18px;color:var(--muted);font-size:14px}
    .field{margin-bottom:14px}
    label{display:block;font-size:13px;color:#374151;margin-bottom:6px}
    input[type="text"],input[type="password"]{width:100%;padding:10px 12px;border:1px solid #e6e9ef;border-radius:8px;font-size:14px}
    .actions{display:flex;align-items:center;justify-content:space-between;margin-top:10px}
    button{background:var(--accent);color:white;border:none;padding:10px 14px;border-radius:8px;font-weight:600;cursor:pointer}
    button:disabled{opacity:0.6;cursor:not-allowed}
    .helper{font-size:13px;color:var(--muted)}
    .error{color:#dc2626;font-size:13px;margin-top:8px}
    .success{color:#16a34a;font-size:14px;margin-top:8px}
    .note{font-size:12px;color:#9ca3af;margin-top:10px}
    .center{display:flex;justify-content:center}
  </style>
</head>
<body>
  <main class="card" role="main">
    <h1>Masuk</h1>
    <p class="lead">Silakan masukkan username dan password Anda.</p>

    <form id="loginForm" autocomplete="off">
      <div class="field">
        <label for="username">Username</label>
        <input id="username" name="username" type="text" placeholder="contoh: arul" required />
      </div>

      <div class="field">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" placeholder="••••••••" required />
      </div>

      <div class="actions">
        <div class="helper"><input id="remember" type="checkbox" /> <label for="remember">Ingat saya</label></div>
        <button type="submit" id="btnSubmit">Masuk</button>
      </div>

      <div id="msg" aria-live="polite"></div>

      <p class="note">Contoh kredensial demo — Username: <b>admin</b> | Password: <b>password</b></p>
    </form>
  </main>

  <script>
    // Form login sederhana (frontend only)
    const form = document.getElementById('loginForm');
    const msg = document.getElementById('msg');
    const btn = document.getElementById('btnSubmit');

    form.addEventListener('submit', function(e){
      e.preventDefault();
      msg.textContent = '';
      msg.className = '';

      const username = form.username.value.trim();
      const password = form.password.value.trim();

      // Validasi sederhana
      if(!username || !password){
        msg.textContent = 'Username dan password harus diisi.';
        msg.className = 'error';
        return;
      }

      btn.disabled = true;
      btn.textContent = 'Memproses...';

      // Simulasi pengecekan ke server (di dunia nyata, gunakan fetch/AJAX ke backend)
      setTimeout(() => {
        // Contoh kredensial demo: admin / password
        if(username === 'admin' && password === 'password'){
          msg.textContent = 'Login berhasil! Mengarahkan...';
          msg.className = 'success';

          // Contoh redirect setelah login
          setTimeout(() => {
            // Di dunia nyata ganti URL dengan dashboard sebenarnya
            window.location.href = './dashboard.html';
          }, 900);
        } else {
          msg.textContent = 'Username atau password salah.';
          msg.className = 'error';
          btn.disabled = false;
          btn.textContent = 'Masuk';
        }
      }, 800);
    });
  </script>
</body>
</html>