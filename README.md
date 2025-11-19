# Magento-Practice
Repository to keep up with the changes made to the initial docker repository as to practice Magento 2.

## Configuración de Docker Compose para Magento

Esta configuración de Docker Compose define un entorno de desarrollo para Magento, utilizando varios servicios interconectados para proporcionar una plataforma completa.

### Servicios

* **nginx:**
    * Servidor web Nginx que maneja las solicitudes HTTP entrantes.
    * Depende de que el servicio `php-fpm` esté iniciado.
* **php-fpm:**
    * Procesa las solicitudes PHP utilizando PHP-FPM.
    * Conectado a la red `magento`.
    * Tiene acceso al código fuente de Magento en el volumen `magento-app`.
    * Depende de que los servicios `db` y `redis` estén saludables.
* **php-cli:**
    * Proporciona una interfaz de línea de comandos PHP para ejecutar scripts y tareas de mantenimiento.
    * Conectado a la red `magento`.
    * Tiene acceso al código fuente de Magento en el volumen `magento-app`.
    * Depende de que el servicio `db` esté saludable.
* **db:**
    * Base de datos MariaDB para almacenar los datos de Magento.
    * Configuraciones de memoria y verificación de estado para garantizar la disponibilidad.
    * Credenciales de acceso definidas a través de variables de entorno.
    * Expone el puerto 3306 para acceso externo.
    * Almacena los datos en el volumen `magento-db`.
    * Conectado a la red `magento` con el alias `db.magento2.docker`.
* **redis:**
    * Servidor Redis para almacenamiento en caché y sesiones.
    * Configuraciones de verificación de estado para garantizar la disponibilidad.
    * Conectado a la red `magento` con el alias `redis.magento2.docker`.
* **opensearch:**
    * Motor de búsqueda OpenSearch para Magento.
    * Configuración para modo de nodo único.
    * Contraseña de administrador inicial definida.
    * Ajustes de memoria JVM y bloqueo de memoria para mejorar el rendimiento.
    * Límites de archivos abiertos aumentados para manejar cargas de trabajo pesadas.
    * Conectado a la red `magento`.

### Volúmenes

* **magento-db:** Almacena los datos de la base de datos MariaDB.
* **magento-app:** Contiene el código fuente de Magento y es compartido entre los servicios `php-fpm` y `php-cli`.

### Redes

* **magento:** Red interna utilizada para la comunicación entre los servicios.

### Resumen

Esta configuración proporciona un entorno de desarrollo de Magento completo y aislado. Los servicios se inician en un orden específico para garantizar que las dependencias estén disponibles antes de que se inicien los servicios que las requieren. Los volúmenes persisten los datos entre reinicios de los contenedores, y la red interna permite la comunicación fluida entre los servicios.

### Notas Adicionales

* Asegúrate de tener Docker Compose instalado en tu sistema antes de intentar ejecutar esta configuración.
* Puedes personalizar la configuración ajustando las versiones de las imágenes, las variables de entorno y otros parámetros según tus necesidades.
* Para iniciar el entorno, ejecuta el comando `docker-compose up -d` en el directorio que contiene este archivo `docker-compose.yml`.



