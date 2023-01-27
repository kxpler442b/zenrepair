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

/* /base_layout.twig */
class __TwigTemplate_40e32d58083e519a11549cb6bc0687b3 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'navbar' => [$this, 'block_navbar'],
            'content' => [$this, 'block_content'],
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
    <div class=\"h-full flex flex-row justify-start align-middle bg-zinc-100\">
        ";
        // line 21
        $this->displayBlock('navbar', $context, $blocks);
        // line 22
        echo "
        ";
        // line 23
        $this->displayBlock('content', $context, $blocks);
        // line 24
        echo "    </div>
</body>

<!-- HTMX -->
<script src=\"";
        // line 28
        echo twig_escape_filter($this->env, ($context["js_path"] ?? null), "html", null, true);
        echo "/htmx.min.js\"></script>

</html>";
    }

    // line 21
    public function block_navbar($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 23
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    public function getTemplateName()
    {
        return "/base_layout.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  93 => 23,  87 => 21,  80 => 28,  74 => 24,  72 => 23,  69 => 22,  67 => 21,  60 => 17,  55 => 15,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/base_layout.twig", "/home/benjamin/Projects/zenrepair/resources/views/base_layout.twig");
    }
}
