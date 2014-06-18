<?php
ini_set("display_errors","1");
ini_set('error_reporting', E_ALL);
debug_backtrace();

function makeCocktail()
{
    try {
        pour_ingredients();
        stir();
    } catch (Exception $e) {
        die("I could not make you a cocktail");
    }

    try {
        put_decorative_umbrella();
    } catch (Exception $e) {
        echo "We 're out of umbrellas, but the drink itself is fine";
    }
}

echo "start";
makeCocktail();

