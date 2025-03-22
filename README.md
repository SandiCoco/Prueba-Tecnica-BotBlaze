# Proyecto de Gestión de Productos

## Tecnologías Utilizadas

- **Laravel**: Framework PHP para el backend.
- **Laravel Sanctum**
- **MySQL**: Base de datos relacional.
- **Bootstrap**: Diseño y estilos del frontend.
- **Axios**: Para realizar peticiones HTTP asíncronas.
- **JavaScript**: Para la interacción en el frontend.

## Requisitos
- PHP >= 8.1
- Composer
- MySQL
- Node.js 

##  Instalación

1. Clonar el repositorio:

```bash
    git clone https://github.com/SandiCoco/Prueba-Tecnica-BotBlaze.git
    cd manejo_productos
```

2. Instalar las dependencias de PHP y Node.js:

```bash
    composer install
    npm install && npm run build
```

3. Configurar el archivo `.env`:

```bash
    cp .env.example .env
```

Configurar las credenciales de la base de datos en el archivo `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

4. Generar la clave de la aplicación y migrar la base de datos:

```bash
    php artisan key:generate
    `php artisan migrate:fresh --seed
```

5. **Configurar Laravel Sanctum:**

   - Instalar Sanctum:

   ```bash
    php artisan install:api
   ```

  

5. Ejecutar el servidor de desarrollo:

```bash
    php artisan serve
```

La aplicación estará disponible en: [http://localhost:8000](http://localhost:8000)





