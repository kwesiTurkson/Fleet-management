<?php

class VehicleTypeRepository implements IRepository
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }


    public function insert(array $values): bool
    {
        // TODO: Implement insert() method.
    }

    public function update(array $values, string $id): bool
    {
        // TODO: Implement update() method.
    }

    public function getAll(): array
    {
        $this->db->query(sql: "SELECT * FROM `vehicle_type`");
        return $this->db->resultSet();
    }

    public function rowCount(): int
    {
        // TODO: Implement rowCount() method.
    }

    public function getSingle(int $id): mixed
    {
        // TODO: Implement getSingle() method.
    }

    public function getFrom(DateTime $dateTime)
    {
        // TODO: Implement getFrom() method.
    }

    public function search($key)
    {
        // TODO: Implement search() method.
    }
}