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

/* /layouts/category.html */
class __TwigTemplate_028cdd12373314a83c2fb024623dbd92 extends Template
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
        echo "<div class=\"flex flex-col justify-center align-middle px-80 pt-3\">
    <div class=\"my-3\">
        <h1 class=\"text-3xl text-zinc-900 font-bold\">";
        // line 3
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["category"] ?? null), "singularName", [], "any", false, false, false, 3), "html", null, true);
        echo "s</h1>
    </div>
    <div class=\"my-3\">
        <div class=\"flex flex-row justify-center align-middle items-center w-full\">
            <div>
                <form action=\"#\" method=\"POST\">
                    <input name=\"search\" id=\"search\" type=\"text\" placeholder=\"Search ";
        // line 9
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["category"] ?? null), "singularName", [], "any", false, false, false, 9), "html", null, true);
        echo "s\" class=\"text-sm border-gray-400 rounded-md shadow-sm focus:ring-zinc-600 focus:border-zinc-600\">
                    <select name=\"sort\" id=\"sort\" class=\"text-sm border-gray-400 rounded-md shadow-sm focus:ring-zinc-600 focus:border-zinc-600\">
                        <option value=\"newest\">Newest First</option>
                        <option value=\"oldest\">Oldest First</option>
                    </select>
                </form>
            </div>
            <div class=\"flex-grow\"></div>
            <a href=\"/";
        // line 17
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["category"] ?? null), "url", [], "any", false, false, false, 17), "html", null, true);
        echo "/create\" class=\"px-5 py-2 text-white font-semibold text-sm rounded bg-zinc-600 hover:bg-zinc-700\">New ";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["category"] ?? null), "singularName", [], "any", false, false, false, 17), "html", null, true);
        echo "</a>
        </div>
    </div>
    <div class=\"my-3\">
        <div class=\"w-full border-x border-gray-300 shadow-sm\">
            <table class=\"w-full table-auto\">
                <thead class=\"border-y border-gray-300 bg-stone-200\">
                    <tr>
                        <th class=\"px-3 py-1.5 font-semibold text-md text-left\">Header0</th>
                        <th class=\"px-3 py-1.5 font-semibold text-md text-left\">Header1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class=\"px-3 py-3 text-sm border-b border-gray-300 bg-stone-50\">Data0</td>
                        <td class=\"px-3 py-3 text-sm border-b border-gray-300 bg-stone-50\">Data1</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "/layouts/category.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  61 => 17,  50 => 9,  41 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/layouts/category.html", "/home/benjamin/Projects/zenrepair/resources/views/layouts/category.html");
    }
}
