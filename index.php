<?php
// Root index.php acting as the Front Controller for the MVC structure

// Include the database configuration (provides $conn and helper functions)
require_once __DIR__ . '/config/database.php';

// Bootstrap the MVC architecture
require_once __DIR__ . '/app/Core/App.php';
require_once __DIR__ . '/app/Core/Controller.php';

// Initialize the application
$app = new App();
