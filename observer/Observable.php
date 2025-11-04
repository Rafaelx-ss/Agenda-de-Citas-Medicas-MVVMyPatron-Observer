<?php

require_once __DIR__ . '/ObserverInterface.php';
require_once __DIR__ . '/SubjectInterface.php';

class Observable implements SubjectInterface {
    private $observers = [];

    public function attach(ObserverInterface $observer) {
        $this->observers[] = $observer;
    }

    public function detach(ObserverInterface $observer) {
        $this->observers = array_filter($this->observers, function($obs) use ($observer) {
            return $obs !== $observer;
        });
    }

    public function notify($data) {
        foreach ($this->observers as $observer) {
            $observer->update($data);
        }
    }

    public function getObserversCount() {
        return count($this->observers);
    }
}

