# Guía de Instalación - Sistema de Agenda de Citas Médicas

## Requisitos Previos

### Software Necesario

1. **PHP 7.4 o superior**
   - Verificar versión: `php -v`
   - Descargar desde: https://www.php.net/downloads.php

2. **Servidor Web (opcional)**
   - Apache con mod_rewrite
   - Nginx
   - O usar el servidor PHP integrado (recomendado para desarrollo)

3. **Composer (opcional pero recomendado)**
   - Verificar instalación: `composer --version`
   - Descargar desde: https://getcomposer.org/download/

## Instalación Paso a Paso

### Opción 1: Instalación Rápida (Servidor PHP Integrado)

1. **Abrir terminal en la carpeta del proyecto**
   ```bash
   cd C:\Users\Samuel Huicab\Desktop\tareadedk
   ```

2. **Iniciar servidor PHP**
   ```bash
   php -S localhost:8000
   ```

3. **Abrir navegador**
   ```
   http://localhost:8000
   ```

### Opción 2: Instalación con Apache/Nginx

1. **Configurar Virtual Host (Apache)**
   
   Agregar al archivo `httpd.conf` o `httpd-vhosts.conf`:
   ```apache
   <VirtualHost *:80>
       ServerName salud-integral.local
       DocumentRoot "C:/Users/Samuel Huicab/Desktop/tareadedk"
       
       <Directory "C:/Users/Samuel Huicab/Desktop/tareadedk">
           Options Indexes FollowSymLinks
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```

2. **Configurar hosts (Windows)**
   
   Editar `C:\Windows\System32\drivers\etc\hosts`:
   ```
   127.0.0.1 salud-integral.local
   ```

3. **Reiniciar Apache y acceder**
   ```
   http://salud-integral.local
   ```

### Opción 3: Instalación con XAMPP/WAMP

1. **Copiar proyecto a carpeta htdocs/www**
   ```
   C:\xampp\htdocs\tareadedk
   ```

2. **Iniciar Apache desde panel de control**

3. **Acceder desde navegador**
   ```
   http://localhost/tareadedk
   ```

## Configuración de Permisos

### Linux/Mac
```bash
chmod 755 data/
chmod 666 data/appointments.json  # Se crea automáticamente
```

### Windows
- Los permisos se configuran automáticamente
- Asegurar que la carpeta `data/` tenga permisos de escritura

## Instalación de Dependencias (Opcional)

Si deseas usar el autoloader de Composer:

```bash
composer install
```

Nota: El proyecto ya incluye un autoloader personalizado (`autoload.php`), por lo que Composer es opcional.

## Verificación de Instalación

### 1. Verificar que PHP funciona
```bash
php -v
```

Debería mostrar algo como:
```
PHP 7.4.x (cli) ...
```

### 2. Verificar estructura de carpetas
```
tareadedk/
├── model/
├── view/
├── viewmodel/
├── controller/
├── observer/
├── data/
├── index.php
└── autoload.php
```

### 3. Probar la aplicación

1. Abrir `http://localhost:8000` en el navegador
2. Deberías ver la interfaz de "Agenda de Citas Médicas"
3. Intentar crear una nueva cita

## Solución de Problemas

### Error: "Cannot write to data/appointments.json"

**Solución:**
- Verificar permisos de la carpeta `data/`
- Asegurar que la carpeta existe
- En Windows: Dar permisos de escritura a la carpeta

### Error: "Class not found"

**Solución:**
- Verificar que `autoload.php` está siendo incluido
- Verificar que todas las carpetas existen
- Revisar rutas en los archivos PHP

### Error: "500 Internal Server Error"

**Solución:**
- Revisar logs de PHP (`php.ini` - `error_log`)
- Verificar permisos de archivos
- Verificar sintaxis PHP

### Error: "Undefined index"

**Solución:**
- Verificar que los datos JSON están bien formateados
- Eliminar `data/appointments.json` y dejar que se recree

## Pruebas de Funcionalidad

### Test 1: Crear Cita
1. Click en "Nueva Cita"
2. Llenar formulario
3. Click en "Guardar"
4. Verificar que aparece en la tabla

### Test 2: Validación de Duplicados
1. Crear una cita para un médico
2. Intentar crear otra cita con el mismo médico, fecha y hora
3. Debería mostrar error de duplicado

### Test 3: Editar Cita
1. Click en "Editar" de una cita
2. Modificar datos
3. Guardar
4. Verificar cambios en la tabla

### Test 4: Cancelar Cita
1. Click en "Cancelar" de una cita
2. Confirmar
3. Verificar que el estado cambia a "cancelada"

### Test 5: Eliminar Cita
1. Click en "Eliminar" de una cita
2. Confirmar
3. Verificar que desaparece de la tabla

## Configuración Avanzada

### Cambiar Puerto del Servidor
```bash
php -S localhost:8080
```

### Configurar Base de Datos (Futuro)
Editar `model/AppointmentModel.php` para usar MySQL/PostgreSQL en lugar de JSON.

### Configurar Timezone
Agregar en `index.php`:
```php
date_default_timezone_set('America/Mexico_City');
```

## Soporte

Para problemas o preguntas:
1. Revisar `DOCUMENTACION_TECNICA.md`
2. Revisar `README.md`
3. Verificar logs de PHP
4. Revisar código fuente en los archivos correspondientes

