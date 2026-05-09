<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login – PatriDesigns</title>

  <!-- Fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap"
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

    body{
      font-family:'Inter',sans-serif;
      background:#050505;
      min-height:100vh;
      overflow:hidden;
      position:relative;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:30px;
    }

    /* =========================
       BACKGROUND
    ========================= */

    .bg-grid{
      position:absolute;
      inset:0;

      background-image:
      linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
      linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);

      background-size:60px 60px;

      mask-image:radial-gradient(circle at center, black 20%, transparent 80%);
    }

    .bg-glow{
      position:absolute;

      width:500px;
      height:500px;

      border-radius:50%;

      background:rgba(240,192,58,0.15);

      filter:blur(120px);

      animation:floatGlow 8s ease-in-out infinite alternate;
    }

    .glow-1{
      top:-120px;
      left:-100px;
    }

    .glow-2{
      bottom:-150px;
      right:-120px;
    }

    @keyframes floatGlow{
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
      max-width:520px;

      background:rgba(255,255,255,0.04);

      backdrop-filter:blur(20px);

      border:1px solid rgba(255,255,255,0.08);

      border-radius:36px;

      padding:50px;

      box-shadow:
      0 30px 80px rgba(0,0,0,0.45);

      animation:cardReveal 1.1s cubic-bezier(0.22,1,0.36,1) forwards;

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
      font-size:42px;
      font-weight:900;
      color:white;

      margin-bottom:18px;

      letter-spacing:-2px;
    }

    .login-logo span{
      color:#F0C03A;
    }

    /* =========================
       HEADING
    ========================= */

    h2{
      color:white;

      font-size:42px;
      font-weight:900;

      line-height:1;

      margin-bottom:16px;

      letter-spacing:-2px;
    }

    .login-sub{
      color:#9ca3af;

      font-size:16px;
      line-height:1.7;

      margin-bottom:40px;
    }

    /* =========================
       ERROR
    ========================= */

    .login-error{
      background:rgba(239,68,68,0.08);

      border:1px solid rgba(239,68,68,0.2);

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
      gap:30px;
    }

    .login-field label{
      display:block;

      color:#d1d5db;

      font-size:11px;
      font-weight:600;

      text-transform:uppercase;

      letter-spacing:3px;

      margin-bottom:18px;
    }

    /* =========================
       INPUT WRAP
    ========================= */

    .login-input-wrap{
      position:relative;

      border-bottom:
      1px solid rgba(255,255,255,0.1);

      transition:all .4s ease;
    }

    .login-input-wrap::after{
      content:"";

      position:absolute;

      left:0;
      bottom:-1px;

      width:0%;
      height:1px;

      background:#F0C03A;

      transition:width .5s cubic-bezier(0.22,1,0.36,1);
    }

    .login-input-wrap:focus-within::after{
      width:100%;
    }

    .login-input-wrap i{
      position:absolute;

      left:0;
      top:50%;

      transform:translateY(-50%);

      color:#6b7280;

      transition:all .4s ease;
    }

    .login-input-wrap:focus-within i{
      color:#F0C03A;
    }

    .login-input-wrap input{
      width:100%;

      background:transparent;

      border:none;
      outline:none;

      padding:
      0 0 18px 34px;

      color:white;

      font-size:16px;
      font-weight:500;
    }

    .login-input-wrap input::placeholder{
      color:#6b7280;
    }

    /* =========================
       BUTTON
    ========================= */

    .login-btn{
      margin-top:10px;

      height:62px;

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
      transform:translateY(-4px);

      box-shadow:
      0 20px 40px rgba(240,192,58,0.25);

      background:#ffd95c;
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
        padding:36px 28px;
        border-radius:28px;
      }

      .login-logo{
        font-size:34px;
      }

      h2{
        font-size:34px;
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
      Patri<span>Designs</span>
    </div>

    <!-- Heading -->
    <h2>
      Admin Login
    </h2>

    <p class="login-sub">
      Secure access to the creative dashboard and project management panel.
    </p>

    <!-- PHP Error -->
    <?php if (!empty($error)): ?>
      <div class="login-error">
        <i class="fas fa-circle-exclamation"></i>
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <!-- Form -->
    <form method="POST" action="index.php?page=login" class="login-form">

      <!-- Email -->
      <div class="login-field">
        <label>Email Address</label>

        <div class="login-input-wrap">
          <i class="fas fa-envelope"></i>

          <input
            type="email"
            name="email"
            placeholder="admin@patridesigns.com"
            required
            autofocus
          />
        </div>
      </div>

      <!-- Password -->
      <div class="login-field">
        <label>Password</label>

        <div class="login-input-wrap">
          <i class="fas fa-lock"></i>

          <input
            type="password"
            name="password"
            placeholder="••••••••"
            required
          />
        </div>
      </div>

      <!-- Button -->
      <button type="submit" class="login-btn">
        Sign In
        <i class="fas fa-arrow-right"></i>
      </button>

    </form>
  </div>

</body>
</html>