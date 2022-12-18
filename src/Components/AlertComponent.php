<?php

// src/Components/AlertComponent.php
namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('alert')]
class AlertComponent
{

    public string $message;
    public string $type = 'success';

    public function mount(bool $isSuccess = true)
    {
        $this->type = $isSuccess ? 'success' : 'danger';
    }

}