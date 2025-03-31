<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class BootstrapButton
{
    public string $text;
    public string $strtype = "";
    public string $path = "";

    
    public function mount(string $type = "primary", bool $isOutlined = false):void
    {
        if($isOutlined){
            $this->strtype .= "outline-";
        }
        $this->strtype .= $type;
    }
}