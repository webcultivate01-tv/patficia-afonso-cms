<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login – PatriDesigns</title>
  <link rel="stylesheet" href="style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body class="login-body">

  <div class="login-card">
    <a href="index.html" class="login-back"><i class="fas fa-arrow-left"></i> Back to site</a>

    <div class="login-logo">Patri<span>Designs</span></div>
    <h2>Admin Login</h2>
    <p class="login-sub">Enter your credentials to access the panel</p>

    <?php if (!empty($error)): ?>
      <div class="login-error"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=login" class="login-form">
      <div class="login-field">
        <label>Email</label>
        <div class="login-input-wrap">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" placeholder="admin@patridesigns.com" required autofocus/>
        </div>
      </div>
      <div class="login-field">
        <label>Password</label>
        <div class="login-input-wrap">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" placeholder="••••••••" required/>
        </div>
      </div>
      <button type="submit" class="btn-primary login-btn">
        Sign In <i class="fas fa-arrow-right"></i>
      </button>
    </form>
  </div>

</body>
</html>
