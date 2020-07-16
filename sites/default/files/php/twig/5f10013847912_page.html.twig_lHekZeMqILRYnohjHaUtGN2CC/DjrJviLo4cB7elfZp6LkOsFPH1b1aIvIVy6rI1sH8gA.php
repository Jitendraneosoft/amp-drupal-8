<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* themes/custom/barriotestamptheme/templates/page.html.twig */
class __TwigTemplate_8436c211da5469a307140c5496d1df00d68ff551bf753bc325f1f5c355605645 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["if" => 48];
        $filters = ["escape" => 45, "render" => 54];
        $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape', 'render'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

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

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 41
        echo "<div class=\"layout-wrapper\">
<div class=\"layout-container\">

  <header role=\"banner\">
    ";
        // line 45
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "header", [])), "html", null, true);
        echo "
  </header>

  ";
        // line 48
        if ($this->getAttribute(($context["page"] ?? null), "primary_menu", [])) {
            // line 49
            echo "    <div id=\"menu\">
    ";
            // line 50
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "primary_menu", [])), "html", null, true);
            echo "
    </div>
  ";
        }
        // line 53
        echo "
  ";
        // line 54
        if ( !twig_test_empty($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->getAttribute(($context["page"] ?? null), "breadcrumb", [])))) {
            // line 55
            echo "    <div id=\"breadcrumb\">
    ";
            // line 56
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "breadcrumb", [])), "html", null, true);
            echo "
    </div>
  ";
        }
        // line 59
        echo "
  <main role=\"main\">
    <div class=\"main-outer\">
    <div class=\"main-inner\">
    <a id=\"main-content\" tabindex=\"-1\"></a>";
        // line 64
        echo "
    <div class=\"layout-content\">
      ";
        // line 66
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "content", [])), "html", null, true);
        echo "
    </div>";
        // line 68
        echo "
    ";
        // line 69
        if ($this->getAttribute(($context["page"] ?? null), "sidebar_first", [])) {
            // line 70
            echo "      <aside class=\"layout-sidebar-first\" role=\"complementary\">
        ";
            // line 71
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "sidebar_first", [])), "html", null, true);
            echo "
      </aside>
    ";
        }
        // line 74
        echo "
    ";
        // line 75
        if ($this->getAttribute(($context["page"] ?? null), "sidebar_second", [])) {
            // line 76
            echo "      <aside class=\"layout-sidebar-second\" role=\"complementary\">
        ";
            // line 77
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "sidebar_second", [])), "html", null, true);
            echo "
      </aside>
    ";
        }
        // line 80
        echo "    </div>
    </div>
  </main>

  ";
        // line 84
        if ($this->getAttribute(($context["page"] ?? null), "footer", [])) {
            // line 85
            echo "    <footer role=\"contentinfo\">
      ";
            // line 86
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "footer", [])), "html", null, true);
            echo "
    </footer>
  ";
        }
        // line 89
        echo "
</div>";
        // line 91
        echo "</div>";
    }

    public function getTemplateName()
    {
        return "themes/custom/barriotestamptheme/templates/page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  154 => 91,  151 => 89,  145 => 86,  142 => 85,  140 => 84,  134 => 80,  128 => 77,  125 => 76,  123 => 75,  120 => 74,  114 => 71,  111 => 70,  109 => 69,  106 => 68,  102 => 66,  98 => 64,  92 => 59,  86 => 56,  83 => 55,  81 => 54,  78 => 53,  72 => 50,  69 => 49,  67 => 48,  61 => 45,  55 => 41,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/barriotestamptheme/templates/page.html.twig", "C:\\xampp\\htdocs\\amp-drupal-8\\themes\\custom\\barriotestamptheme\\templates\\page.html.twig");
    }
}
