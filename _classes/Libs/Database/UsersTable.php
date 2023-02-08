<?php

namespace Libs\Database;

use PDOException;

class UsersTable
{
    private $db = null;

    public function __construct ( MySQL $db ) {
        $this->db = $db->connect();
    }

    public function getAllRoster()
    {
        $statement = $this->db->query("
            SELECT * FROM rosters ORDER BY name
        ");

        return $statement->fetchAll();
    }

    public function getOwnedRoster( $id )
    {
        $statement = $this->db->prepare("
            SELECT rosters.*
            FROM rosters LEFT JOIN owns
            ON rosters.id=owns.roster
            WHERE owns.user=:id
            ORDER BY rosters.name
        ");

        $statement->execute([
            ':id' => $id,
        ]);

        return $statement->fetchAll();
    }

    public function findByEmailAndPassword ( $email, $password ) {
        $statement = $this->db->prepare("
            SELECT users.*, roles.name AS role, roles.value
            FROM users LEFT JOIN roles
            ON users.role_id=roles.id
            WHERE users.email=:email
            AND users.password=:password
        ");

        $statement->execute([
            ':email' => $email,
            ':password' => $password,
        ]);

        $row = $statement->fetch();

        return $row ?? false;
    }

    public function findById ( $id ) {
        $statement = $this->db->prepare("
            SELECT users.*, roles.name AS role, roles.value
            FROM users LEFT JOIN roles
            ON users.role_id=roles.id
            WHERE users.id=:id
        ");

        $statement->execute([
            ':id' => $id,
        ]);

        $row = $statement->fetch();

        return $row ?? false;
    }

    public function findByEmail ( $email ) {
        $statement = $this->db->prepare("
            SELECT * FROM users WHERE email=:email
        ");

        $statement->execute([
            ':email' => $email,
        ]);

        $row = $statement->fetch();

        return $row ?? false;
    }

    public function findRoster ( $id ) {
        $statement = $this->db->prepare("
            SELECT * FROM rosters WHERE id=:id
        ");

        $statement->execute([
            ':id' => $id,
        ]);

        $row = $statement->fetch();

        return $row ?? false;
    }

    public function updatePhoto ( $id, $name ) {
        $statement = $this->db->prepare("
            UPDATE users SET photo=:photo,updated_at=NOW() WHERE id=:id
        ");

        $statement->execute([
            ':photo' => $name,
            ':id' => $id,
        ]);

        return $statement->rowCount(); 
    }

    public function updateName ( $id, $name ) {
        $statement = $this->db->prepare("
            UPDATE users SET name=:name,updated_at=NOW() WHERE id=:id
        ");

        $statement->execute([
            ':name' => $name,
            ':id' => $id,
        ]);

        return $statement->rowCount(); 
    }

    public function updatePassword ( $id, $name ) {
        $statement = $this->db->prepare("
            UPDATE users SET password=:name,updated_at=NOW() WHERE id=:id
        ");

        $statement->execute([
            ':name' => $name,
            ':id' => $id,
        ]);

        return $statement->rowCount(); 
    }

    public function checkPassword ( $id, $password ) {
        $statement = $this->db->prepare("
            SELECT password FROM users WHERE id=:id
        ");

        $statement->execute([
            ':id' => $id,
        ]);

        $row = $statement->fetch();

        if( $row->password === $password ) return true;
        else return false;
    }

    public function addUser ( $name, $email, $password ) {
        $statement = $this->db->prepare("
            INSERT INTO users (name, email, password, created_at) 
            VALUES (:name, :email, :password, NOW())
        ");

        $statement->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $password,
        ]);

        $row = $statement->fetch();

        return $this->db->lastInsertID();
    }
}