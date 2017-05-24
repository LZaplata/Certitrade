<?php

namespace LZaplata\Certitrade\DI;


use Nette\Configurator;
use Nette\DI\Compiler;
use Nette\DI\CompilerExtension;
use Nette\Utils\Validators;

class Extension extends CompilerExtension
{
    public $defaults = array(
        "sandbox" => true,
        "language" => "sv",
        "currency" => "SEK"
    );

    public function loadConfiguration()
    {
        $config = $this->getConfig($this->defaults);
        $builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix("certitrade"))
            ->setClass("CertiTrade\CTServer", [$config["merchantId"], $config["apiKey"], $config["sandbox"]]);

        $builder->addDefinition($this->prefix("service"))
            ->setClass("LZaplata\Certitrade\Service", [$this->prefix("@certitrade")])
            ->addSetup("setLanguage", [$config["lang"]])
            ->addSetup("setCurrency", [$config["currency"]]);
    }
}