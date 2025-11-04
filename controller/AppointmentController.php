<?php

require_once __DIR__ . '/../viewmodel/AppointmentViewModel.php';

class AppointmentController
{
    private $viewModel;

    public function __construct()
    {
        $model = new AppointmentModel();
        $this->viewModel = new AppointmentViewModel($model);
    }

    public function index()
    {
        $appointments = $this->viewModel->getAllAppointments();
        return $appointments;
    }

    public function show($id)
    {
        $appointment = $this->viewModel->getAppointmentById($id);
        return $appointment;
    }

    public function create($data)
    {
        return $this->viewModel->createAppointment($data);
    }

    public function update($id, $data)
    {
        return $this->viewModel->updateAppointment($id, $data);
    }

    public function cancel($id)
    {
        return $this->viewModel->cancelAppointment($id);
    }

    public function delete($id)
    {
        return $this->viewModel->deleteAppointment($id);
    }

    public function getViewModel()
    {
        return $this->viewModel;
    }
}
