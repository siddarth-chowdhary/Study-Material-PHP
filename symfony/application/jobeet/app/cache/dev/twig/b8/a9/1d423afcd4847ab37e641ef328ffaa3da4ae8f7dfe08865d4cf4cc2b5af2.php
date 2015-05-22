<?php

/* LoginLoginBundle:Default:login.html.twig */
class __TwigTemplate_b8a91d423afcd4847ab37e641ef328ffaa3da4ae8f7dfe08865d4cf4cc2b5af2 extends Twig_Template
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

    // line 3
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 4
        echo "<style type=\"text/css\">
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            max-width: 300px;
            padding: 19px 29px 29px;
            margin: 0 auto 20px;
            background-color: #fff;
            border: 1px solid #e5e5e5;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
            -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
            box-shadow: 0 1px 2px rgba(0,0,0,.05);
        }
        .form-signin .form-signin-heading,
        .form-signin .checkbox {
            margin-bottom: 10px;
        }
        .form-signin input[type=\"text\"],
        .form-signin input[type=\"password\"] {
            font-size: 16px;
            height: auto;
            margin-bottom: 15px;
            padding: 7px 9px;
        }

    </style>
";
    }

    // line 38
    public function block_container($context, array $blocks = array())
    {
        // line 39
        echo "    <div class=\"container\">

        <form class=\"form-signin\" method =\"POST\" action=\"";
        // line 41
        echo $this->env->getExtension('routing')->getPath("login_login_homepage");
        echo "\" data-validate=\"parsley\">
            <h2 class=\"form-signin-heading\">Please sign in</h2>
            <input type=\"text\" id=\"username\" class=\"input-block-level\" name=\"username\" placeholder=\"Email address\" data-trigger=\"change\" data-required=\"true\" data-type=\"email\">
            <input type=\"password\" class=\"input-block-level\" name=\"password\" placeholder=\"Password\" data-trigger=\"change\" data-required=\"true\">
            <label class=\"checkbox\">
                <input type=\"checkbox\" name=\"remember\" value=\"remember-me\"> Remember me
            </label>
            <button class=\"btn btn-large btn-primary\" type=\"submit\">Sign in</button>
            <a href=\"";
        // line 49
        echo $this->env->getExtension('routing')->getPath("login_login_signup");
        echo "\" >Sign Up</a>
        </form>

    </div> 
    ";
        // line 54
        echo "    ";
        if (array_key_exists("name", $context)) {
            // line 55
            echo "    <div class=\"alert-info fade in\">
        <strong>";
            // line 56
            echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : $this->getContext($context, "name")), "html", null, true);
            echo "</strong>
    </div>
    ";
        }
        // line 59
        echo "    ";
        if (array_key_exists("err", $context)) {
            // line 60
            echo "    <div class=\"alert-danger fade in\">
        <strong>Invalid Credentials !!</strong>
    </div>
    ";
        }
        // line 64
        echo "    ";
    }

    public function getTemplateName()
    {
        return "LoginLoginBundle:Default:login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  123 => 64,  117 => 60,  114 => 59,  108 => 56,  105 => 55,  102 => 54,  95 => 49,  84 => 41,  80 => 39,  77 => 38,  40 => 4,  37 => 3,  11 => 2,);
    }
}
