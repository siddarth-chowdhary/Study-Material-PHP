<?php

/* LoginLoginBundle:Default:signup.html.twig */
class __TwigTemplate_52f91f6e889a1e627de17dde1b2506141bc5ff4f7ef2c6a4782dfa366f59867e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 2
        try {
            $this->parent = $this->env->loadTemplate("LoginLoginBundle:Default:index.html.twig");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(2);

            throw $e;
        }

        $this->blocks = array(
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

    // line 3
    public function block_container($context, array $blocks = array())
    {
        // line 4
        echo "<div class=\"container\" >
    <form id=\"form\" class=\"well\" method=\"POST\" action=\"";
        // line 5
        echo $this->env->getExtension('routing')->getPath("login_login_signup");
        echo "\" data-validate=\"parsley\">
        <h2>Sign Up</h2>
        <label>Username</label>
        <input type=\"text\" id=\"username\" name=\"username\" class=\"input-xlarge\" data-trigger=\"change\" data-required=\"true\" data-type=\"email\">
        <label>Repeat Username</label>
        <input type=\"text\" id=\"usernameRe\" name=\"usernameRe\" class=\"input-xlarge\" data-trigger=\"change\" data-required=\"true\" data-type=\"email\" data-equalto=\"#username\">
        <label>First Name</label>
        <input type=\"text\" name=\"firstname\" class=\"input-xlarge\" data-trigger=\"change\" data-required=\"true\">
        <label>Last Name</label>
        <input type=\"text\" name=\"lastname\" class=\"input-xlarge\" data-trigger=\"change\" data-required=\"true\">
        <label>Password</label>
        <input type=\"password\" name=\"password\" class=\"input-xlarge\" data-trigger=\"change\" data-required=\"true\">
        <div>
            <button class=\"btn btn-primary\" type=\"submit\" >Create Account</button>
        </div>

    </form>
</div>
 ";
    }

    public function getTemplateName()
    {
        return "LoginLoginBundle:Default:signup.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  42 => 5,  39 => 4,  36 => 3,  11 => 2,);
    }
}
