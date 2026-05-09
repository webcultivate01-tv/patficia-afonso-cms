<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <title>PAGraphics — Admin Login</title>

  <!-- Fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
    rel="stylesheet"
  />

  <!-- Icons -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  />

  <style>

    *{
      margin:0;
      padding:0;
      box-sizing:border-box;
    }

    html{
      scroll-behavior:smooth;
    }

    body{
      font-family:'Inter',sans-serif;

      min-height:100vh;

      background:#050505;

      overflow:hidden;

      display:flex;
      align-items:center;
      justify-content:center;

      padding:30px;

      position:relative;
    }

    /* =========================
       BACKGROUND GRID
    ========================= */

    .bg-grid{
      position:absolute;
      inset:0;

      background-image:
      linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
      linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);

      background-size:60px 60px;

      mask-image:
      radial-gradient(circle at center, black 20%, transparent 80%);
    }

    /* =========================
       GLOW EFFECT
    ========================= */

    .bg-glow{
      position:absolute;

      width:500px;
      height:500px;

      border-radius:50%;

      background:
      rgba(240,192,58,0.14);

      filter:blur(120px);

      animation:
      glowFloat 8s ease-in-out infinite alternate;
    }

    .glow-1{
      top:-150px;
      left:-120px;
    }

    .glow-2{
      bottom:-180px;
      right:-120px;
    }

    @keyframes glowFloat{
      from{
        transform:translateY(0px);
      }

      to{
        transform:translateY(40px);
      }
    }

    /* =========================
       LOGIN CARD
    ========================= */

    .login-card{
      position:relative;
      z-index:10;

      width:100%;
      max-width:560px;

      background:
      linear-gradient(
        180deg,
        rgba(255,255,255,0.06),
        rgba(255,255,255,0.03)
      );

      backdrop-filter:blur(24px);

      border:
      1px solid rgba(255,255,255,0.08);

      border-radius:42px;

      padding:54px;

      overflow:hidden;

      box-shadow:
      0 40px 120px rgba(0,0,0,0.45);

      animation:
      cardReveal 1.1s cubic-bezier(0.22,1,0.36,1) forwards;

      opacity:0;

      transform:translateY(40px);
    }

    @keyframes cardReveal{
      to{
        opacity:1;
        transform:translateY(0);
      }
    }

    /* =========================
       CARD GLOW
    ========================= */

    .login-card::before{
      content:"";

      position:absolute;

      top:-100px;
      right:-100px;

      width:240px;
      height:240px;

      border-radius:50%;

      background:
      rgba(240,192,58,0.12);

      filter:blur(80px);
    }

    /* =========================
       BACK BUTTON
    ========================= */

    .login-back{
      display:inline-flex;
      align-items:center;
      gap:10px;

      text-decoration:none;

      color:#9ca3af;

      font-size:14px;
      font-weight:500;

      margin-bottom:50px;

      transition:all .4s ease;
    }

    .login-back:hover{
      color:#F0C03A;

      transform:translateX(-4px);
    }

    /* =========================
       LOGO
    ========================= */

    .login-logo{
      font-size:46px;
      font-weight:900;

      color:white;

      letter-spacing:-2px;

      line-height:1;

      margin-bottom:42px;
    }

    .login-logo span{
      color:#F0C03A;
    }

    /* =========================
       HEADING
    ========================= */

    .login-label{
      color:#F0C03A;

      text-transform:uppercase;

      letter-spacing:4px;

      font-size:11px;

      font-weight:700;

      margin-bottom:18px;
    }

    .login-heading{
      color:white;

      font-size:56px;

      font-weight:900;

      line-height:0.92;

      letter-spacing:-3px;

      margin-bottom:20px;
    }

    .login-sub{
      color:#9ca3af;

      font-size:16px;

      line-height:1.8;

      max-width:420px;

      margin-bottom:42px;
    }

    /* =========================
       ERROR
    ========================= */

    .login-error{
      background:
      rgba(239,68,68,0.08);

      border:
      1px solid rgba(239,68,68,0.2);

      color:#fca5a5;

      padding:16px 18px;

      border-radius:18px;

      margin-bottom:30px;

      display:flex;
      align-items:center;
      gap:10px;

      font-size:14px;
    }

    /* =========================
       FORM
    ========================= */

    .login-form{
      display:flex;
      flex-direction:column;

      gap:28px;
    }

    /* =========================
       LABEL
    ========================= */

    .form-label{
      display:block;

      color:#d1d5db;

      font-size:11px;

      font-weight:600;

      text-transform:uppercase;

      letter-spacing:3px;

      margin-bottom:14px;
    }

    /* =========================
       INPUT WRAP
    ========================= */

    .form-input-wrap{
      position:relative;

      height:66px;

      background:
      rgba(255,255,255,0.03);

      border:
      1px solid rgba(255,255,255,0.08);

      border-radius:18px;

      overflow:hidden;

      transition:
      all .4s ease;
    }

    .form-input-wrap:hover{
      background:
      rgba(255,255,255,0.05);
    }

    .form-input-wrap:focus-within{
      border-color:
      rgba(240,192,58,0.45);

      transform:translateY(-2px);

      box-shadow:
      0 10px 30px rgba(240,192,58,0.08);
    }

    /* =========================
       ICON
    ========================= */

    .form-icon{
      position:absolute;

      left:22px;
      top:50%;

      transform:translateY(-50%);

      color:#6b7280;

      font-size:14px;

      transition:all .4s ease;
    }

    .form-input-wrap:focus-within .form-icon{
      color:#F0C03A;
    }

    /* =========================
       INPUT
    ========================= */

    .form-input{
      width:100%;
      height:100%;

      background:transparent;

      border:none;
      outline:none;

      padding:
      0 22px 0 56px;

      color:white;

      font-size:15px;
      font-weight:500;
    }

    .form-input::placeholder{
      color:#6b7280;
    }

    /* =========================
       OPTIONS
    ========================= */

    .form-options{
      display:flex;
      align-items:center;
      justify-content:space-between;

      gap:20px;

      margin-top:-4px;
    }

    .remember-wrap{
      display:flex;
      align-items:center;

      gap:10px;

      color:#9ca3af;

      font-size:14px;

      cursor:pointer;
    }

    .remember-wrap input{
      accent-color:#F0C03A;

      width:16px;
      height:16px;
    }

    .forgot-link{
      color:#F0C03A;

      text-decoration:none;

      font-size:14px;
      font-weight:500;

      transition:opacity .4s ease;
    }

    .forgot-link:hover{
      opacity:.7;
    }

    /* =========================
       BUTTON
    ========================= */

    .login-btn{
      margin-top:10px;

      height:66px;

      border:none;

      border-radius:999px;

      background:#F0C03A;

      color:black;

      font-size:15px;
      font-weight:700;

      cursor:pointer;

      display:flex;
      align-items:center;
      justify-content:center;

      gap:14px;

      transition:
      transform .5s cubic-bezier(0.22,1,0.36,1),
      box-shadow .5s ease,
      background .5s ease;
    }

    .login-btn:hover{
      transform:
      translateY(-4px)
      scale(1.01);

      background:#ffd95c;

      box-shadow:
      0 20px 40px rgba(240,192,58,0.25);
    }

    .login-btn i{
      transition:transform .4s ease;
    }

    .login-btn:hover i{
      transform:translateX(4px);
    }

    /* =========================
       RESPONSIVE
    ========================= */

    @media(max-width:768px){

      body{
        padding:20px;
      }

      .login-card{
        padding:38px 28px;

        border-radius:32px;
      }

      .login-logo{
        font-size:38px;
      }

      .login-heading{
        font-size:42px;
      }

      .login-sub{
        font-size:15px;
      }

      .form-options{
        flex-direction:column;
        align-items:flex-start;
      }
    }

  </style>
</head>

<body>

  <!-- Background -->
  <div class="bg-grid"></div>

  <div class="bg-glow glow-1"></div>
  <div class="bg-glow glow-2"></div>

  <!-- Login Card -->
  <div class="login-card">

    <!-- Back -->
    <a href="index.html" class="login-back">
      <i class="fas fa-arrow-left"></i>
      Back to site
    </a>

    <!-- Logo -->
    <div class="login-logo">
      <span>PA</span>Graphics
    </div>

    <!-- Heading -->
    <p class="login-label">
      Secure Access
    </p>

    <h1 class="login-heading">
      Studio Admin Panel
    </h1>

    <p class="login-sub">
      Access the PAGraphics dashboard, client projects, and creative management system.
    </p>

    <!-- PHP Error -->
    <?php if (!empty($error)): ?>
      <div class="login-error">
        <i class="fas fa-circle-exclamation"></i>
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <!-- Form -->
    <form
      method="POST"
      action="index.php?page=login"
      class="login-form"
    >

      <!-- Email -->
      <div>

        <label class="form-label">
          Email Address
        </label>

        <div class="form-input-wrap">

          <i class="fas fa-envelope form-icon"></i>

          <input
            type="email"
            name="email"
            placeholder="admin@pagraphics.com"
            class="form-input"
            required
            autofocus
          />

        </div>
      </div>

      <!-- Password -->
      <div>

        <label class="form-label">
          Password
        </label>

        <div class="form-input-wrap">

          <i class="fas fa-lock form-icon"></i>

          <input
            type="password"
            name="password"
            placeholder="Enter your password"
            class="form-input"
            required
          />

        </div>
      </div>

      <!-- Options -->
      <div class="form-options">

        <label class="remember-wrap">

          <input type="checkbox"/>

          <span>Remember me</span>

        </label>

        <a href="#" class="forgot-link">
          Forgot Password?
        </a>

      </div>

      <!-- Button -->
      <button
        type="submit"
        class="login-btn"
      >
        <span>Sign In</span>

        <i class="fas fa-arrow-right"></i>
      </button>

    </form>

  </div>

</body>
</html>