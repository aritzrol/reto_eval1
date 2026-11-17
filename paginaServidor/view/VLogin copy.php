<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Login - Aplicación MVC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Iniciar Sesión</h2>

                        <form action="index.php?entity=login&action=login" method="POST">
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Nombre de usuario</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="contrasenia" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="contrasenia" name="contrasenia" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Entrar</button>
                            </div><!-- cierre del div container -->
</body>

</html>



<!-- <!doctype html>
<html lang="en">

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

</html> -->