<?php

namespace App\DTO;

class BasicResponseModel
{
    public $content;
    public $status;

    public function __construct($content, $status) {
        $this->content = $content;
        $this->status = $status;
      }
}
