<?php

class ErrorView {
    public function showError($message) {
        require_once './templates/error.phtml';
    }
}