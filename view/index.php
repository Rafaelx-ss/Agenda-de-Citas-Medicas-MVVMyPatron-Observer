<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Citas Médicas - Salud Integral</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .content {
            padding: 30px;
        }

        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: transform 0.2s, box-shadow 0.2s;
            margin: 5px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #6c757d;
        }

        .btn-danger {
            background: #dc3545;
        }

        .btn-success {
            background: #28a745;
        }

        .btn-warning {
            background: #ffc107;
            color: #333;
        }

        .form-container {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            display: none;
        }

        .form-container.active {
            display: block;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }

        .success-message {
            color: #28a745;
            font-size: 14px;
            margin-top: 5px;
            padding: 10px;
            background: #d4edda;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .appointments-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .appointments-table th,
        .appointments-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        .appointments-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }

        .appointments-table tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-programada {
            background: #d4edda;
            color: #155724;
        }

        .status-cancelada {
            background: #f8d7da;
            color: #721c24;
        }

        .status-completada {
            background: #d1ecf1;
            color: #0c5460;
        }

        .actions {
            display: flex;
            gap: 5px;
        }

        .btn-small {
            padding: 6px 12px;
            font-size: 14px;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .empty-state h3 {
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .appointments-table {
                font-size: 14px;
            }

            .appointments-table th,
            .appointments-table td {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🏥 Salud Integral</h1>
            <p>Agenda de Citas Médicas</p>
        </div>

        <div class="content">
            <div id="message-container"></div>

            <button class="btn" onclick="toggleForm()" id="toggleFormBtn">➕ Nueva Cita</button>
            <button class="btn btn-secondary" onclick="loadAppointments()">🔄 Actualizar</button>

            <div class="form-container" id="appointmentForm">
                <h2 id="formTitle">Nueva Cita</h2>
                <form id="appointmentFormElement" onsubmit="saveAppointment(event)">
                    <input type="hidden" id="appointmentId" name="id">

                    <div class="form-group">
                        <label for="patient_name">Nombre del Paciente *</label>
                        <input type="text" id="patient_name" name="patient_name" required>
                    </div>

                    <div class="form-group">
                        <label for="doctor">Médico *</label>
                        <select id="doctor" name="doctor" required>
                            <option value="">Seleccione un médico</option>
                            <option value="Dr. Pepe Pol - Cardiología">Dr. Pepe Pol - Cardiología</option>
                            <option value="Dr. Miguel Canto - Pediatría">Dr. Miguel Canto - Pediatría</option>
                            <option value="Dr. Ariel Mantinez - Dermatología">Dr. Ariel Mantinez - Dermatología</option>
                            <option value="Dr. Alexander Bolio - Ginecología">Dr. Alexander Bolio - Ginecología</option>
                            <option value="Dr. Gabriel Guerrero - Ortopedia">Dr. Gabriel Guerrero - Ortopedia</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="date">Fecha *</label>
                            <input type="date" id="date" name="date" required>
                        </div>

                        <div class="form-group">
                            <label for="time">Hora *</label>
                            <input type="time" id="time" name="time" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Estado</label>
                        <select id="status" name="status">
                            <option value="programada">Programada</option>
                            <option value="completada">Completada</option>
                            <option value="cancelada">Cancelada</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-success">💾 Guardar</button>
                        <button type="button" class="btn btn-secondary" onclick="cancelForm()">❌ Cancelar</button>
                    </div>
                </form>
            </div>

            <div id="appointments-container">
                <table class="appointments-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Paciente</th>
                            <th>Médico</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="appointments-tbody">
                        <?php if (empty($appointments)): ?>
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <h3>No hay citas programadas</h3>
                                        <p>Haz clic en "Nueva Cita" para agregar una</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($appointments as $appointment): ?>
                                <tr data-id="<?php echo htmlspecialchars($appointment['id']); ?>">
                                    <td><?php echo htmlspecialchars($appointment['id']); ?></td>
                                    <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
                                    <td><?php echo htmlspecialchars($appointment['doctor']); ?></td>
                                    <td><?php echo htmlspecialchars($appointment['date']); ?></td>
                                    <td><?php echo htmlspecialchars($appointment['time']); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo htmlspecialchars($appointment['status']); ?>">
                                            <?php echo ucfirst($appointment['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <button class="btn btn-small" onclick="editAppointment(<?php echo $appointment['id']; ?>)">✏️ Editar</button>
                                            <?php if ($appointment['status'] != 'cancelada'): ?>
                                                <button class="btn btn-small btn-warning" onclick="cancelAppointment(<?php echo $appointment['id']; ?>)">🚫 Cancelar</button>
                                            <?php endif; ?>
                                            <button class="btn btn-small btn-danger" onclick="deleteAppointment(<?php echo $appointment['id']; ?>)">🗑️ Eliminar</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        let editingId = null;

        function showMessage(message, type = 'success') {
            const container = document.getElementById('message-container');
            container.innerHTML = `<div class="${type === 'success' ? 'success-message' : 'error-message'}">${message}</div>`;
            setTimeout(() => {
                container.innerHTML = '';
            }, 5000);
        }

        function toggleForm() {
            const form = document.getElementById('appointmentForm');
            const btn = document.getElementById('toggleFormBtn');

            if (form.classList.contains('active')) {
                form.classList.remove('active');
                btn.textContent = '➕ Nueva Cita';
                cancelForm();
            } else {
                form.classList.add('active');
                btn.textContent = '❌ Cerrar Formulario';
            }
        }

        function cancelForm() {
            editingId = null;
            document.getElementById('appointmentFormElement').reset();
            document.getElementById('appointmentId').value = '';
            document.getElementById('formTitle').textContent = 'Nueva Cita';
            document.getElementById('date').value = '';
            document.getElementById('time').value = '';
        }

        function saveAppointment(event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const data = {
                action: editingId ? 'update' : 'create',
                id: editingId,
                patient_name: formData.get('patient_name'),
                doctor: formData.get('doctor'),
                date: formData.get('date'),
                time: formData.get('time'),
                status: formData.get('status')
            };

            fetch('index.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        showMessage(editingId ? 'Cita actualizada exitosamente' : 'Cita creada exitosamente');
                        cancelForm();
                        toggleForm();
                        loadAppointments();
                    } else {
                        const errors = result.errors ? result.errors.join('<br>') : 'Error al guardar la cita';
                        showMessage(errors, 'error');
                    }
                })
                .catch(error => {
                    showMessage('Error de conexión: ' + error.message, 'error');
                });
        }

        function editAppointment(id) {
            fetch('index.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'get',
                        id: id
                    })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success && result.data) {
                        const appointment = result.data;
                        editingId = appointment.id;
                        document.getElementById('appointmentId').value = appointment.id;
                        document.getElementById('patient_name').value = appointment.patient_name;
                        document.getElementById('doctor').value = appointment.doctor;
                        document.getElementById('date').value = appointment.date;
                        document.getElementById('time').value = appointment.time;
                        document.getElementById('status').value = appointment.status;
                        document.getElementById('formTitle').textContent = 'Editar Cita';

                        const form = document.getElementById('appointmentForm');
                        if (!form.classList.contains('active')) {
                            toggleForm();
                        }
                        form.scrollIntoView({
                            behavior: 'smooth'
                        });
                    } else {
                        showMessage('Error al cargar la cita', 'error');
                    }
                })
                .catch(error => {
                    showMessage('Error de conexión: ' + error.message, 'error');
                });
        }

        function cancelAppointment(id) {
            if (!confirm('¿Está seguro de cancelar esta cita?')) {
                return;
            }

            fetch('index.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'cancel',
                        id: id
                    })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        showMessage('Cita cancelada exitosamente');
                        loadAppointments();
                    } else {
                        const errors = result.errors ? result.errors.join('<br>') : 'Error al cancelar la cita';
                        showMessage(errors, 'error');
                    }
                })
                .catch(error => {
                    showMessage('Error de conexión: ' + error.message, 'error');
                });
        }

        function deleteAppointment(id) {
            if (!confirm('¿Está seguro de eliminar esta cita? Esta acción no se puede deshacer.')) {
                return;
            }

            fetch('index.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'delete',
                        id: id
                    })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        showMessage('Cita eliminada exitosamente');
                        loadAppointments();
                    } else {
                        const errors = result.errors ? result.errors.join('<br>') : 'Error al eliminar la cita';
                        showMessage(errors, 'error');
                    }
                })
                .catch(error => {
                    showMessage('Error de conexión: ' + error.message, 'error');
                });
        }

        function loadAppointments() {
            window.location.reload();
        }

        // Establecer fecha mínima como hoy
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('date');
            const today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('min', today);
        });
    </script>
</body>

</html>