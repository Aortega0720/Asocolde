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

/* modules/contrib/menu_item_extras/templates/menu--extras.html.twig */
class __TwigTemplate_98ef28a3d1f9a153915a459554f76e40 extends Template
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
        // line 22
        yield "
";
        // line 23
        $macros["menu"] = $this->macros["menu"] = $this->loadTemplate("menu-levels.html.twig", "modules/contrib/menu_item_extras/templates/menu--extras.html.twig", 23)->unwrap();
        // line 24
        yield "
";
        // line 25
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($macros["menu"]->getTemplateForMacro("macro_menu_links", $context, 25, $this->getSourceContext())->macro_menu_links(...[($context["items"] ?? null), ($context["attributes"] ?? null), 0]));
        yield "
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["items", "attributes"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "modules/contrib/menu_item_extras/templates/menu--extras.html.twig";
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
        return array (  52 => 25,  49 => 24,  47 => 23,  44 => 22,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "modules/contrib/menu_item_extras/templates/menu--extras.html.twig", "/var/www/html/web/modules/contrib/menu_item_extras/templates/menu--extras.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["import" => 23];
        static $filters = [];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['import'],
                [],
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
