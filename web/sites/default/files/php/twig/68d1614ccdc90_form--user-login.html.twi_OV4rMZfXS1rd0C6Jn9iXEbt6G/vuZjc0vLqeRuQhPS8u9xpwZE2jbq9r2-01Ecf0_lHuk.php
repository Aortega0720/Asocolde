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

/* themes/custom/asocolderma_b5/templates/user/form--user-login.html.twig */
class __TwigTemplate_3fa465b6163e9e6496508bfec835e6c5 extends Template
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
        // line 13
        yield "<div class=\"content-user-form\">
  <div class=\"top-elements\">
    <p>¿No es miembro de AsoColDerma?</p>
    <a href=\"/user/register\" class=\"\" rel=\"nofollow\" title=\"Crear nueva cuenta\">Afíliese</a>
  </div>
  <h2>Inicio sesión AsoColDerma</h2>
  <form";
        // line 19
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["attributes"] ?? null), "html", null, true);
        yield ">
    ";
        // line 20
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["children"] ?? null), "html", null, true);
        yield "
  </form>
  <div class=\"login-links\">
    <a href=\"/user/password\" class=\"\" rel=\"nofollow\" title=\"Solicitar una nueva contraseña\">¿Olvidó su nombre de usuario o contraseña?</a>
    <a href=\"/ayuda\" class=\"\">Ayuda</a>
  </div>
  <div class=\"bottom-text\">
    <p> Este espacio está dirigido únicamente a médicos dermatólogos, miembros de la Asociación Colombiana de Dermatología. En caso de no cumplir los anteriores requisitos le solicitamos abstenerse de intentar el ingreso, de lo contrario estaría incurriendo en fraude por suplantación. si ya es miembro de la Asociación y no tiene contrase; a escribanos a: <a href=\"mailto:recepcion@asocolderma.org.co\" title=\"\">recepcion@asocolderma.org.co</a></p>
    <p>Con sus datos de contacto y número de cédula o ID de Asociado. En menos de 48 horas recibirá un correo con las instrucciones para restablecer los datos de acceso.</p>
  </div>
</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["attributes", "children"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/custom/asocolderma_b5/templates/user/form--user-login.html.twig";
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
        return array (  56 => 20,  52 => 19,  44 => 13,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/custom/asocolderma_b5/templates/user/form--user-login.html.twig", "/var/www/html/web/themes/custom/asocolderma_b5/templates/user/form--user-login.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = [];
        static $filters = ["escape" => 19];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                [],
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
