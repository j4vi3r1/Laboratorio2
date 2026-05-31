# Proyecto: Aplicación Web con CRUD y Docker

Este repositorio contiene el despliegue de una aplicación web basada en PHP con persistencia de datos en MySQL, utilizando Docker y Docker Compose para garantizar un entorno de desarrollo consistente y reproducible.

## Estructura del Proyecto

- app/: Directorio que contiene el código fuente de la aplicación PHP.
- docker-compose.yml: Orquestador que define y configura los servicios de la aplicación y la base de datos.
- Dockerfile: Definición de la imagen del contenedor del servidor web.
- README.md: Documentación del proyecto.

## Requisitos Previos

- Docker (versión 20.10 o superior recomendada).
- Docker Compose.
- Sistema operativo con soporte para contenedores (Linux, Windows con WSL2 o macOS).

## Instalación y Ejecución

Para desplegar la aplicación en tu entorno local, sigue estos pasos:

1. Clonar el repositorio:
git clone https://github.com/j4vi3r1/Laboratorio2.git
cd Laboratorio2

2. Desplegar los servicios:
Ejecuta el siguiente comando para construir y levantar los contenedores en segundo plano:
docker compose up -d --build

3. Acceso a la aplicación:
Una vez iniciados los servicios, la aplicación estará disponible en tu navegador a través de la siguiente dirección:
http://localhost:8080

(Nota: Se asume que el puerto 8080 está configurado en tu archivo docker-compose.yml como puerto de escucha).

## Gestión de Datos

La persistencia de la información está configurada mediante volúmenes de Docker. Esto garantiza que los datos almacenados en MySQL no se eliminen al detener o reiniciar los contenedores.

## Enlaces del Proyecto

- Repositorio GitHub: https://github.com/j4vi3r1/Laboratorio2
- Documento LaTeX (Informe): https://www.overleaf.com/read/mvqvcbfkzfdf#632910
