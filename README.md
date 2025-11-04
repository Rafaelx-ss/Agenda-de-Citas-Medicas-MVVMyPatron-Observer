# Sistema de Agenda de Citas Médicas - Salud Integral

Sistema desarrollado en PHP puro implementando la arquitectura **MVVM (Model-View-ViewModel)** y el patrón **Observer** para una gestión eficiente de citas médicas.

## 📋 Descripción

Aplicación web para gestionar citas médicas que permite crear, editar, cancelar y visualizar citas con actualizaciones en tiempo real mediante el patrón Observer.

## 🏗️ Arquitectura

### Estructura de Carpetas

```
tareadedk/
├── model/              # Capa de datos (Modelos)
│   └── AppointmentModel.php
├── view/               # Capa de presentación (Vistas)
│   ├── index.php
│   └── ViewObserver.php
├── viewmodel/          # Lógica de presentación (ViewModels)
│   └── AppointmentViewModel.php
├── controller/         # Controladores
│   └── AppointmentController.php
├── observer/           # Patrón Observer
│   ├── ObserverInterface.php
│   ├── SubjectInterface.php
│   └── Observable.php
├── data/               # Almacenamiento JSON
│   └── appointments.json
├── index.php           # Punto de entrada
├── composer.json
└── README.md
```

## 🔄 Arquitectura MVVM

### **Model (Modelo)**
- `AppointmentModel`: Maneja la persistencia de datos en formato JSON
- Extiende `Observable` para notificar cambios a los observadores
- Operaciones CRUD: create, read, update, delete

### **View (Vista)**
- `index.php`: Interfaz HTML con JavaScript para interactividad
- Presenta los datos al usuario de forma amigable
- Se actualiza automáticamente cuando recibe notificaciones

### **ViewModel (Modelo de Vista)**
- `AppointmentViewModel`: Lógica de presentación y validación
- Actúa como intermediario entre Model y View
- Implementa `ObserverInterface` para recibir actualizaciones del modelo
- Valida datos antes de enviarlos al modelo

### **Controller (Controlador)**
- `AppointmentController`: Coordina las operaciones
- Maneja las peticiones HTTP y delega al ViewModel

## 👁️ Patrón Observer

### Implementación

El patrón Observer se implementa en tres niveles:

1. **Model → ViewModel**: 
   - `AppointmentModel` (Observable) notifica cambios a `AppointmentViewModel` (Observer)
   - Cuando hay cambios en los datos (create, update, delete), se notifica automáticamente

2. **ViewModel → View**:
   - `AppointmentViewModel` puede notificar a observadores de la vista
   - Permite actualizaciones en tiempo real en la interfaz

3. **Interfaces**:
   - `ObserverInterface`: Define el método `update($data)`
   - `SubjectInterface`: Define métodos para gestionar observadores
   - `Observable`: Implementación base del patrón

### Justificación del Patrón Observer

- **Desacoplamiento**: El modelo no conoce directamente las vistas
- **Escalabilidad**: Fácil agregar nuevos observadores sin modificar el modelo
- **Tiempo Real**: Las vistas se actualizan automáticamente cuando cambian los datos
- **Mantenibilidad**: Cambios en el modelo no requieren modificar las vistas

## 🚀 Instalación

### Requisitos
- PHP 7.4 o superior
- Servidor web (Apache/Nginx) o servidor PHP integrado
- Composer (opcional, para autoloading)

### Pasos de Instalación

1. **Clonar o descargar el proyecto**

2. **Instalar dependencias (opcional)**
   ```bash
   composer install
   ```

3. **Configurar permisos**
   ```bash
   chmod 755 data/
   chmod 666 data/appointments.json (se creará automáticamente)
   ```

4. **Iniciar servidor PHP integrado**
   ```bash
   php -S localhost:8000
   ```

5. **Acceder a la aplicación**
   ```
   http://localhost:8000
   ```

## 📝 Funcionalidades

### Operaciones CRUD

- ✅ **Listar citas**: Visualización de todas las citas programadas
- ✅ **Crear cita**: Agregar nuevas citas médicas
- ✅ **Editar cita**: Modificar información de citas existentes
- ✅ **Cancelar cita**: Cambiar estado a "cancelada"
- ✅ **Eliminar cita**: Eliminar permanentemente una cita

### Validaciones

- ✅ Validación de campos requeridos
- ✅ Validación de formato de fecha y hora
- ✅ Prevención de citas duplicadas (mismo médico, fecha y hora)
- ✅ Validación de fecha mínima (no permite fechas pasadas)

### Campos de Cita

- **ID**: Identificador único (generado automáticamente)
- **Nombre del Paciente**: Nombre completo del paciente
- **Médico**: Médico asignado (con especialidad)
- **Fecha**: Fecha de la cita
- **Hora**: Hora de la cita
- **Estado**: programada, completada, cancelada

## 🔧 Tecnologías Utilizadas

- **PHP 7.4+**: Lenguaje backend
- **HTML5/CSS3**: Interfaz de usuario
- **JavaScript (Vanilla)**: Interactividad del cliente
- **JSON**: Almacenamiento de datos
- **Composer**: Gestión de dependencias

## 📊 Diagrama de Clases

```
┌─────────────────────┐
│ ObserverInterface   │
└─────────────────────┘
          ▲
          │ implements
          │
┌─────────┴─────────┐
│  AppointmentModel │      ┌──────────────────┐
│  (Observable)     │──────│ SubjectInterface │
└───────────────────┘      └──────────────────┘
          │
          │ notifies
          ▼
┌─────────────────────┐
│ AppointmentViewModel │
│  (Observer)         │
└─────────────────────┘
          │
          │ uses
          ▼
┌─────────────────────┐
│ AppointmentController│
└─────────────────────┘
          │
          │ renders
          ▼
┌─────────────────────┐
│   View (index.php)  │
└─────────────────────┘
```

## 🔄 Flujo de Datos

1. **Usuario interactúa** con la vista (View)
2. **Vista envía petición** al controlador (Controller)
3. **Controlador delega** al ViewModel
4. **ViewModel valida** y envía al Model
5. **Model persiste** datos y **notifica** cambios (Observer)
6. **ViewModel recibe** notificación y actualiza la vista
7. **Vista se actualiza** automáticamente

## 📸 Capturas de Funcionamiento

La aplicación incluye:
- Interfaz moderna y responsive
- Formulario de creación/edición de citas
- Tabla de visualización de citas
- Badges de estado (programada, cancelada, completada)
- Mensajes de éxito/error en tiempo real

## 🧪 Pruebas

Para probar la aplicación:

1. Crear una nueva cita
2. Intentar crear una cita duplicada (mismo médico, fecha y hora) - debe mostrar error
3. Editar una cita existente
4. Cancelar una cita
5. Eliminar una cita

## 📚 Documentación Técnica

### Modelo de Datos

```json
{
  "id": 1,
  "patient_name": "Juan Pérez",
  "doctor": "Dr. Juan Pérez - Cardiología",
  "date": "2024-01-15",
  "time": "10:00",
  "status": "programada"
}
```

### Endpoints API

- `POST /index.php` con `action: 'create'` - Crear cita
- `POST /index.php` con `action: 'update'` - Actualizar cita
- `POST /index.php` con `action: 'cancel'` - Cancelar cita
- `POST /index.php` con `action: 'delete'` - Eliminar cita
- `POST /index.php` con `action: 'get'` - Obtener cita por ID

## 👨‍💻 Autor

Desarrollado para Salud Integral - Sistema de Gestión de Citas Médicas

## 📄 Licencia

Este proyecto es de uso educativo y demostrativo.

