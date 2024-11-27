# Mi Proyecto con Docker y Docker Compose

Este es un proyecto que utiliza Docker y Docker Compose para crear un entorno de desarrollo que incluye un backend en PHP con un CRUD y un frontend en React para un clon de Spotify con un selector de canciones segun el mood. Este README te guiará para ejecutar el proyecto en tu máquina local.

## Requisitos

- [Docker](https://www.docker.com/get-started) y [Docker Compose](https://docs.docker.com/compose/install/) instalados en tu máquina.

## Pasos para ejecutar el proyecto

1. **Clona el repositorio**:

   ```bash
   git clone https://github.com/usuario/mi-proyecto.git
   cd mi-proyecto

2. **Construye y ejecuta los contenedores con Docker Compose:**

    ```bash
    docker-compose up --build

3. **Accede al proyecto**

   El frontend estará disponible en http://localhost:3000.
   El backend estará disponible en http://localhost:8000.

   Pero desde cualquiera se podra acceder tanto al frontend como al backend

4. **Usuarios**

   Para poder acceder, existen dos usuarios:

   **Admin**
   Username: admin
   Password: admin123

   **User**
   Username: user
   Password: user123