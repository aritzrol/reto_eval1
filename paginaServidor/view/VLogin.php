<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MANGA ANCHA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Fondo de toda la página */
        .login-body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e1e2f, #3a2d5c);
        }

        /* La tarjeta */
        .login-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        /* Columna de la imagen */
        .login-imagen {
            min-height: 220px;
        }

        .login-imagen img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Columna del formulario */
        .login-formulario {
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-formulario h2 {
            font-weight: 700;
        }

        .login-subtitulo {
            color: #6c757d;
        }

        /* Campos */
        .login-formulario .form-control {
            padding: 0.7rem 1rem;
            border-radius: 10px;
        }

        .login-formulario .form-control:focus {
            border-color: #6f42c1;
            box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
        }

        /* Botón */
        .btn-login {
            background-color: #6f42c1;
            color: #fff;
            padding: 0.7rem;
            border-radius: 10px;
            font-weight: 600;
            transition: background-color 0.2s, transform 0.2s;
        }

        .btn-login:hover {
            background-color: #59359a;
            color: #fff;
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="login-body">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card login-card shadow-lg">
                    <div class="row g-0">

                        <!-- COLUMNA DE LA IMAGEN -->
                        <div class="col-md-6 login-imagen">
                            
                            <img src="IMG/imagen-login.png" alt="Manga Ancha">
                        </div>

                        <!-- COLUMNA DEL FORMULARIO -->
                        <div class="col-md-6 login-formulario">
                            <h2 class="text-center mb-1">Iniciar Sesión</h2>
                            <p class="text-center login-subtitulo mb-4">Bienvenido a Manga Ancha</p>

                            <form action="index.php?entity=login&action=login" method="POST">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-login">Entrar</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>