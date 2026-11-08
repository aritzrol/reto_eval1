<!doctype html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="CSS/loginStyles.css" />
  <title>MANGA ANCHA</title>
</head>

<body>

  <!-- CONTENT -->
  <main>
    <!-- ALERTS -->
    <div id="alert"></div>

    <section class="customer-area">
      <article>
        <h1>My account</h1>
        <p>Log in or create an account to manage your orders.</p>
        <button type="button" id="logoutButton">LOG OUT</button>
      </article>
    </section>

    <section class="card">
      <article class="top-card">
        <button type="button" id="button_login"><span>Login</span></button>
        <button type="button" id="button_create"><span>Create Account</span></button>
      </article>

      <article class="forms">
        <form class="form-login" action="index.php?entity=login&action=login" method="POST">
          <h2>Welcome back!</h2>

          <label for="login-email">Email</label>
          <input type="email" id="login-email" name="login-email" />

          <label for="login-password">Password</label>
          <input type="password" id="login-password" name="login-password" />

          <input type="submit" value="Login" id="loginButton" />
        </form>

        <form class="form-register" action="index.php?entity=register&action=register" method="POST">
          <h2>Start your journey</h2>

          <label for="register-name">Name</label>
          <input type="text" id="register-name" name="register-name" />

          <label for="register-email">Email</label>
          <input type="email" id="register-email" name="register-email" />

          <label for="register-password">Password</label>
          <input type="password" id="register-password" name="register-password" />

          <input type="submit" value="SignUp" id="registerButton" />
        </form>

        <img class="cover-image" src="IMG/imagen-login.png" alt="" />
      </article>

      <p>
        By using this software, you agree to our Terms of Service, Privacy
        Policy, and Cookie Policy.
      </p>
    </section>
  </main>

  <script src="JS/login.js"></script>
</body>

</html>