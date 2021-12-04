<?php
require_once "config/constants.php";
require_once 'repositories/base_repository/IRepository.php';
require_once 'database/lib/Blueprint.php';
require_once 'database/lib/Database.php';
require_once 'database/Table.php';
require_once 'repositories/VehicleTypeRepository.php';

$table = new Table();

$vehicle_type = new VehicleTypeRepository();
$vehicle_types = $vehicle_type->getAll();

print_r($vehicle_types);
