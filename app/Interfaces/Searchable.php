<?php


namespace App\Interfaces;


interface Searchable
{
    public function getImage();

    public function getTitle();

    public function getDescription();

    public function getLink();

    public function getDate();

    public function getModelName();

    public function getSearchableColumns();
}