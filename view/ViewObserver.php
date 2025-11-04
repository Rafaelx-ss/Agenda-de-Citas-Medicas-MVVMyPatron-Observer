<?php

require_once __DIR__ . '/../observer/ObserverInterface.php';

class ViewObserver implements ObserverInterface {
    private $updateCallback;

    public function __construct($updateCallback) {
        $this->updateCallback = $updateCallback;
    }

    public function update($data) {
        if (is_callable($this->updateCallback)) {
            call_user_func($this->updateCallback, $data);
        }
    }
}

