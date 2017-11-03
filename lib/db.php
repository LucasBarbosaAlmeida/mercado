<?php

namespace Lib;

class DB {

    protected $connection;
    protected static $instance;

    private function __construct($host, $user, $password, $db_name) {
        $this->connection = new \mysqli($host, $user, $password, $db_name);

        if (mysqli_connect_error()) {
            throw new \Exception("Não foi possível conectar com o banco de dados. Erro: " . mysqli_connect_error() . ".");
        }
    }

    public static function getConnection() {
        if(self::$instance==NULL){
            self::$instance=new DB(Config::get('db.host'),Config::get('db.user'), Config::get('db.password'), Config::get('db.name'));
        
        }
        return self::$instance->connection;
    }

    public static function close() {
            if(self::$instance!=NULL){
        if (self::$instance->connection) {
            self::$instance->connection->close();
            }       
        }
    }
}