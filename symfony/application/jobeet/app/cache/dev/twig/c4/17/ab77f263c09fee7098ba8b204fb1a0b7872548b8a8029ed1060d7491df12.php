<?php

/* LoginLoginBundle:Default:welcome.html.twig */
class __TwigTemplate_c417ab77f263c09fee7098ba8b204fb1a0b7872548b8a8029ed1060d7491df12 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 3
        try {
            $this->parent = $this->env->loadTemplate("LoginLoginBundle:Default:index.html.twig");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(3);

            throw $e;
        }

        $this->blocks = array(
            'stylesheets' => array($this, 'block_stylesheets'),
            'container' => array($this, 'block_container'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "LoginLoginBundle:Default:index.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 5
        echo "
";
    }

    // line 7
    public function block_container($context, array $blocks = array())
    {
        // line 8
        echo "<div class=\"container\">
    <h2>Hello ";
        // line 9
        echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : $this->getContext($context, "name")), "html", null, true);
        echo "</h2>
    <p> from welcome.html.twig , login secured page</p>
 ";
        // line 12
        echo "</div> 
<a href=\"";
        // line 13
        echo $this->env->getExtension('routing')->getPath("login_login_logout");
        echo "\" >Logout</a>
    ";
    }

    public function getTemplateName()
    {
        return "LoginLoginBundle:Default:welcome.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  59 => 13,  56 => 12,  51 => 9,  48 => 8,  45 => 7,  40 => 5,  37 => 4,  11 => 3,);
    }
}
