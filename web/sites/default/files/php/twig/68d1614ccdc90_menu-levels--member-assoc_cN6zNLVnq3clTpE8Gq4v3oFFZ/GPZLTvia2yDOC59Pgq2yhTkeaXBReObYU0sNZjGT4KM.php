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

/* menu-levels--member-associations.html.twig */
class __TwigTemplate_03ed63b33a9d57f3471e624765b66d2b extends Template
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
        // line 7
        $macros["menu"] = $this->macros["menu"] = $this;
        // line 8
        yield "
";
        // line 9
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($macros["menu"]->getTemplateForMacro("macro_menu_links", $context, 9, $this->getSourceContext())->macro_menu_links(...[($context["items"] ?? null), ($context["attributes"] ?? null), 0]));
        yield "

";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["_self", "items", "attributes"]);        yield from [];
    }

    // line 11
    public function macro_menu_links($items = null, $attributes = null, $menu_level = null, ...$varargs): string|Markup
    {
        $macros = $this->macros;
        $context = [
            "items" => $items,
            "attributes" => $attributes,
            "menu_level" => $menu_level,
            "varargs" => $varargs,
        ] + $this->env->getGlobals();

        $blocks = [];

        return ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
            // line 12
            yield "  <ul";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [["menu", ("menu-level-" . CoreExtension::getAttribute($this->env, $this->source, Twig\Extension\CoreExtension::first($this->env->getCharset(), ($context["items"] ?? null)), "menu_level", [], "any", false, false, true, 12))]], "method", false, false, true, 12), "html", null, true);
            yield ">
    ";
            // line 13
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["items"] ?? null));
            foreach ($context['_seq'] as $context["key"] => $context["item"]) {
                // line 14
                yield "      ";
                if ((Twig\Extension\CoreExtension::first($this->env->getCharset(), $context["key"]) != "#")) {
                    // line 15
                    yield "        ";
                    $context["menu_item_classes"] = ["menu-item", ((CoreExtension::getAttribute($this->env, $this->source,                     // line 17
$context["item"], "is_expanded", [], "any", false, false, true, 17)) ? ("menu-item--expanded") : ("")), ((CoreExtension::getAttribute($this->env, $this->source,                     // line 18
$context["item"], "is_collapsed", [], "any", false, false, true, 18)) ? ("menu-item--collapsed") : ("")), ((CoreExtension::getAttribute($this->env, $this->source,                     // line 19
$context["item"], "in_active_trail", [], "any", false, false, true, 19)) ? ("menu-item--active-trail") : (""))];
                    // line 21
                    yield "
        <li";
                    // line 22
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "attributes", [], "any", false, false, true, 22), "addClass", [($context["menu_item_classes"] ?? null)], "method", false, false, true, 22), "html", null, true);
                    yield ">
          ";
                    // line 23
                    $context["rendered_content"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->withoutFilter(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "content", [], "any", false, false, true, 23), ""));
                    // line 24
                    yield "          ";
                    if (($context["rendered_content"] ?? null)) {
                        // line 25
                        yield "            ";
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["rendered_content"] ?? null), "html", null, true);
                        yield "
          ";
                    }
                    // line 27
                    yield "        </li>
      ";
                }
                // line 29
                yield "  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['key'], $context['item'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 30
            yield "  </ul>
";
            yield from [];
        })())) ? '' : new Markup($tmp, $this->env->getCharset());
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "menu-levels--member-associations.html.twig";
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
        return array (  118 => 30,  112 => 29,  108 => 27,  102 => 25,  99 => 24,  97 => 23,  93 => 22,  90 => 21,  88 => 19,  87 => 18,  86 => 17,  84 => 15,  81 => 14,  77 => 13,  72 => 12,  58 => 11,  49 => 9,  46 => 8,  44 => 7,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "menu-levels--member-associations.html.twig", "themes/custom/asocolderma_b5/templates/menu_item_extras/member_associations/menu-levels--member-associations.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["import" => 7, "macro" => 11, "for" => 13, "if" => 14, "set" => 15];
        static $filters = ["escape" => 12, "first" => 12, "render" => 23, "without" => 23];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['import', 'macro', 'for', 'if', 'set'],
                ['escape', 'first', 'render', 'without'],
                [],
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
