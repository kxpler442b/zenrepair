<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* /layouts/dashboard.html */
class __TwigTemplate_6d8da248de8b8ad39587a7a548b228dc extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<div class=\"flex flex-col flex-grow justify-start align-middle px-6 py-3\">
    <h1 class=\"text-3xl text-zinc-900 font-bold\">Dashboard</h1>
</div>";
    }

    public function getTemplateName()
    {
        return "/layouts/dashboard.html";
    }

    public function getDebugInfo()
    {
        return array (  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/layouts/dashboard.html", "/home/benjamin/Projects/zenrepair/resources/views/layouts/dashboard.html");
    }
}
