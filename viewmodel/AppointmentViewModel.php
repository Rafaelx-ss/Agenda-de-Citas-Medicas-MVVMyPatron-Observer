<?php

require_once __DIR__ . '/../observer/ObserverInterface.php';
require_once __DIR__ . '/../model/AppointmentModel.php';

class AppointmentViewModel implements ObserverInterface
{
    private $model;
    private $viewObservers = [];

    public function __construct(AppointmentModel $model)
    {
        $this->model = $model;
        $this->model->attach($this);
    }

    public function getAllAppointments()
    {
        return $this->model->getAll();
    }

    public function getAppointmentById($id)
    {
        return $this->model->getById($id);
    }

    public function createAppointment($data)
    {
        $errors = $this->validate($data);

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        if ($this->model->checkDuplicate($data['date'], $data['time'], $data['doctor'])) {
            return ['success' => false, 'errors' => ['Ya existe una cita programada para este médico en la fecha y hora seleccionada']];
        }

        $appointment = $this->model->create($data);
        return ['success' => true, 'data' => $appointment];
    }

    public function updateAppointment($id, $data)
    {
        $errors = $this->validate($data, $id);

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        if ($this->model->checkDuplicate($data['date'], $data['time'], $data['doctor'], $id)) {
            return ['success' => false, 'errors' => ['Ya existe otra cita programada para este médico en la fecha y hora seleccionada']];
        }

        $appointment = $this->model->update($id, $data);

        if ($appointment) {
            return ['success' => true, 'data' => $appointment];
        }

        return ['success' => false, 'errors' => ['Cita no encontrada']];
    }

    public function cancelAppointment($id)
    {
        $appointment = $this->model->getById($id);

        if (!$appointment) {
            return ['success' => false, 'errors' => ['Cita no encontrada']];
        }

        $result = $this->model->update($id, ['status' => 'cancelada']);

        if ($result) {
            return ['success' => true, 'data' => $result];
        }

        return ['success' => false, 'errors' => ['Error al cancelar la cita']];
    }

    public function deleteAppointment($id)
    {
        $result = $this->model->delete($id);

        if ($result) {
            return ['success' => true];
        }

        return ['success' => false, 'errors' => ['Cita no encontrada']];
    }

    private function validate($data, $id = null)
    {
        $errors = [];

        if (empty($data['patient_name'])) {
            $errors[] = 'El nombre del paciente es requerido';
        }

        if (empty($data['doctor'])) {
            $errors[] = 'El médico es requerido';
        }

        if (empty($data['date'])) {
            $errors[] = 'La fecha es requerida';
        } elseif (!strtotime($data['date'])) {
            $errors[] = 'La fecha no es válida';
        }

        if (empty($data['time'])) {
            $errors[] = 'La hora es requerida';
        } elseif (!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $data['time'])) {
            $errors[] = 'La hora no es válida (formato: HH:MM)';
        }

        return $errors;
    }

    public function update($data)
    {
        // Notificar a todos los observadores de la vista
        foreach ($this->viewObservers as $observer) {
            $observer->update($data);
        }
    }

    public function attachViewObserver(ObserverInterface $observer)
    {
        $this->viewObservers[] = $observer;
    }

    public function getModel()
    {
        return $this->model;
    }
}
