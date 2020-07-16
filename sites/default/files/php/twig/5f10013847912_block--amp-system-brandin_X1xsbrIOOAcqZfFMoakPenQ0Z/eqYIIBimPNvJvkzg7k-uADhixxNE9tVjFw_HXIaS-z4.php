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

/* modules/contrib/amp/templates/block--amp-system-branding-block.html.twig */
class __TwigTemplate_4c2f95ab85841b6414e35ffce4019d016e27c97439873ba2cf33aec5b980e1c1 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["if" => 20];
        $filters = ["t" => 21, "escape" => 22];
        $functions = ["path" => 21];

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['t', 'escape'],
                ['path']
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

    protected function doGetParent(array $context)
    {
        // line 1
        return "block.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $this->parent = $this->loadTemplate("block.html.twig", "modules/contrib/amp/templates/block--amp-system-branding-block.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 18
    public function block_content($context, array $blocks = [])
    {
        // line 19
        echo "<div class=\"amp-system-branding-block\">
  ";
        // line 20
        if (($context["site_logo"] ?? null)) {
            // line 21
            echo "    <a href=\"";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->env->getExtension('Drupal\Core\Template\TwigExtension')->getPath("<front>"));
            echo "\" title=\"";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Home"));
            echo "\" rel=\"home\" class=\"site-logo\">
      <amp-img src=\"";
            // line 22
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["site_logo"] ?? null)), "html", null, true);
            echo "\" alt=\"";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Home"));
            echo "\" width=\"";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["logo_width"] ?? null)), "html", null, true);
            echo "\" height=\"";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["logo_height"] ?? null)), "html", null, true);
            echo "\"> </amp-image>
    </a>
  ";
        }
        // line 25
        echo "  ";
        if (($context["site_name"] ?? null)) {
            // line 26
            echo "    <div class=\"site-name\">
      <a href=\"";
            // line 27
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->env->getExtension('Drupal\Core\Template\TwigExtension')->getPath("<front>"));
            echo "\" title=\"";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Home"));
            echo "\" rel=\"home\">";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["site_name"] ?? null)), "html", null, true);
            echo "</a>
    </div>
  ";
        }
        // line 30
        echo "  ";
        if (($context["site_slogan"] ?? null)) {
            // line 31
            echo "    <div class=\"site-slogan\">";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["site_slogan"] ?? null)), "html", null, true);
            echo "</div>
  ";
        }
        // line 33
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "modules/contrib/amp/templates/block--amp-system-branding-block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  116 => 33,  110 => 31,  107 => 30,  97 => 27,  94 => 26,  91 => 25,  79 => 22,  72 => 21,  70 => 20,  67 => 19,  64 => 18,  54 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "modules/contrib/amp/templates/block--amp-system-branding-block.html.twig", "C:\\xampp\\htdocs\\amp-drupal-8\\modules\\contrib\\amp\\templates\\block--amp-system-branding-block.html.twig");
    }
}
