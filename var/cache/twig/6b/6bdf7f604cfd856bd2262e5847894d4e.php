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
        echo "<div class=\"sticky top-0 h-32 px-80 flex flex-col justify-center align-middle items-center shadow-sm border-b border-stone-300 bg-white/30 backdrop-blur-md\">
    <div class=\"w-full h-24 flex flex-row justify-center align-middle items-center\">
        <div class=\"px-3 py-1 rounded-md shadow-md bg-stone-600\">
            <h1 class=\"text-2xl text-stone-50 font-bold\">RSMS</h1>
        </div>
        <div class=\"flex-grow\"></div>
        <div class=\"flex flex-row justify-center items-center\">
            <h1 class=\"pr-3 font-semibold text-sm text-stone-700\">Joe Bloggs</h1>
            <div class=\"h-8 w-8 rounded-full bg-stone-600\">
                
            </div>
        </div>
    </div>
    <div class=\"w-full flex flex-row justify-left align-middle items-center flex-grow\">
        <a href=\"/dashboard\" class=\"px-3 pt-1.5 pb-2 font-bold text-stone-600 text-md rounded-t-sm border-b border-transparent hover:border-stone-600 hover:bg-stone-200\">Dashboard</a>
        <a href=\"/tickets\" class=\"px-3 pt-1.5 pb-2 font-bold text-stone-600 text-md rounded-t-sm border-b border-transparent hover:border-stone-600 hover:bg-stone-200\">Tickets</a>
        <a href=\"/customers\" class=\"px-3 pt-1.5 pb-2 font-bold text-stone-600 text-md rounded-t-sm border-b border-transparent hover:border-stone-600 hover:bg-stone-200\">Customers</a>
        <a href=\"/devices\" class=\"px-3 pt-1.5 pb-2 font-bold text-stone-600 text-md rounded-t-sm border-b border-transparent hover:border-stone-600 hover:bg-stone-200\">Devices</a>
    </div>
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
