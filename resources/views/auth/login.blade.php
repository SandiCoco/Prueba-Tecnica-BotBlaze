<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>

    <style>
        /* Reset de márgenes y padding */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            height: 100%;
            background-color: #f4f4f9;
        }

        /* Centrar el contenido en la página */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

        /* Estilo de la tarjeta */
        .card {
            background-color: white;
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            text-align: center;
            margin-bottom: 20px;
        }

        h3 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .form-label {
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
        }

        input[type="email"], input[type="password"] {
            width: 93.5%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Iniciar sesión</h3>
            </div>

            <div class="card-body">
                <!-- Formulario de inicio de sesión -->
                <form action="/login" method="POST" id="loginForm">
                    @csrf

                    <!-- Email Input -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" name="email" id="email" required>
                    </div>

                    <!-- Password Input -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="password" required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit">Iniciar sesión</button>
                </form>

                <!-- Error message -->
                @if(session('error'))
                    <div class="alert-danger">{{ session('error') }}</div>
                @endif
            </div>
        </div>
    </div>

</body>
</html>
