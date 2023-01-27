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

/* /components/navbar.html */
class __TwigTemplate_b0f780174b39ac40e580b056d8d1e802 extends Template
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
        echo "<div class=\"w-1/6 z-10 flex flex-col justify-start align-middle shadow-sm rounded-tr-md rounded-br-md bg-zinc-50\">
    <div class=\"my-1.5 px-6 py-3\">
        <h1 class=\"font-bold text-2xl text-sky-600\">RSMS</h1>
    </div>
    <div class=\"border-b border-zinc-200\"></div>
    <div class=\"my-1.5 px-6 py-3\">
        <ul>
            <li class=\"mb-1.5 px-3 py-1.5 text-md text-sky-600 hover:text-white rounded-md hover:bg-sky-600\"><a class=\"\" href=\"/dashboard\">Dashboard</a></li>
            <li class=\"mb-1.5 px-3 py-1.5 text-md text-sky-600 hover:text-white rounded-md hover:bg-sky-600\"><a class=\"\" href=\"/tickets\">Tickets</a></li>
            <li class=\"mb-1.5 px-3 py-1.5 text-md text-sky-600 hover:text-white rounded-md hover:bg-sky-600\"><a class=\"\" href=\"/customers\">Customers</a></li>
            <li class=\"mb-1.5 px-3 py-1.5 text-md text-sky-600 hover:text-white rounded-md hover:bg-sky-600\"><a class=\"\" href=\"/devices\">Devices</a></li>
        </ul>
    </div>
    <div class=\"border-b border-zinc-200\"></div>
</div>";
    }

    public function getTemplateName()
    {
        return "/components/navbar.html";
    }

    public function getDebugInfo()
    {
        return array (  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/components/navbar.html", "/home/benjamin/Projects/zenrepair/resources/views/components/navbar.html");
    }
}
