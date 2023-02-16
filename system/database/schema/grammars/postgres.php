<?php

namespace System\Database\Schema\Grammars;

defined('DS') or exit('No direct script access.');

use System\Magic;
use System\Database\Schema\Table;

class Postgres extends Grammar
{
    /**
     * Buat sintaks sql untuk pembuatan tabel.
     *
     * @param Table $table
     * @param Magic $command
     *
     * @return array
     */
    public function create(Table $table, Magic $command)
    {
        $columns = implode(', ', $this->columns($table));
        return 'CREATE TABLE ' . $this->wrap($table) . ' (' . $columns . ')';
    }

    /**
     * Buat sintaks sql untuk modifikasi tabel.
     *
     * @param Table $table
     * @param Magic $command
     *
     * @return array
     */
    public function add(Table $table, Magic $command)
    {
        $columns = implode(', ', array_map(function ($column) {
            return 'ADD COLUMN ' . $column;
        }, $this->columns($table)));

        return 'ALTER TABLE ' . $this->wrap($table) . ' ' . $columns;
    }

    /**
     * Buat sintaks sql untuk definisi kolom.
     *
     * @param Table $table
     *
     * @return array
     */
    protected function columns(Table $table)
    {
        $columns = [];

        foreach ($table->columns as $column) {
            $sql = $this->wrap($column) . ' ' . $this->type($column);
            $sql .= $this->incrementer($table, $column);
            $sql .= $this->nullable($table, $column);
            $sql .= $this->defaults($table, $column);
            $columns[] = $sql;
        }

        return $columns;
    }

    /**
     * Buat sintaks sql indikasi bahwa kolom boleh null.
     *
     * @param Table $table
     * @param Magic $column
     *
     * @return string
     */
    protected function nullable(Table $table, Magic $column)
    {
        return $column->nullable ? ' NULL' : ' NOT NULL';
    }

    /**
     * Buat sintaks sql set default value kolom.
     *
     * @param Table $table
     * @param Magic $column
     *
     * @return string
     */
    protected function defaults(Table $table, Magic $column)
    {
        if (!is_null($column->default)) {
            return " DEFAULT '" . $this->default_value($column->default) . "'";
        }
    }

    /**
     * Buat sintaks sql untuk definisi kolom auto-increment.
     *
     * @param Table $table
     * @param Magic $column
     *
     * @return string
     */
    protected function incrementer(Table $table, Magic $column)
    {
        if ('integer' === $column->type && $column->increment) {
            return ' PRIMARY KEY';
        }
    }

    /**
     * Buat sintaks sql untuk membuat kolom primary key.
     *
     * @param Table $table
     * @param Magic $command
     *
     * @return string
     */
    public function primary(Table $table, Magic $command)
    {
        $columns = $this->columnize($command->columns);
        return 'ALTER TABLE ' . $this->wrap($table) . ' ADD PRIMARY KEY (' . $columns . ')';
    }

    /**
     * Buat sintaks sql untuk membuat unique index.
     *
     * @param Table $table
     * @param Magic $command
     *
     * @return string
     */
    public function unique(Table $table, Magic $command)
    {
        $table = $this->wrap($table);
        $columns = $this->columnize($command->columns);

        return 'ALTER TABLE ' . $table . ' ADD CONSTRAINT ' . $command->name
            . ' UNIQUE (' . $columns . ')';
    }

    /**
     * Buat sintaks sql untuk membuat full-text index.
     *
     * @param Table $table
     * @param Magic $command
     *
     * @return string
     */
    public function fulltext(Table $table, Magic $command)
    {
        $columns = $this->columnize($command->columns);
        return 'CREATE INDEX ' . $command->name . ' ON ' . $this->wrap($table)
            . ' USING gin(' . $columns . ')';
    }

    /**
     * Buat sintaks sql untuk membuat index biasa.
     *
     * @param Table $table
     * @param Magic $command
     *
     * @return string
     */
    public function index(Table $table, Magic $command)
    {
        return $this->key($table, $command);
    }

    /**
     * Buat sintaks sql untuk membuat index baru.
     *
     * @param Table $table
     * @param Magic $command
     * @param bool  $unique
     *
     * @return string
     */
    protected function key(Table $table, Magic $command, $unique = false)
    {
        return ($unique ? 'CREATE UNIQUE' : 'CREATE') . ' INDEX ' . $command->name . ' ON '
            . $this->wrap($table) . ' (' . $this->columnize($command->columns) . ')';
    }

    /**
     * Buat sintaks sql untuk rename tabel.
     *
     * @param Table $table
     * @param Magic $command
     *
     * @return string
     */
    public function rename(Table $table, Magic $command)
    {
        return 'ALTER TABLE ' . $this->wrap($table) . ' RENAME TO ' . $this->wrap($command->name);
    }

    /**
     * Buat sintaks sql untuk dropp kolom.
     *
     * @param Table $table
     * @param Magic $command
     *
     * @return string
     */
    public function drop_column(Table $table, Magic $command)
    {
        $columns = array_map([$this, 'wrap'], $command->columns);
        $columns = implode(', ', array_map(function ($column) {
            return 'DROP COLUMN ' . $column;
        }, $columns));

        return 'ALTER TABLE ' . $this->wrap($table) . ' ' . $columns;
    }

    /**
     * Buat sintaks sql untuk drop primary key.
     *
     * @param Table $table
     * @param Magic $command
     *
     * @return string
     */
    public function drop_primary(Table $table, Magic $command)
    {
        return 'ALTER TABLE ' . $this->wrap($table) . ' DROP CONSTRAINT ' . $table->name . '_pkey';
    }

    /**
     * Buat sintaks sql untuk drop unique key.
     *
     * @param Table $table
     * @param Magic $command
     *
     * @return string
     */
    public function drop_unique(Table $table, Magic $command)
    {
        return $this->drop_constraint($table, $command);
    }

    /**
     * Buat sintaks sql untuk fulltext key.
     *
     * @param Table $table
     * @param Magic $command
     *
     * @return string
     */
    public function drop_fulltext(Table $table, Magic $command)
    {
        return $this->drop_key($table, $command);
    }

    /**
     * Buat sintaks sql untuk drop index key.
     *
     * @param Table $table
     * @param Magic $command
     *
     * @return string
     */
    public function drop_index(Table $table, Magic $command)
    {
        return $this->drop_key($table, $command);
    }

    /**
     * Buat sintaks sql untuk drop key.
     *
     * @param Table $table
     * @param Magic $command
     *
     * @return string
     */
    protected function drop_key(Table $table, Magic $command)
    {
        return 'DROP INDEX ' . $command->name;
    }

    /**
     * Buat sintaks sql untuk drop foreign key constraint.
     *
     * @param Table $table
     * @param Magic $command
     *
     * @return string
     */
    public function drop_foreign(Table $table, Magic $command)
    {
        return $this->drop_constraint($table, $command);
    }

    /**
     * Buat definisi tipe data string.
     *
     * @param Magic $column
     *
     * @return string
     */
    protected function type_string(Magic $column)
    {
        return 'VARCHAR(' . $column->length . ')';
    }

    /**
     * Buat definisi tipe data integer.
     *
     * @param Magic $column
     *
     * @return string
     */
    protected function type_integer(Magic $column)
    {
        return $column->increment ? 'SERIAL' : 'BIGINT';
    }

    /**
     * Buat definisi tipe data float.
     *
     * @param Magic $column
     *
     * @return string
     */
    protected function type_float(Magic $column)
    {
        return 'REAL';
    }

    /**
     * Buat definisi tipe data decimal.
     *
     * @param Magic $column
     *
     * @return string
     */
    protected function type_decimal(Magic $column)
    {
        return 'DECIMAL(' . $column->precision . ', ' . $column->scale . ')';
    }

    /**
     * Buat definisi tipe data boolean.
     *
     * @param Magic $column
     *
     * @return string
     */
    protected function type_boolean(Magic $column)
    {
        return 'SMALLINT';
    }

    /**
     * Buat definisi tipe data date.
     *
     * @param Magic $column
     *
     * @return string
     */
    protected function type_date(Magic $column)
    {
        return 'TIMESTAMP(0) WITHOUT TIME ZONE';
    }

    /**
     * Buat definisi tipe data timestamp.
     *
     * @param Magic $column
     *
     * @return string
     */
    protected function type_timestamp(Magic $column)
    {
        return 'TIMESTAMP';
    }

    /**
     * Buat definisi tipe data text.
     *
     * @param Magic $column
     *
     * @return string
     */
    protected function type_text(Magic $column)
    {
        return 'TEXT';
    }

    /**
     * Buat definisi tipe data blob.
     *
     * @param Magic $column
     *
     * @return string
     */
    protected function type_blob(Magic $column)
    {
        return 'BYTEA';
    }
}
