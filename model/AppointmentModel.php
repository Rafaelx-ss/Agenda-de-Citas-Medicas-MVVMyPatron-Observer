<?php

require_once __DIR__ . '/../observer/Observable.php';

class AppointmentModel extends Observable {
    private $dataFile;
    private $appointments = [];

    public function __construct($dataFile = null) {
        parent::__construct();
        $this->dataFile = $dataFile ?? __DIR__ . '/../data/appointments.json';
        $this->loadData();
    }

    private function loadData() {
        if (file_exists($this->dataFile)) {
            $content = file_get_contents($this->dataFile);
            $this->appointments = json_decode($content, true) ?: [];
        } else {
            $this->appointments = [];
            $this->saveData();
        }
    }

    private function saveData() {
        $dir = dirname($this->dataFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        file_put_contents($this->dataFile, json_encode($this->appointments, JSON_PRETTY_PRINT));
    }

    public function getAll() {
        return $this->appointments;
    }

    public function getById($id) {
        foreach ($this->appointments as $appointment) {
            if ($appointment['id'] == $id) {
                return $appointment;
            }
        }
        return null;
    }

    public function create($data) {
        $id = $this->generateId();
        $appointment = [
            'id' => $id,
            'patient_name' => $data['patient_name'],
            'doctor' => $data['doctor'],
            'date' => $data['date'],
            'time' => $data['time'],
            'status' => $data['status'] ?? 'programada'
        ];
        
        $this->appointments[] = $appointment;
        $this->saveData();
        $this->notify(['action' => 'create', 'data' => $appointment]);
        return $appointment;
    }

    public function update($id, $data) {
        foreach ($this->appointments as &$appointment) {
            if ($appointment['id'] == $id) {
                $appointment['patient_name'] = $data['patient_name'] ?? $appointment['patient_name'];
                $appointment['doctor'] = $data['doctor'] ?? $appointment['doctor'];
                $appointment['date'] = $data['date'] ?? $appointment['date'];
                $appointment['time'] = $data['time'] ?? $appointment['time'];
                $appointment['status'] = $data['status'] ?? $appointment['status'];
                
                $this->saveData();
                $this->notify(['action' => 'update', 'data' => $appointment]);
                return $appointment;
            }
        }
        return null;
    }

    public function delete($id) {
        foreach ($this->appointments as $key => $appointment) {
            if ($appointment['id'] == $id) {
                $deleted = $this->appointments[$key];
                unset($this->appointments[$key]);
                $this->appointments = array_values($this->appointments);
                $this->saveData();
                $this->notify(['action' => 'delete', 'data' => $deleted]);
                return true;
            }
        }
        return false;
    }

    public function checkDuplicate($date, $time, $doctor, $excludeId = null) {
        foreach ($this->appointments as $appointment) {
            if ($excludeId && $appointment['id'] == $excludeId) {
                continue;
            }
            if ($appointment['date'] == $date && 
                $appointment['time'] == $time && 
                $appointment['doctor'] == $doctor &&
                $appointment['status'] != 'cancelada') {
                return true;
            }
        }
        return false;
    }

    private function generateId() {
        if (empty($this->appointments)) {
            return 1;
        }
        $maxId = max(array_column($this->appointments, 'id'));
        return $maxId + 1;
    }
}

