# Etapa de construcción y desarrollo
FROM node:14

WORKDIR /app

# Copiar package.json y package-lock.json (si existe)
COPY package*.json ./

# Instalar dependencias
RUN npm install

# Instalar un servidor HTTP simple para producción
RUN npm install -g http-server

# Copiar el resto de los archivos del proyecto
COPY . .

# Exponer el puerto 5173 para desarrollo y 80 para producción
EXPOSE 5173 80

# El comando se proporcionará en el docker-compose.yml
CMD ["npm", "run", "dev", "--", "--host"]