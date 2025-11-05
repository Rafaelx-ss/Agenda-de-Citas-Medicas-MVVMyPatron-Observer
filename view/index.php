<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Citas Médicas - Salud Integral</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0a7c8e;
            --primary-dark: #075a68;
            --primary-light: #0fb3cc;
            --secondary: #f0f7f9;
            --accent: #ff6b6b;
            --success: #51cf66;
            --warning: #ffd43b;
            --danger: #ff6b6b;
            --text-primary: #1a1a1a;
            --text-secondary: #6b7280;
            --border: #e5e7eb;
            --bg: #f9fafb;
            --white: #ffffff;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg);
            color: var(--text-primary);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .app-wrapper {
            min-height: 100vh;
            background: linear-gradient(135deg, #e0f2f5 0%, #d1e8eb 50%, #f0f7f9 100%);
            padding: 2rem 1rem;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            background: var(--white);
            border-radius: 16px;
            padding: 2.5rem 3rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            border-left: 4px solid var(--primary);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .header-content h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .header-content p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            font-weight: 400;
        }

        .header-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            white-space: nowrap;
            font-family: inherit;
        }

        .btn:active {
            transform: scale(0.98);
        }

        .btn-primary {
            background: var(--primary);
            color: var(--white);
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            box-shadow: var(--shadow);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: var(--white);
            color: var(--text-primary);
            border: 1.5px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--bg);
            border-color: var(--primary-light);
            color: var(--primary);
        }

        .btn-danger {
            background: var(--danger);
            color: var(--white);
        }

        .btn-danger:hover {
            background: #ff5252;
            box-shadow: var(--shadow);
        }

        .btn-success {
            background: var(--success);
            color: var(--white);
        }

        .btn-success:hover {
            background: #40c057;
            box-shadow: var(--shadow);
        }

        .btn-warning {
            background: var(--warning);
            color: var(--text-primary);
        }

        .btn-warning:hover {
            background: #ffca2c;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.813rem;
        }

        .btn-icon {
            margin-right: 0.5rem;
        }

        .content {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .message-container {
            margin-bottom: 1.5rem;
        }

        .message {
            padding: 1rem 1.25rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            animation: slideIn 0.3s ease;
            border-left: 3px solid;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message-success {
            background: #d1fae5;
            color: #065f46;
            border-color: var(--success);
        }

        .message-error {
            background: #fee2e2;
            color: #991b1b;
            border-color: var(--danger);
        }

        .form-container {
            background: var(--white);
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            display: none;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-container.active {
            display: block;
        }

        .form-header {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid var(--border);
        }

        .form-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .form-group input,
        .form-group select {
            padding: 0.875rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-size: 0.938rem;
            font-family: inherit;
            transition: all 0.2s ease;
            background: var(--white);
            color: var(--text-primary);
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(10, 124, 142, 0.1);
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 2px solid var(--border);
        }

        .appointments-section {
            background: var(--white);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--shadow);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border);
        }

        .section-header h2 {
            font-size: 1.375rem;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .appointments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .appointment-card {
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .appointment-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .appointment-card:hover {
            border-color: var(--primary-light);
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        .appointment-card:hover::before {
            transform: scaleY(1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1.25rem;
        }

        .card-id {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .card-status {
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-programada {
            background: #d1fae5;
            color: #065f46;
        }

        .status-cancelada {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-completada {
            background: #dbeafe;
            color: #1e40af;
        }

        .card-body {
            margin-bottom: 1.25rem;
        }

        .card-field {
            margin-bottom: 0.875rem;
        }

        .card-field:last-child {
            margin-bottom: 0;
        }

        .card-label {
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }

        .card-value {
            font-size: 0.938rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        .card-value.patient-name {
            font-size: 1.063rem;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .card-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-secondary);
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        .empty-state h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .empty-state p {
            font-size: 0.938rem;
        }

        .table-view {
            display: none;
        }

        .table-view.active {
            display: block;
        }

        .appointments-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .appointments-table thead {
            background: var(--secondary);
        }

        .appointments-table th {
            padding: 1rem 1.25rem;
            text-align: left;
            font-size: 0.813rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid var(--border);
        }

        .appointments-table td {
            padding: 1.25rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .appointments-table tbody tr {
            transition: background 0.2s ease;
        }

        .appointments-table tbody tr:hover {
            background: var(--secondary);
        }

        .appointments-table tbody tr:last-child td {
            border-bottom: none;
        }

        @media (max-width: 768px) {
            .app-wrapper {
                padding: 1rem 0.5rem;
            }

            .header {
                padding: 1.5rem;
                border-left-width: 3px;
            }

            .header-content h1 {
                font-size: 1.5rem;
            }

            .form-container {
                padding: 1.5rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .appointments-grid {
                grid-template-columns: 1fr;
            }

            .appointments-section {
                padding: 1.5rem;
            }

            .card-actions {
                flex-direction: column;
            }

            .card-actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .header {
                flex-direction: column;
                align-items: stretch;
            }

            .header-actions {
                width: 100%;
            }

            .header-actions .btn {
                flex: 1;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="app-wrapper">
        <div class="container">
            <header class="header">
                <div class="header-content">
                    <h1>Salud Integral</h1>
                    <p>Gestión de Citas Médicas</p>
                </div>
                <div class="header-actions">
                    <button class="btn btn-primary" onclick="toggleForm()" id="toggleFormBtn">
                        <span class="btn-icon">+</span>
                        Nueva Cita
                    </button>
                    <button class="btn btn-secondary" onclick="loadAppointments()">
                        <span class="btn-icon">↻</span>
                        Actualizar
                    </button>
                </div>
            </header>

            <div class="content">
                <div class="message-container" id="message-container"></div>

                <div class="form-container" id="appointmentForm">
                    <div class="form-header">
                        <h2 id="formTitle">Nueva Cita</h2>
                    </div>
                    <form id="appointmentFormElement" onsubmit="saveAppointment(event)">
                        <input type="hidden" id="appointmentId" name="id">

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="patient_name">Nombre del Paciente</label>
                                <input type="text" id="patient_name" name="patient_name" required
                                    placeholder="Ingrese el nombre completo">
                            </div>

                            <div class="form-group">
                                <label for="doctor">Médico</label>
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
                                    <label for="date">Fecha</label>
                                    <input type="date" id="date" name="date" required>
                                </div>

                                <div class="form-group">
                                    <label for="time">Hora</label>
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
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-success">Guardar Cita</button>
                            <button type="button" class="btn btn-secondary" onclick="cancelForm()">Cancelar</button>
                        </div>
                    </form>
                </div>

                <div class="appointments-section">
                    <div class="section-header">
                        <h2>Citas Programadas</h2>
                    </div>

                    <div id="appointments-container">
                        <?php if (empty($appointments)): ?>
                            <div class="empty-state">
                                <div class="empty-state-icon">📅</div>
                                <h3>No hay citas programadas</h3>
                                <p>Comience agregando una nueva cita médica</p>
                            </div>
                        <?php else: ?>
                            <div class="appointments-grid">
                                <?php foreach ($appointments as $appointment): ?>
                                    <div class="appointment-card" data-id="<?php echo htmlspecialchars($appointment['id']); ?>">
                                        <div class="card-header">
                                            <span class="card-id">Cita #<?php echo htmlspecialchars($appointment['id']); ?></span>
                                            <span class="card-status status-<?php echo htmlspecialchars($appointment['status']); ?>">
                                                <?php echo ucfirst($appointment['status']); ?>
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-field">
                                                <div class="card-label">Paciente</div>
                                                <div class="card-value patient-name"><?php echo htmlspecialchars($appointment['patient_name']); ?></div>
                                            </div>
                                            <div class="card-field">
                                                <div class="card-label">Médico</div>
                                                <div class="card-value"><?php echo htmlspecialchars($appointment['doctor']); ?></div>
                                            </div>
                                            <div class="card-field">
                                                <div class="card-label">Fecha y Hora</div>
                                                <div class="card-value"><?php echo htmlspecialchars($appointment['date']); ?> a las <?php echo htmlspecialchars($appointment['time']); ?></div>
                                            </div>
                                        </div>
                                        <div class="card-actions">
                                            <button class="btn btn-secondary btn-sm" onclick="editAppointment(<?php echo $appointment['id']; ?>)">
                                                Editar
                                            </button>
                                            <?php if ($appointment['status'] != 'cancelada'): ?>
                                                <button class="btn btn-warning btn-sm" onclick="cancelAppointment(<?php echo $appointment['id']; ?>)">
                                                    Cancelar
                                                </button>
                                            <?php endif; ?>
                                            <button class="btn btn-danger btn-sm" onclick="deleteAppointment(<?php echo $appointment['id']; ?>)">
                                                Eliminar
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let editingId = null;

        function showMessage(message, type = 'success') {
            const container = document.getElementById('message-container');
            const messageClass = type === 'success' ? 'message-success' : 'message-error';
            container.innerHTML = `<div class="message ${messageClass}">${message}</div>`;
            setTimeout(() => {
                container.innerHTML = '';
            }, 5000);
        }

        function toggleForm() {
            const form = document.getElementById('appointmentForm');
            const btn = document.getElementById('toggleFormBtn');

            if (form.classList.contains('active')) {
                form.classList.remove('active');
                btn.innerHTML = '<span class="btn-icon">+</span> Nueva Cita';
                cancelForm();
            } else {
                form.classList.add('active');
                btn.innerHTML = '<span class="btn-icon">×</span> Cerrar';
                form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
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
                            behavior: 'smooth',
                            block: 'nearest'
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

        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('date');
            const today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('min', today);
        });
    </script>
</body>

</html>
