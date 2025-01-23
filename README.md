# SoundVibes

Este es un proyecto fullstack que utiliza Docker y Docker Compose para crear un entorno de desarrollo que incluye un backend en PHP con un CRUD y un frontend en React para un clon de Spotify con un selector de canciones segun el mood. Este README te guiará para ejecutar el proyecto en tu máquina local.

## Requisitos

- [Docker](https://www.docker.com/get-started) y [Docker Compose](https://docs.docker.com/compose/install/) instalados en tu máquina.

## Pasos para ejecutar el proyecto

1. **Clona el repositorio**:

   ```bash
   git clone https://github.com/lucasmaragu/SoundVibes
   cd Spotify-Login

2. **Construye y ejecuta los contenedores con Docker Compose:**

    ```bash
    docker-compose up --build

3. **Accede al proyecto**

   Para iniciar el frontend tienes que entrar dentro de la carpeta del front (Error pendiente de arreglo, en teoría tiene que levantar el front solo con docker-compose up --build)

       ```bash
       cd web_frontend

         ```bash
         npm run dev

   El frontend estará disponible en http://localhost:3000.
   El backend estará disponible en http://localhost:8000.

   Pero desde cualquiera se podra acceder tanto al frontend como al backend


   
 

5. **Usuarios**

   Para poder acceder, existen dos usuarios:

   **Admin**
   
   Username: admin
   Password: admin123



   **User**
   
   Username: user
   Password: user123
