<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Login — Your Shop</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    min-height: 100vh;
    background: #f4f2ee;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    -webkit-font-smoothing: antialiased;
  }

  .split {
    display: flex;
    width: 100%;
    max-width: 820px;
    border-radius: 24px;
    overflow: hidden;
    border: 1px solid #dddbd5;
    box-shadow: 0 8px 40px rgba(0,0,0,0.08);
  }

  /* ── Left Panel ── */
  .left-panel {
    width: 260px;
    flex-shrink: 0;
    background: #1c1c1c;
    padding: 2.5rem 2rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .store-badge {
    width: 46px;
    height: 46px;
    border-radius: 13px;
    background: #2a2a2a;
    border: 1px solid #333;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 2rem;
  }
  .store-badge i { color: #fff; font-size: 22px; }

  .lp-title {
    font-size: 18px;
    font-weight: 600;
    color: #ffffff;
    line-height: 1.4;
    margin-bottom: .75rem;
  }
  .lp-sub {
    font-size: 13px;
    color: #777;
    line-height: 1.65;
  }

  .stat-row { display: flex; flex-direction: column; gap: 0; }
  .stat-item {
    border-top: 1px solid #272727;
    padding: 14px 0;
  }
  .stat-num {
    font-size: 22px;
    font-weight: 600;
    color: #fff;
    line-height: 1;
  }
  .stat-label {
    font-size: 11px;
    color: #555;
    margin-top: 5px;
    letter-spacing: .06em;
    text-transform: uppercase;
  }

  /* ── Right Panel ── */
  .right-panel {
    flex: 1;
    background: #ffffff;
    padding: 3rem 2.75rem;
  }

  .rp-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #f2efea;
    border-radius: 100px;
    padding: 5px 13px 5px 9px;
    font-size: 12px;
    color: #888;
    margin-bottom: 1.25rem;
  }
  .rp-tag i { font-size: 14px; color: #aaa; }

  .rp-title {
    font-size: 24px;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 6px;
  }
  .rp-sub {
    font-size: 14px;
    color: #999;
    margin-bottom: 2rem;
  }

  /* Error banner */
  .err-box {
    display: none;
    align-items: center;
    gap: 9px;
    background: #fef2f2;
    border: 1px solid #fca5a5;
    border-radius: 12px;
    padding: 11px 14px;
    margin-bottom: 1.25rem;
    font-size: 13px;
    color: #b91c1c;
  }
  .err-box i { font-size: 16px; flex-shrink: 0; }

  /* Fields */
  .field-group { margin-bottom: 1.25rem; }
  .field-label {
    display: block;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: #aaa;
    margin-bottom: 8px;
  }
  .field-inner { position: relative; }
  .field-inner .fi {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 17px;
    color: #ccc;
    pointer-events: none;
  }
  .field-inner input {
    width: 100%;
    padding: 13px 14px 13px 42px;
    font-size: 14px;
    border: 1px solid #e8e5e0;
    border-radius: 13px;
    background: #fafaf8;
    color: #1a1a1a;
    outline: none;
    font-family: inherit;
    transition: border-color .15s, background .15s, box-shadow .15s;
  }
  .field-inner input:focus {
    border-color: #1a1a1a;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(26,26,26,0.06);
  }
  .field-inner input::placeholder { color: #ccc; }

  .eye-btn {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #ccc;
    font-size: 17px;
    display: flex;
    align-items: center;
    padding: 3px;
    transition: color .15s;
  }
  .eye-btn:hover { color: #666; }

  /* Meta row */
  .row-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.75rem;
  }
  .check-row {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #888;
    cursor: pointer;
    user-select: none;
  }
  .check-row input[type="checkbox"] {
    accent-color: #1a1a1a;
    width: 15px;
    height: 15px;
    cursor: pointer;
  }
  .link-forgot {
    font-size: 13px;
    color: #999;
    text-decoration: none;
    border-bottom: 1px solid #e0ddd8;
    padding-bottom: 1px;
    transition: color .15s, border-color .15s;
  }
  .link-forgot:hover { color: #1a1a1a; border-color: #aaa; }

  /* Sign in button */
  .btn-main {
    width: 100%;
    padding: 14px;
    background: #1a1a1a;
    color: #fff;
    border: none;
    border-radius: 13px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-family: inherit;
    letter-spacing: .01em;
    transition: background .15s, transform .1s;
  }
  .btn-main:hover { background: #2a2a2a; }
  .btn-main:active { transform: scale(0.985); }
  .btn-main i { font-size: 18px; }

  /* Divider */
  .divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 1.6rem 0;
  }
  .divider span { height: 1px; flex: 1; background: #ece9e4; }
  .divider p { font-size: 12px; color: #bbb; white-space: nowrap; }

  /* Credentials pill */
  .cred-pill {
    display: flex;
    align-items: center;
    gap: 11px;
    background: #f9f8f5;
    border: 1px solid #eceae4;
    border-radius: 13px;
    padding: 12px 15px;
  }
  .cred-pill i { font-size: 17px; color: #bbb; flex-shrink: 0; }
  .cred-text { font-size: 12px; color: #bbb; }
  .cred-text span {
    font-family: 'SFMono-Regular', 'Menlo', 'Consolas', monospace;
    color: #555;
    font-size: 12px;
  }

  /* Responsive */
  @media (max-width: 640px) {
    body { padding: 1rem; align-items: flex-start; padding-top: 2rem; }
    .split { flex-direction: column; border-radius: 20px; }
    .left-panel { width: 100%; padding: 2rem 1.75rem; }
    .stat-row { flex-direction: row; gap: 0; }
    .stat-item { flex: 1; border-top: none; border-left: 1px solid #272727; padding: 0 1rem; }
    .stat-item:first-child { border-left: none; padding-left: 0; }
    .right-panel { padding: 2rem 1.75rem; }
  }
</style>
</head>
<body>

<div class="split">

  <!-- Left Panel -->
  <div class="left-panel">
    <div>
      <div class="store-badge">
        <i class="ti ti-building-store"></i>
      </div>
      <p class="lp-title">Your Shop<br>Admin Panel</p>
      <p class="lp-sub">Manage orders, products, customers and analytics from one place.</p>
    </div>
  </div>
  </div>


  <!-- Right Panel -->
  <div class="right-panel">

    <div class="rp-tag">
      <i class="ti ti-shield-check"></i> Secure access
    </div>
    <h1 class="rp-title">Welcome back</h1>
    <p class="rp-sub">Sign in to continue to your dashboard</p>

    <!-- Error banner (shown on validation failure) -->
    <div class="err-box" id="errBox">
      <i class="ti ti-alert-circle"></i>
      <span id="errMsg">Please check your credentials.</span>
    </div>

    <!-- Login Form -->
    <form id="loginForm" method="post" novalidate>

      <div class="field-group">
        <label class="field-label" for="email">Email address</label>
        <div class="field-inner">
          <i class="fi ti ti-mail"></i>
          <input
            type="email"
            id="email"
            name="email"
            placeholder="admin@shop.com"
            value="admin@shop.com"
            autocomplete="email"
            required>
        </div>
      </div>

      <div class="field-group">
        <label class="field-label" for="password">Password</label>
        <div class="field-inner">
          <i class="fi ti ti-lock"></i>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="••••••••"
            value="admin123"
            autocomplete="current-password"
            minlength="6"
            required>
          <button type="button" class="eye-btn" id="eyeBtn" aria-label="Toggle password visibility">
            <i class="ti ti-eye" id="eyeIcon"></i>
          </button>
        </div>
      </div>

      <div class="row-meta">
        <label class="check-row">
          <input type="checkbox" name="remember" checked> Keep me signed in
        </label>
        <a href="#" class="link-forgot">Forgot password?</a>
      </div>

      <button class="btn-main" type="submit" id="signBtn">
        <i class="ti ti-login"></i> Sign in to dashboard
      </button>

    </form>

    <div class="divider">
      <span></span>
      <p>default credentials</p>
      <span></span>
    </div>

    <div class="cred-pill">
      <i class="ti ti-key"></i>
      <div class="cred-text">
        <span>admin@shop.com</span>&nbsp;&nbsp;/&nbsp;&nbsp;<span>admin123</span>
      </div>
    </div>

  </div>
</div>

<script>
  // Password toggle
  document.getElementById('eyeBtn').addEventListener('click', function () {
    var input = document.getElementById('password');
    var icon  = document.getElementById('eyeIcon');
    var show  = input.type === 'password';
    input.type = show ? 'text' : 'password';
    icon.className = show ? 'ti ti-eye-off' : 'ti ti-eye';
  });

  // Form validation
  document.getElementById('loginForm').addEventListener('submit', function (e) {
    var email = document.getElementById('email').value.trim();
    var pass  = document.getElementById('password').value;
    var box   = document.getElementById('errBox');
    var msg   = document.getElementById('errMsg');
    var re    = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!re.test(email)) {
      e.preventDefault();
      msg.textContent = 'Please enter a valid email address.';
      box.style.display = 'flex';
      return;
    }
    if (pass.length < 6) {
      e.preventDefault();
      msg.textContent = 'Password must be at least 6 characters.';
      box.style.display = 'flex';
      return;
    }

    box.style.display = 'none';

    // Visual feedback while form submits
    var btn = document.getElementById('signBtn');
    btn.innerHTML = '<i class="ti ti-loader-2" style="animation:spin .8s linear infinite"></i> Signing in...';
    btn.disabled = true;
  });
</script>

<style>
  @keyframes spin { to { transform: rotate(360deg); } }
</style>

</body>
</html>