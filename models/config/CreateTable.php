<?php

namespace app\models\config;

class CreateTable
{
    public function __construct()
    {
    }

    public function createTable(){
        return "<table></table>";
    }

    public function createTr(){
        return "<tr></tr>";
    }

    public function createTd(){
        return "<td></td>";
    }
}