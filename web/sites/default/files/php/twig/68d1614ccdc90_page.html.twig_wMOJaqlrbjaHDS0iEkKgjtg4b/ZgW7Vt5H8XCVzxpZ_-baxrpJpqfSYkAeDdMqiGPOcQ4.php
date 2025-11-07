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

/* themes/custom/asocolderma_b5/templates/layout/page.html.twig */
class __TwigTemplate_dac0e061858a9fd1cf45410f3a253fae extends Template
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
        // line 46
        $context["nav_classes"] = ((("navbar navbar-expand-lg" . (((        // line 47
($context["b5_navbar_schema"] ?? null) != "none")) ? ((" navbar-" . ($context["b5_navbar_schema"] ?? null))) : (" "))) . (((        // line 48
($context["b5_navbar_schema"] ?? null) != "none")) ? ((((($context["b5_navbar_schema"] ?? null) == "dark")) ? (" text-light") : (" text-dark"))) : (" "))) . (((        // line 49
($context["b5_navbar_bg_schema"] ?? null) != "none")) ? ((" bg-" . ($context["b5_navbar_bg_schema"] ?? null))) : (" ")));
        // line 51
        yield "
";
        // line 53
        $context["footer_classes"] = (((" " . (((        // line 54
($context["b5_footer_schema"] ?? null) != "none")) ? ((" footer-" . ($context["b5_footer_schema"] ?? null))) : (" "))) . (((        // line 55
($context["b5_footer_schema"] ?? null) != "none")) ? ((((($context["b5_footer_schema"] ?? null) == "dark")) ? (" text-light") : (" text-dark"))) : (" "))) . (((        // line 56
($context["b5_footer_bg_schema"] ?? null) != "none")) ? ((" bg-" . ($context["b5_footer_bg_schema"] ?? null))) : (" ")));
        // line 58
        yield "
<header class=\"main-header\">
  ";
        // line 60
        if (((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "nav_branding", [], "any", false, false, true, 60) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "searcher", [], "any", false, false, true, 60)) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "header_scroll", [], "any", false, false, true, 60))) {
            // line 61
            yield "  <div class=\"top-menu\">
    <div class=\"";
            // line 62
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["b5_top_container"] ?? null), "html", null, true);
            yield "\">
      ";
            // line 63
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "header_scroll", [], "any", false, false, true, 63), "html", null, true);
            yield "
      ";
            // line 64
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, true, 64), "html", null, true);
            yield "
    </div>
  </div>
  <div class=\"top-searcher\">
    <div class=\"";
            // line 68
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["b5_top_container"] ?? null), "html", null, true);
            yield "\">
      <nav class=\"";
            // line 69
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["nav_classes"] ?? null), "html", null, true);
            yield "\">
        ";
            // line 70
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "nav_branding", [], "any", false, false, true, 70), "html", null, true);
            yield "
        ";
            // line 71
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "searcher", [], "any", false, false, true, 71), "html", null, true);
            yield "
      </nav>
    </div>
  </div>
  ";
        }
        // line 76
        yield "
</header>

<main role=\"main\">
  <a id=\"main-content\" tabindex=\"-1\"></a>";
        // line 81
        yield "
  ";
        // line 83
        $context["sidebar_first_classes"] = (((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 83) && CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 83))) ? ("col-12 col-lg-2") : ("col-12 col-sm-12
  col-lg-12"));
        // line 86
        yield "
  ";
        // line 88
        $context["sidebar_second_classes"] = (((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 88) && CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 88))) ? ("col-12 col-lg-4") : ("col-12"));
        // line 90
        yield "
  ";
        // line 92
        $context["content_wrapper_classes"] = (((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 92) && CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 92))) ? ("col-12 col-lg-10") : ("col-12"));
        // line 94
        yield "
  ";
        // line 96
        $context["content_classes"] = (((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 96) && CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 96))) ? ("col-12 col-lg-8") : ("col-12"));
        // line 98
        yield "
  ";
        // line 99
        $context["row_classes"] = (((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 99) && CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 99))) ? ("row__sidebar") : (""));
        // line 100
        yield "

  <div class=\"";
        // line 102
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["b5_top_container"] ?? null), "html", null, true);
        yield " main-container-page\">
    <div class=\"main-content\">
      <div class=\"wrapper-body\">
        <div class=\"wrapper-body--main\">
          <div class=\"wrapper-menus\">
            ";
        // line 107
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "nav_main", [], "any", false, false, true, 107)) {
            // line 108
            yield "            <nav class=\"main-menu navbar ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["nav_classes"] ?? null), "html", null, true);
            yield "\">
              <div class=\"";
            // line 109
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["b5_top_container"] ?? null), "html", null, true);
            yield " d-flex main-menu__list\">
                <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
                  ";
            // line 111
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "nav_main", [], "any", false, false, true, 111), "html", null, true);
            yield "
                </div>
              </div>
            </nav>
            ";
        }
        // line 116
        yield "            ";
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 116) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "menu_sidebar_first", [], "any", false, false, true, 116))) {
            // line 117
            yield "            <section class=\"menu-lateral\">
              <div class=\"wrapper-menu\">
                <div class=\"top-sidemenu\">
                  <div class=\"link-sidebar\">
                    ";
            // line 121
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 121), "html", null, true);
            yield "
                    <button class=\"arrow-down d-lg-none\">Open menu mobile</button>
                  </div>
                  <div class=\"buttons-options d-lg-none\">
                    <button class=\"search-icon\">
                      <span class=\"icon-search-black\"></span>
                    </button>
                    <button class=\"navbar-toggler collapsed\" type=\"button\" data-bs-toggle=\"collapse\"
                    data-bs-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\"
                    aria-label=\"Toggle navigation\">
                      <span></span>
                      <span></span>
                      <span></span>
                    </button>
                  </div>
                </div>
                ";
            // line 137
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "menu_sidebar_first", [], "any", false, false, true, 137), "html", null, true);
            yield "
              </div>
            </section>
            ";
        }
        // line 141
        yield "          </div>
          ";
        // line 142
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "breadcrumb", [], "any", false, false, true, 142)) {
            // line 143
            yield "          <div class=\"breadcrumb-content\">
            ";
            // line 144
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "breadcrumb", [], "any", false, false, true, 144), "html", null, true);
            yield "
          </div>
          ";
        }
        // line 147
        yield "          ";
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content_column_top_left", [], "any", false, false, true, 147) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content_column_top_right", [], "any", false, false, true, 147))) {
            // line 148
            yield "            <div class=\"content-column-top\">
              ";
            // line 149
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content_column_top_left", [], "any", false, false, true, 149), "html", null, true);
            yield "
              ";
            // line 150
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content_column_top_right", [], "any", false, false, true, 150), "html", null, true);
            yield "
            </div>
          ";
        }
        // line 153
        yield "          ";
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content_top", [], "any", false, false, true, 153)) {
            // line 154
            yield "          <div class=\"content-top-page\">
            ";
            // line 155
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content_top", [], "any", false, false, true, 155), "html", null, true);
            yield "
          </div>
          ";
        }
        // line 158
        yield "          <div class=\"row g-0 main-content ";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["row_classes"] ?? null), "html", null, true);
        yield "\">

            <div class=\"body-content order-1 order-lg-2 ";
        // line 160
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["content_classes"] ?? null), "html", null, true);
        yield "\">
              ";
        // line 161
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 161), "html", null, true);
        yield "
            </div>
            ";
        // line 163
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 163)) {
            // line 164
            yield "            <aside class=\"sidebar-right order-3 ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["sidebar_second_classes"] ?? null), "html", null, true);
            yield "\">
              ";
            // line 165
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 165), "html", null, true);
            yield "
            </aside>
            ";
        }
        // line 168
        yield "          </div>
          ";
        // line 169
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content_bottom", [], "any", false, false, true, 169)) {
            // line 170
            yield "          <div class=\"content-bottom-page\">
            ";
            // line 171
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content_bottom", [], "any", false, false, true, 171), "html", null, true);
            yield "
          </div>
          ";
        }
        // line 174
        yield "        </div>
      </div>
    </div>
  </div>
</main>
<footer class=\"main-footer\" id=\"footer\">
  ";
        // line 180
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_top_left", [], "any", false, false, true, 180) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_top_right", [], "any", false, false, true, 180))) {
            // line 181
            yield "    <div class=\"top-footer\">
      <div class=\"";
            // line 182
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["b5_top_container"] ?? null), "html", null, true);
            yield "\">
        ";
            // line 183
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_top_left", [], "any", false, false, true, 183), "html", null, true);
            yield "
        ";
            // line 184
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_top_right", [], "any", false, false, true, 184), "html", null, true);
            yield "
      </div>
    </div>
  ";
        }
        // line 188
        yield "  ";
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_bottom_left", [], "any", false, false, true, 188) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_bottom_right", [], "any", false, false, true, 188))) {
            // line 189
            yield "    <div class=\"bottom-footer\">
      <div class=\"";
            // line 190
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["b5_top_container"] ?? null), "html", null, true);
            yield "\">
        ";
            // line 191
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_bottom_left", [], "any", false, false, true, 191), "html", null, true);
            yield "
        ";
            // line 192
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_bottom_right", [], "any", false, false, true, 192), "html", null, true);
            yield "
      </div>
    </div>
  ";
        }
        // line 196
        yield "  ";
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_ads", [], "any", false, false, true, 196)) {
            // line 197
            yield "    <div class=\"ads-footer\">
      ";
            // line 198
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_ads", [], "any", false, false, true, 198), "html", null, true);
            yield "
    </div>
  ";
        }
        // line 201
        yield "</footer>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["b5_navbar_schema", "b5_navbar_bg_schema", "b5_footer_schema", "b5_footer_bg_schema", "page", "b5_top_container"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/custom/asocolderma_b5/templates/layout/page.html.twig";
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
        return array (  345 => 201,  339 => 198,  336 => 197,  333 => 196,  326 => 192,  322 => 191,  318 => 190,  315 => 189,  312 => 188,  305 => 184,  301 => 183,  297 => 182,  294 => 181,  292 => 180,  284 => 174,  278 => 171,  275 => 170,  273 => 169,  270 => 168,  264 => 165,  259 => 164,  257 => 163,  252 => 161,  248 => 160,  242 => 158,  236 => 155,  233 => 154,  230 => 153,  224 => 150,  220 => 149,  217 => 148,  214 => 147,  208 => 144,  205 => 143,  203 => 142,  200 => 141,  193 => 137,  174 => 121,  168 => 117,  165 => 116,  157 => 111,  152 => 109,  147 => 108,  145 => 107,  137 => 102,  133 => 100,  131 => 99,  128 => 98,  126 => 96,  123 => 94,  121 => 92,  118 => 90,  116 => 88,  113 => 86,  110 => 83,  107 => 81,  101 => 76,  93 => 71,  89 => 70,  85 => 69,  81 => 68,  74 => 64,  70 => 63,  66 => 62,  63 => 61,  61 => 60,  57 => 58,  55 => 56,  54 => 55,  53 => 54,  52 => 53,  49 => 51,  47 => 49,  46 => 48,  45 => 47,  44 => 46,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/custom/asocolderma_b5/templates/layout/page.html.twig", "/var/www/html/web/themes/custom/asocolderma_b5/templates/layout/page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["set" => 46, "if" => 60];
        static $filters = ["escape" => 62];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if'],
                ['escape'],
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
