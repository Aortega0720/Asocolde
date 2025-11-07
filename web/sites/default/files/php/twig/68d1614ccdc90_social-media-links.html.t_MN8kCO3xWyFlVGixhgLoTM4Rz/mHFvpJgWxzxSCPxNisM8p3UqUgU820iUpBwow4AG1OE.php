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

/* modules/custom/social_media/templates/social-media-links.html.twig */
class __TwigTemplate_d295c539a48f96729870f2d203cc5b78 extends Template
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
        // line 8
        yield "

<div class=\"social-media-sharing\">
  <ul class=\"\">
    ";
        // line 12
        $context["classes"] = ["share"];
        // line 16
        yield "    ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["elements"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["element"]) {
            // line 17
            yield "      ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["element"], "forward_dialog", [], "any", false, false, true, 17) == 1)) {
                // line 18
                yield "        ";
                $context["classes"] = Twig\Extension\CoreExtension::merge(($context["classes"] ?? null), ["use-ajax"]);
                // line 19
                yield "        ";
                $context["dialogType"] = "data-dialog-type=dialog";
                // line 20
                yield "        ";
                $context["dialogOptions"] = ("data-dialog-options=" . json_encode(["width" => "600"]));
                // line 21
                yield "      ";
            }
            // line 22
            yield "      <li>
        <a ";
            // line 23
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["dialogType"] ?? null), "html", null, true);
            yield " ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["dialogOptions"] ?? null), "html", null, true);
            yield " ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["element"], "attr", [], "any", false, false, true, 23), "target", [], "any", false, false, true, 23), "html", null, true);
            yield " ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["element"], "attr", [], "any", false, false, true, 23), "rel", [], "any", false, false, true, 23), "html", null, true);
            yield " ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["element"], "attr", [], "any", false, false, true, 23), "class", [], "any", false, false, true, 23), "addClass", [($context["classes"] ?? null)], "method", false, false, true, 23), "html", null, true);
            yield "  ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["element"], "api", [], "any", false, false, true, 23), "html", null, true);
            yield "
          title=\"";
            // line 24
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["element"], "text", [], "any", false, false, true, 24), "html", null, true);
            yield "\">
          ";
            // line 25
            if (CoreExtension::getAttribute($this->env, $this->source, $context["element"], "img", [], "any", false, false, true, 25)) {
                // line 26
                yield "            <img alt=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["element"], "text", [], "any", false, false, true, 26), "html", null, true);
                yield "\" src=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["element"], "img", [], "any", false, false, true, 26), "html", null, true);
                yield "\">
          ";
            } else {
                // line 28
                yield "            ";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["element"], "text", [], "any", false, false, true, 28), "html", null, true);
                yield "
          ";
            }
            // line 30
            yield "        </a>

      </li>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['element'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 34
        yield "  </ul>
</div>

";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["elements"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "modules/custom/social_media/templates/social-media-links.html.twig";
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
        return array (  118 => 34,  109 => 30,  103 => 28,  95 => 26,  93 => 25,  89 => 24,  75 => 23,  72 => 22,  69 => 21,  66 => 20,  63 => 19,  60 => 18,  57 => 17,  52 => 16,  50 => 12,  44 => 8,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "modules/custom/social_media/templates/social-media-links.html.twig", "/var/www/html/web/modules/custom/social_media/templates/social-media-links.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["set" => 12, "for" => 16, "if" => 17];
        static $filters = ["merge" => 18, "json_encode" => 20, "escape" => 23];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['set', 'for', 'if'],
                ['merge', 'json_encode', 'escape'],
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
