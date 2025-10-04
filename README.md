# Aplicación Web con PHP y MySQL usando Docker Swarm

Esta es una aplicación web simple desarrollada en PHP que muestra una lista de personas almacenadas en una base de datos MySQL. La aplicación se despliega utilizando Docker Swarm para orquestar los contenedores.

## Descripción del Proyecto

- **Backend**: Base de datos MySQL con una tabla de personas (id, nombre, edad).
- **Frontend**: Página web en PHP que consulta la base de datos y muestra los datos en una tabla.
- **Orquestación**: Docker Swarm para manejar los servicios (MySQL y la aplicación web).

## Requisitos

- Docker instalado y en funcionamiento.
- Docker Swarm inicializado (se explica abajo).

## Instrucciones de Despliegue

### 1. Inicializar Docker Swarm

Si no tienes un clúster Swarm iniciado, ejecuta:

```bash
docker swarm init
```

### 2. Construir la Imagen Docker (Opcional)

El archivo `docker-stack.yml` referencia la imagen `crisdesco/miwebapp:1.0`. Si deseas construir tu propia imagen localmente, ejecuta:

```bash
docker build -t tu-imagen-web:latest .
```

Luego, edita `docker-stack.yml` para usar `tu-imagen-web:latest` en lugar de `crisdesco/miwebapp:1.0`.

Si prefieres usar la imagen existente, asegúrate de que esté disponible (puedes hacer `docker pull crisdesco/miwebapp:1.0`).

### 3. Crear los Secrets

La configuración utiliza secretos externos para las contraseñas de MySQL. Crea los archivos de secretos:

```bash
echo "tu_contraseña_root" > mysql_root_password.txt
echo "tu_contraseña_usuario" > mysql_user_password.txt
```

Luego, crea los secretos en Docker Swarm:

```bash
docker secret create mysql_root_password mysql_root_password.txt
docker secret create mysql_user_password mysql_user_password.txt
```

### 4. Desplegar el Stack

Despliega la aplicación usando el archivo de composición de Swarm:

```bash
docker stack deploy -c docker-stack.yml mi_webapp
```

### 5. Verificar el Despliegue

Verifica que los servicios estén corriendo:

```bash
docker stack services mi_webapp
```

### 6. Acceder a la Aplicación

La aplicación estará disponible en `http://172.25.154.94:8080/`.

## Estructura de Archivos

- `index.php`: Página principal de la aplicación web.
- `Dockerfile`: Definición de la imagen Docker para la aplicación web.
- `docker-stack.yml`: Configuración del stack de Docker Swarm.
- `db_init.sql`: Script de inicialización de la base de datos.

## Limpieza

Para eliminar el stack:

```bash
docker stack rm mi_webapp
```

Para remover los secretos:

```bash
docker secret rm mysql_root_password mysql_user_password
```

## Notas

- Asegúrate de que el puerto 8080 esté disponible en tu host.
- Los datos de la base de datos se inicializan automáticamente desde `db_init.sql`.
- La aplicación muestra una tabla con personas de ejemplo.