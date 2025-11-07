<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* modules/contrib/menu_item_extras/templates/menu-link-content.html.twig */
class __TwigTemplate_1432addab5c503e8bd82b8c20fb7763a extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 15
        $macros["menu"] = $this->macros["menu"] = $this;
        // line 16
        yield "
";
        // line 17
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($macros["menu"]->getTemplateForMacro("macro_build_menu_link_content", $context, 17, $this->getSourceContext())->macro_build_menu_link_content(...[($context["attributes"] ?? null), ($context["menu_link_content"] ?? null), ($context["show_item_link"] ?? null), ($context["content"] ?? null), ($context["elements"] ?? null)]));
        yield "

";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["_self", "attributes", "menu_link_content", "show_item_link", "content", "elements"]);        yield from [];
    }

    // line 19
    public function macro_build_menu_link_content($attributes = null, $menu_link_content = null, $show_item_link = null, $content = null, $elements = null, ...$varargs): string|Markup
    {
        $macros = $this->macros;
        $context = [
            "attributes" => $attributes,
            "menu_link_content" => $menu_link_content,
            "show_item_link" => $show_item_link,
            "content" => $content,
            "elements" => $elements,
            "varargs" => $varargs,
        ] + $this->env->getGlobals();

        $blocks = [];

        return ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
            // line 20
            yield "  ";
            $context["menu_dropdown_classes"] = ["menu-dropdown", ((CoreExtension::getAttribute($this->env, $this->source,             // line 22
($context["elements"] ?? null), "#menu_level", [], "array", true, true, true, 22)) ? (("menu-dropdown-" . (($_v0 = ($context["elements"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess && in_array($_v0::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v0["#menu_level"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["elements"] ?? null), "#menu_level", [], "array", false, false, true, 22)))) : ("")), (((($_v1 =             // line 23
($context["elements"] ?? null)) && is_array($_v1) || $_v1 instanceof ArrayAccess && in_array($_v1::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v1["#view_mode"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["elements"] ?? null), "#view_mode", [], "array", false, false, true, 23))) ? (("menu-type-" . (($_v2 = ($context["elements"] ?? null)) && is_array($_v2) || $_v2 instanceof ArrayAccess && in_array($_v2::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v2["#view_mode"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["elements"] ?? null), "#view_mode", [], "array", false, false, true, 23)))) : (""))];
            // line 25
            yield "
  <div";
            // line 26
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [($context["menu_dropdown_classes"] ?? null)], "method", false, false, true, 26), "html", null, true);
            yield ">
    ";
            // line 27
            if (($context["show_item_link"] ?? null)) {
                // line 28
                yield "      ";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->getLink(CoreExtension::getAttribute($this->env, $this->source, ($context["menu_link_content"] ?? null), "getTitle", [], "method", false, false, true, 28), CoreExtension::getAttribute($this->env, $this->source, ($context["menu_link_content"] ?? null), "getUrlObject", [], "method", false, false, true, 28)), "html", null, true);
                yield "
    ";
            }
            // line 30
            yield "    ";
            if (($context["content"] ?? null)) {
                // line 31
                yield "      ";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["content"] ?? null), "html", null, true);
                yield "
    ";
            }
            // line 33
            yield "  </div>
";
            yield from [];
        })())) ? '' : new Markup($tmp, $this->env->getCharset());
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "modules/contrib/menu_item_extras/templates/menu-link-content.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  103 => 33,  97 => 31,  94 => 30,  88 => 28,  86 => 27,  82 => 26,  79 => 25,  77 => 23,  76 => 22,  74 => 20,  58 => 19,  49 => 17,  46 => 16,  44 => 15,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "modules/contrib/menu_item_extras/templates/menu-link-content.html.twig", "/var/www/html/web/modules/contrib/menu_item_extras/templates/menu-link-content.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["import" => 15, "macro" => 19, "set" => 20, "if" => 27];
        static $filters = ["escape" => 26];
        static $functions = ["link" => 28];

        try {
            $this->sandbox->checkSecurity(
                ['import', 'macro', 'set', 'if'],
                ['escape'],
                ['link'],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
