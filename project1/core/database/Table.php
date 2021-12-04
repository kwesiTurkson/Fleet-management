<?php

class Table extends BluePrint
{
    public function __construct()
    {
        parent::__construct();

        $this->admin();
        $this->user();
        $this->driver();
        $this->branch();
        $this->vehicleType();
        $this->vehicle();
        $this->booking();
    }

    private function admin(): void
    {
        $tableCols = array(
            "admin_id" => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
            "username" => "VARCHAR(100) NOT NULL",
            "password" => "VARCHAR(10)"
        );
        $this->createTable(table_name: 'admin', table_params: $tableCols);
    }


    private function user(): void
    {
        $tableCols = array(
            "user_id" => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
            "first_name" => "VARCHAR(100) NOT NULL",
            "last_name" => "VARCHAR(100)",
            "email" => "VARCHAR(100) NOT NULL",
            "password" => "VARCHAR(250)",
        );
        $this->createTable(table_name: 'user', table_params: $tableCols);
    }


    private function driver(): void
    {
        $tableCols = array(
            "driver_id" => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
            "driver_name" => "VARCHAR(100) NOT NULL",
            "driver_mobile_no" => "VARCHAR(50) NOT NULL",
            "driver_national_id" => "VARCHAR(50)",
            "driver_licence_no" => "VARCHAR(50)",
            "driver_licence_expire_at" => "DATE",
            "driver_photo" => "VARCHAR(150)",
            "is_available" => "TINYINT(1)",
            "created_at" => "DATETIME DEFAULT CURRENT_TIMESTAMP",
            "updated_at" => "DATETIME ON UPDATE CURRENT_TIMESTAMP"
        );
        $this->createTable(table_name: 'driver', table_params: $tableCols);
    }


    private function vehicleType(): void
    {
        $tableCols = array(
            "vehicle_type_id" => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
            "vehicle_type" => "VARCHAR(40)",
        );

        $this->createTable(table_name: 'vehicle_type', table_params: $tableCols);

//        $sql = "INSERT INTO vehicle_type (vehicle_type) SELECT * FROM (SELECT (?)) AS tmp WHERE NOT EXISTS (SELECT vehicle_type FROM vehicle_type WHERE vehicle_type = (?)) LIMIT 1";
//        $this->db->query(sql: $sql);
//        $values = array(
//            'motor' => array("Car", "Car"),
//            'car' => array("Motor", "Motor"),
//        );
//        foreach ($values as $value) {
//            $this->db->insert($value);
//        }
    }

    private function vehicle(): void
    {
        $tableCols = array(
            "vehicle_id" => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
            "vehicle_reg" => "VARCHAR(100) NOT NULL",
            "vehicle_type" => "INT NOT NULL",
            "vehicle_chesis_no" => "VARCHAR(50) NOT NULL",
            "vehicle_brand" => "VARCHAR(50)",
            "vehicle_color" => "VARCHAR(100) NOT NULL",
            "vehicle_register_date" => "DATETIME NOT NULL",
            "vehicle_description" => "VARCHAR(250) NOT NULL",
            "vehicle_photo" => "VARCHAR(200)",
            "is_available" => "TINYINT(1) NOT NULL DEFAULT true",
            "created_at" => "DATETIME DEFAULT CURRENT_TIMESTAMP",
            "updated_at" => "DATETIME ON UPDATE CURRENT_TIMESTAMP"
        );
        $this->createTable(table_name: 'vehicle', table_params: $tableCols)
            ->setFK(table_name: 'vehicle', col: 'vehicle_type', ref_table_name: 'vehicle_type', ref_col: 'vehicle_type_id', constraint_name: 'fk_vehicle_type');
    }


    private function branch(): void
    {
        $tableCols = array(
            "branch_id" => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
            "branch_name" => "VARCHAR(100) NOT NULL",
            "created_at" => "DATETIME DEFAULT CURRENT_TIMESTAMP",
            "updated_at" => "DATETIME ON UPDATE CURRENT_TIMESTAMP"
        );
        $this->createTable(table_name: 'vehicle', table_params: $tableCols);
    }


    private function booking(): void
    {
        $tableCols = array(
            "booking_id" => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
            "destination" => "VARCHAR(100) NOT NULL",
            "pickup_point" => "VARCHAR(100) NOT NULL",
            "reasons" => "VARCHAR(250)",
            "finished" => "TINYINT(1)",
            "user_id" => "INT NOT NULL",
            "branch_id" => "VARCHAR(250)",
            "vehicle_id" => "INT NOT NULL",
            "driver_id" => "INT NOT NULL",
            "created_at" => "DATETIME DEFAULT CURRENT_TIMESTAMP",
            "updated_at" => "DATETIME ON UPDATE CURRENT_TIMESTAMP"
        );

        $this->createTable(table_name: 'booking', table_params: $tableCols)
            ->setFK(table_name: 'booking', col: 'vehicle_id', ref_table_name: 'vehicle', ref_col: 'vehicle_id', constraint_name: 'fk_booking_vehicle')
            ->setFK(table_name: 'booking', col: 'driver_id', ref_table_name: 'driver', ref_col: 'driver_id', constraint_name: 'fk_booking_driver')
            ->setFK(table_name: 'booking', col: 'branch_id', ref_table_name: 'branch', ref_col: 'branch_id', constraint_name: 'fk_booking_branch')
            ->setFK(table_name: 'booking', col: 'user_id', ref_table_name: 'user', ref_col: 'user_id', constraint_name: 'fk_booking_user');
    }


}


