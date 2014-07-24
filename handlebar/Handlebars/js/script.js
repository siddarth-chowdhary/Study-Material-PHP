// Grab the HTML source that needs to be compiled
//var menuSource = document.getElementById( 'menu-template' ).innerHTML;
var menuSource = $("#menu-template").html();
// Compiles the source
var menuTemplate = Handlebars.compile( menuSource );
//Data that will replace the handlebars expressions in our template
var menuData = {
    linkName1 : "Google",
    linkName2 : "Yahoo",
    linkName3 : "Test",
    linkName4 : "Ok",
    linkName5 : "Bye",
    linkURL1 : "http://google.com",
    linkURL2 : "http://jaskokoyn.com",
    linkURL3 : "http://yahoo.com",
    linkURL4 : "http://youtube.com",
    linkURL5 : "http://twitter.com"
};
// Process Template with Data
document.getElementById( 'menu-placeholder' ).innerHTML = menuTemplate( menuData );
