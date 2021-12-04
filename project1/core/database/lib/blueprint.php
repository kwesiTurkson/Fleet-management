<?php


class BluePrint
{
    protected Database $db;
    private string $table_name;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }


    protected function createTable(string $table_name, array $table_params, string $engine = "INNODB"): Blueprint
    {
        $this->table_name = $table_name;
        $combine_stmt = array_map(static function ($key, $value) {
            return "`$key` {$value}";
        }, array_keys($table_params), $table_params);

        $this->db->query(sql: "CREATE TABLE IF NOT EXISTS `$table_name`" . "(" . implode(",", $combine_stmt) . ")ENGINE=$engine");
        $this->db->execute();
        return $this;
    }


    protected function initializeAutoIncrement(int $start_num): Blueprint
    {
        $this->db->query(sql: "ALTER TABLE $this->table_name AUTO_INCREMENT=" . $start_num);
        $this->db->execute();
        return $this;
    }


    protected function alter(string $table_name, string $old_col, string $constraints, string $new_col = null): Blueprint
    {
        if (is_null($new_col)) {
            $new_col = $old_col;
        }
        $this->db->query(sql: "ALTER TABLE $table_name CHANGE $old_col $new_col" . $constraints);
        $this->db->execute();
        return $this;
    }

    protected function setPK(array $cols, string $constraint_name = null): Database
    {
        if (is_null($constraint_name)) {
            $this->db->query(sql: "ALTER TABLE $this->table_name ADD PRIMARY KEY (" . implode(",", $cols) . ")");
        } else {
            $this->db->query(sql: "ALTER TABLE $this->table_name ADD CONSTRAINT $constraint_name PRIMARY (" . implode(",", $cols) . ")");
        }
        $this->db->execute();
        return $this->db;
    }

    protected function setFK(string $table_name, string $col, string $ref_table_name, string $ref_col, string $constraint_name = null): BluePrint
    {
        if (is_null($constraint_name)) {
            $this->db->query(sql: "SET FOREIGN_KEY_CHECKS=0; ALTER TABLE $table_name ADD FOREIGN KEY ($col) REFERENCES $ref_table_name($ref_col) ON DELETE CASCADE ON UPDATE CASCADE; SET FOREIGN_KEY_CHECKS=1");
        } else {


            $this->db->query(sql: "SET FOREIGN_KEY_CHECKS=0; ALTER TABLE $table_name ADD CONSTRAINT $constraint_name FOREIGN KEY ($col) REFERENCES $ref_table_name($ref_col) ON DELETE CASCADE ON UPDATE CASCADE; SET FOREIGN_KEY_CHECKS=1");
        }
        $this->db->execute();
        return $this;
    }
}