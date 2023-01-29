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

/* /base_layout.html */
class __TwigTemplate_964e510f9bd5bcfc418f2ad834ab655a extends Template
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
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta author=\"Benjamin Moss\">
    <meta charset=\"UTF-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">

    <!-- Source Pro Fonts -->
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@400;700&family=Source+Sans+Pro:ital,wght@0,400;0,700;1,400&display=swap\" rel=\"stylesheet\">

    <!-- Tailwind CSS -->
    <link rel=\"stylesheet\" type=\"text/css\" href=\"";
        // line 15
        echo twig_escape_filter($this->env, ($context["css_path"] ?? null), "html", null, true);
        echo "/output.css\">

    <title>";
        // line 17
        echo twig_escape_filter($this->env, ($context["title"] ?? null), "html", null, true);
        echo "</title>
</head>
<body class=\"h-screen\">
    <div class=\"h-full grid grid-cols-12 grid-flow-row bg-stone-50\">
        <div class=\"col-span-2 flex flex-col justify-start align-middle border border-red-600\">
            <div class=\"px-6 py-3 border border-red-600\">
                <div class=\"w-fit px-1.5 rounded-md bg-sky-600\">
                    <h1 class=\"font-bold text-2xl text-white\">RSMS</h1>
                </div>
            </div>
            <div class=\"mx-3 my-3 border-b border-stone-200\"></div>
            <div class=\"flex-grow border border-red-600\">
                <ul>
                    <li class=\"w-full my-3 py-3\"><a href=\"#\">Dashboard</a></li>
                </ul>
            </div>
        </div>
        <div class=\"col-span-10 flex flex-col flex-grow justify-center align-middle border border-red-600\">
            <div class=\"flex flex-row justify-center align-middle px-3 py-1.5 border border-red-600\">
                <form class=\"w-1/2\" action=\"#\" method=\"POST\">
                    <input class=\"w-full text-md text-stone-900 rounded-lg border-none bg-stone-600/10\" type=\"text\" placeholder=\"Search tickets\">
                </form>
            </div>
            <div class=\"flex flex-col flex-grow justify-start align-middle border border-red-600\">
                #
            </div>
        </div>
    </div>
</body>

<!-- HTMX -->
<script src=\"";
        // line 48
        echo twig_escape_filter($this->env, ($context["js_path"] ?? null), "html", null, true);
        echo "/htmx.min.js\"></script>

</html>";
    }

    public function getTemplateName()
    {
        return "/base_layout.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  92 => 48,  58 => 17,  53 => 15,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/base_layout.html", "/home/benjamin/Projects/zenrepair/resources/views/base_layout.html");
    }
}
