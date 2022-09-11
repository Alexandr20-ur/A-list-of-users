<?php
namespace app\core;

use JetBrains\PhpStorm\Pure;
use Throwable;

class DatabaseExp extends \RuntimeException {
    private $sql;

    /**
     * @param mixed $sql
     */
    public function setSql($sql): void
    {
        $this->sql = $sql;
    }

    /**
     * @return mixed
     */
    public function getSql()
    {
        return $this->sql;
    }
}