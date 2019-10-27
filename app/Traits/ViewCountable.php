<?php


namespace App\Traits;


trait ViewCountable
{
    public function getViewCount() {
        return $this->views;
    }

    public function incrementViewCount() {
        $this->views++;
        $this->save();
    }
}