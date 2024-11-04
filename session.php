<?php
session_start();

if (!function_exists('setSlotNumber')) {
    function setSlotNumber($slotNumber) {
        $_SESSION['slotNumber'] = $slotNumber;
    }
}

if (!function_exists('getSlotNumber')) {
    function getSlotNumber() {
        return isset($_SESSION['slotNumber']) ? $_SESSION['slotNumber'] : null;
    }
}

if (!function_exists('clearSlotNumber')) {
    function clearSlotNumber() {
        unset($_SESSION['slotNumber']);
    }
}
?>