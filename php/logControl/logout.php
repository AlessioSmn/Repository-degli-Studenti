<?php

// Riprende la sessione attiva
session_start();

// Elimina tutte le varibili di sessione
session_unset();

// Elimina la sessione corrente
session_destroy();

?>