<?php


namespace App\Interfaces;


interface ViewCountable
{
    public function getViewCount();

    public function incrementViewCount();
}