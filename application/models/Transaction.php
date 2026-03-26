<?php
require_once __DIR__ . '/Execute.php';

class Transaction
{
    private $exec;

    public function __construct($config)
    {
        $this->exec = new Execute($config);
    }
}
