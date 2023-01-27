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

/* /base/tail.html */
class __TwigTemplate_7928624c15709637b1f8f79a1e6628a7 extends Template
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
        echo "<!-- HTMX -->
<script src=\"";
        // line 2
        echo twig_escape_filter($this->env, ($context["js_path"] ?? null), "html", null, true);
        echo "/htmx.min.js\"></script>

</html>";
    }

    public function getTemplateName()
    {
        return "/base/tail.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  40 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/base/tail.html", "/home/benjamin/Projects/zenrepair/resources/views/base/tail.html");
    }
}
