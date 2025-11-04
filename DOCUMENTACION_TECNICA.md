# Documentación Técnica - Sistema de Agenda de Citas Médicas

## 📐 Arquitectura MVVM

### Descripción General

La arquitectura **MVVM (Model-View-ViewModel)** separa la lógica de negocio, la presentación y la interacción del usuario en capas independientes, facilitando el mantenimiento y la escalabilidad.

### Componentes

#### 1. **Model (Modelo) - Capa de Datos**

**Ubicación:** `model/AppointmentModel.php`

**Responsabilidades:**
- Persistencia de datos en formato JSON
- Operaciones CRUD (Create, Read, Update, Delete)
- Validación de duplicados
- Notificación de cambios mediante patrón Observer

**Características:**
- Extiende `Observable` para notificar cambios
- Almacenamiento en archivo JSON (`data/appointments.json`)
- Generación automática de IDs
- Método `checkDuplicate()` para prevenir citas duplicadas

**Ejemplo de uso:**
```php
$model = new AppointmentModel();
$model->create([
    'patient_name' => 'Juan Pérez',
    'doctor' => 'Dr. Juan Pérez - Cardiología',
    'date' => '2024-01-15',
    'time' => '10:00',
    'status' => 'programada'
]);
```

#### 2. **View (Vista) - Capa de Presentación**

**Ubicación:** `view/index.php`

**Responsabilidades:**
- Interfaz de usuario (HTML/CSS/JavaScript)
- Presentación de datos al usuario
- Captura de interacciones del usuario
- Actualización visual basada en notificaciones

**Características:**
- Interfaz responsive y moderna
- Formulario dinámico para crear/editar citas
- Tabla de visualización de citas
- Mensajes de éxito/error en tiempo real
- Validación del lado del cliente

#### 3. **ViewModel (Modelo de Vista) - Lógica de Presentación**

**Ubicación:** `viewmodel/AppointmentViewModel.php`

**Responsabilidades:**
- Intermediario entre Model y View
- Validación de datos antes de enviarlos al modelo
- Transformación de datos para la vista
- Implementa Observer para recibir actualizaciones del modelo

**Características:**
- Validación de campos requeridos
- Validación de formato de fecha y hora
- Prevención de citas duplicadas
- Notificación a observadores de la vista

**Ejemplo de uso:**
```php
$viewModel = new AppointmentViewModel($model);
$result = $viewModel->createAppointment($data);
if ($result['success']) {
    // Cita creada exitosamente
} else {
    // Mostrar errores: $result['errors']
}
```

#### 4. **Controller (Controlador) - Coordinador**

**Ubicación:** `controller/AppointmentController.php`

**Responsabilidades:**
- Coordinar operaciones entre capas
- Manejar peticiones HTTP
- Delegar operaciones al ViewModel
- Retornar respuestas apropiadas

## 👁️ Patrón Observer - Implementación Detallada

### ¿Qué es el Patrón Observer?

El patrón Observer es un patrón de diseño de comportamiento que define una dependencia de uno-a-muchos entre objetos, de manera que cuando un objeto cambia su estado, todos sus dependientes son notificados y actualizados automáticamente.

### ¿Por qué se utiliza?

1. **Desacoplamiento**: El modelo no conoce directamente las vistas
2. **Escalabilidad**: Fácil agregar nuevos observadores sin modificar el código existente
3. **Tiempo Real**: Actualizaciones automáticas cuando cambian los datos
4. **Mantenibilidad**: Cambios en el modelo no requieren modificar las vistas

### Implementación en el Sistema

#### Estructura del Patrón

```
┌──────────────────┐
│ SubjectInterface │  (Interfaz)
└────────┬─────────┘
         │
         │ implements
         ▼
┌──────────────────┐
│   Observable     │  (Clase base)
└────────┬─────────┘
         │
         │ extends
         ▼
┌──────────────────┐      ┌──────────────────┐
│ AppointmentModel │──────│ ObserverInterface │
│   (Subject)      │      │   (Observer)     │
└──────────────────┘      └────────┬─────────┘
         │                          │
         │ notifies                 │ implements
         ▼                          ▼
┌──────────────────┐      ┌──────────────────┐
│ AppointmentViewModel │    │  ViewObserver    │
│   (Observer)      │      │  (Observer)     │
└───────────────────┘      └─────────────────┘
```

#### Flujo de Notificaciones

1. **Model → ViewModel:**
   ```php
   // En AppointmentModel
   $this->notify(['action' => 'create', 'data' => $appointment]);
   
   // ViewModel recibe la notificación
   public function update($data) {
       // Procesar notificación
       foreach ($this->viewObservers as $observer) {
           $observer->update($data);
       }
   }
   ```

2. **ViewModel → View:**
   ```php
   // ViewModel notifica a observadores de la vista
   $viewObserver = new ViewObserver(function($data) {
       // Actualizar interfaz de usuario
       updateUI($data);
   });
   $viewModel->attachViewObserver($viewObserver);
   ```

### Ventajas en este Contexto

1. **Actualización Automática**: Cuando se crea, edita o elimina una cita, todas las vistas registradas se actualizan automáticamente
2. **Extensibilidad**: Fácil agregar nuevas funcionalidades que respondan a cambios (ej: notificaciones por email, logs, etc.)
3. **Separación de Responsabilidades**: Cada componente tiene una responsabilidad clara

## 🔄 Flujo de Datos Completo

### Crear una Cita

```
1. Usuario → View (index.php)
   └─> Usuario completa formulario y hace clic en "Guardar"

2. View → Controller (index.php - AJAX)
   └─> POST request con datos de la cita

3. Controller → ViewModel
   └─> $controller->create($data)
       └─> $viewModel->createAppointment($data)

4. ViewModel → Model
   └─> Valida datos
       └─> $model->create($data)

5. Model → Persistencia
   └─> Guarda en JSON
       └─> notify(['action' => 'create', 'data' => $appointment])

6. Model → ViewModel (Observer)
   └─> ViewModel::update($data)
       └─> Notifica a observadores de la vista

7. ViewModel → View (Observer)
   └─> ViewObserver::update($data)
       └─> Actualiza interfaz

8. Controller → View
   └─> Retorna JSON con resultado
       └─> JavaScript actualiza la tabla
```

## 📊 Diagrama de Secuencia

### Crear Cita

```
Usuario    View      Controller    ViewModel    Model
  │         │            │             │          │
  │─click──>│            │             │          │
  │         │─POST──────>│             │          │
  │         │            │─create()───>│          │
  │         │            │             │─validate│
  │         │            │             │          │
  │         │            │             │─create()─>│
  │         │            │             │          │─save()
  │         │            │             │          │─notify()
  │         │            │             │<─update()│
  │         │            │<─result─────│          │
  │         │<─JSON──────│             │          │
  │<─update─│            │             │          │
```

### Actualización mediante Observer

```
Model      ViewModel    ViewObserver    View
  │            │             │           │
  │─notify()──>│             │           │
  │            │─update()───>│           │
  │            │             │─update()─>│
  │            │             │           │─updateUI()
```

## 🗂️ Estructura de Datos

### Formato JSON de Cita

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

### Estados de Cita

- **programada**: Cita agendada y pendiente
- **completada**: Cita realizada
- **cancelada**: Cita cancelada

## ✅ Validaciones Implementadas

### Validaciones del ViewModel

1. **Campos Requeridos:**
   - Nombre del paciente
   - Médico
   - Fecha
   - Hora

2. **Formato de Fecha:**
   - Validación con `strtotime()`
   - Solo fechas futuras (validación en JavaScript)

3. **Formato de Hora:**
   - Expresión regular: `/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/`
   - Formato 24 horas (HH:MM)

4. **Duplicados:**
   - Mismo médico
   - Misma fecha
   - Misma hora
   - Estado no cancelado

## 🔧 Extensiones Futuras

### Posibles Mejoras

1. **Base de Datos:**
   - Migrar de JSON a MySQL/PostgreSQL
   - Agregar migraciones de base de datos

2. **Autenticación:**
   - Sistema de usuarios
   - Roles (admin, médico, recepcionista)

3. **Notificaciones:**
   - Email al paciente
   - SMS de recordatorio
   - Notificaciones push

4. **Reportes:**
   - Estadísticas de citas
   - Historial de pacientes
   - Calendario de médicos

5. **API REST:**
   - Endpoints estructurados
   - Documentación con Swagger
   - Autenticación JWT

## 📝 Conclusión

Este sistema demuestra una implementación clara y funcional de la arquitectura MVVM junto con el patrón Observer en PHP puro. La separación de responsabilidades facilita el mantenimiento, la escalabilidad y la extensibilidad del código.

El patrón Observer permite que el sistema sea reactivo y actualice automáticamente las vistas cuando hay cambios en los datos, proporcionando una experiencia de usuario fluida y en tiempo real.

