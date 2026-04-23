<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign In — ApparelHub</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  html { -webkit-font-smoothing: antialiased; }
  body {
    font-family: 'Inter', sans-serif;
    display: flex; height: 100vh;
    background: #FFFFFF; color: #111110;
  }

  /* ── Split Layout ── */
  .panel-left {
    flex: 1;
    background: url('https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?q=80&w=1400&auto=format&fit=crop') center/cover no-repeat;
    position: relative; overflow: hidden;
    display: flex;
    flex-direction: column;
    padding: 60px;
  }
  .panel-left::after {
    content: ''; position: absolute; inset: 0; z-index: 1;
    background: rgba(0, 0, 0, 0.4);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
  }

  /* Brand / Logo Top Left */
  .brand-logo {
    position: relative; z-index: 10;
    display: flex; align-items: center; gap: 12px; color: #fff;
  }
  .brand-icon { width: 32px; height: 32px; }
  .brand-text { font-size: 1.15rem; font-weight: 700; letter-spacing: -0.5px; }

  /* Text Content pushed to bottom */
  .pl-content {
    position: relative; z-index: 10; color: #fff; max-width: 400px;
    margin-top: auto;
  }
  .pl-content h2 { font-size: 1.3rem; font-weight: 600; margin-bottom: 8px; letter-spacing: -0.2px; line-height: 1.2; text-shadow: 0 1px 3px rgba(0,0,0,0.5); }
  .pl-content p { font-size: 0.85rem; font-weight: 300; opacity: 0.85; line-height: 1.5; text-shadow: 0 1px 2px rgba(0,0,0,0.5); }

  /* ── Right Panel Form ── */
  .panel-right {
    width: 100%; max-width: 540px;
    display: flex; flex-direction: column; justify-content: center;
    padding: 0 80px; position: relative;
    background: #FFFFFF;
  }

  .form-header { margin-bottom: 40px; }
  .form-header h1 { font-size: 1.8rem; font-weight: 700; letter-spacing: -0.5px; margin-bottom: 8px; }
  .form-header p { font-size: .95rem; color: #71717A; }

  .form-group { margin-bottom: 20px; }
  .form-label { display: block; font-size: .8rem; font-weight: 600; margin-bottom: 8px; color: #3F3F46; }
  .form-control {
    width: 100%; padding: 14px 16px; border-radius: 8px;
    border: 1px solid #E4E4E7; font-size: .95rem;
    font-family: 'Inter', sans-serif; transition: all .2s;
    background: #FAFAFA;
  }
  .form-control:focus { outline: none; border-color: #111110; background: #FFF; box-shadow: 0 0 0 1px #111110; }

  .form-options {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 24px; font-size: .8rem;
  }
  .fo-left { display: flex; align-items: center; gap: 8px; color: #71717A; cursor: pointer; }
  .fo-right { color: #A1A1AA; text-decoration: none; transition: .2s; }
  .fo-right:hover { color: #111110; }

  .btn-submit {
    width: 100%; padding: 14px; border-radius: 8px; border: none;
    background: #111110; color: #fff; font-size: 1rem; font-weight: 600;
    cursor: pointer; transition: .2s; font-family: 'Inter', sans-serif;
  }
  .btn-submit:hover { background: #27272A; }

  /* Alert */
  .alert {
    padding: 12px 14px; border-radius: 8px; margin-bottom: 20px;
    font-size: .85rem; font-weight: 500; background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA;
  }

  /* Demo Credentials */
  .demo-creds { margin-top: 40px; padding-top: 20px; border-top: 1px solid #E4E4E7; }
  .dc-title { font-size: .7rem; font-weight: 600; color: #A1A1AA; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; }
  .dc-row { display: flex; justify-content: space-between; font-size: .8rem; padding: 6px 0; border-bottom: 1px solid #F4F4F5; }
  .dc-row:last-child { border-bottom: none; }
  .dc-row .role { font-weight: 600; color: #3F3F46; }
  .dc-row .cred { font-family: monospace; color: #71717A; }

  @media (max-width: 900px) {
    .panel-left { display: none; }
    .panel-right { max-width: 100%; padding: 0 40px; }
    .brand-logo { display:flex; color: #111110; left: 40px; top: 40px; }
  }
</style>
</head>
<body>

<div class="panel-left">
  <div class="brand-logo">
    <svg class="brand-icon" viewBox="0 0 100 100" fill="currentColor">
      <path fill-rule="evenodd" clip-rule="evenodd" d="M85,15 C85,15 95,5 100,0 C100,5 100,10 98,20 C95,35 95,50 95,50 C95,75 75,95 50,95 C25,95 5,75 5,50 C5,25 25,5 50,5 C60,5 75,5 85,15 Z M50,75 C60,75 66,66 66,56 C66,40 50,25 50,25 C50,25 34,40 34,56 C34,66 40,75 50,75 Z" />
    </svg>
    <span class="brand-text">ApparelHub</span>
  </div>
  <div class="pl-content">
    <h2>Elevate Your Boutique</h2>
    <p>A premium management system tailored for clothing retailers. Curate your collections, track seasonal inventory, and deliver seamless shopping experiences.</p>
  </div>
</div>

<div class="panel-right">
  <div class="form-header">
    <h1>Welcome Back!</h1>
    <p>Sign in to your account to continue</p>
  </div>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert"><?php foreach ((array) session()->getFlashdata('errors') as $e) echo "<div>".esc($e)."</div>"; ?></div>
  <?php endif; ?>

  <form action="<?= base_url('login') ?>" method="POST">
    <?= csrf_field() ?>
    <div class="form-group">
      <label class="form-label">Email Address</label>
      <input type="email" name="email" class="form-control" placeholder="admin@apparelhub.com" required autofocus>
    </div>
    <div class="form-group">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" placeholder="••••••••" required>
    </div>
    <div class="form-options">
      <label class="fo-left"><input type="checkbox"> Remember me</label>
      <a href="#" class="fo-right">Forgot Password?</a>
    </div>
    <button type="submit" class="btn-submit">Login</button>
  </form>

  <div class="demo-creds">
    <div class="dc-title">Demo Access (Password: password)</div>
    <div class="dc-row"><span class="role">Admin</span><span class="cred">superadmin@apparelhub.com</span></div>
    <div class="dc-row"><span class="role">Manager</span><span class="cred">manager@apparelhub.com</span></div>
    <div class="dc-row"><span class="role">Staff</span><span class="cred">staff@apparelhub.com</span></div>
  </div>
</div>

</body>
</html>
