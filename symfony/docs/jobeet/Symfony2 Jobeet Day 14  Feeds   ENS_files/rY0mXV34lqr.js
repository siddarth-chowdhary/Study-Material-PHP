/*!CK:2511177522!*//*1386803395,178191129*/

if (self.CavalryLogger) { CavalryLogger.start_js(["2ctlm"]); }

__d("collectDataAttributes",["getContextualParent"],function(a,b,c,d,e,f){var g=b('getContextualParent');function h(i,j){var k={},l={},m=j.length,n;for(n=0;n<m;++n){k[j[n]]={};l[j[n]]='data-'+j[n];}var o={tn:'',"tn-debug":','};while(i){if(i.getAttribute)for(n=0;n<m;++n){var p=i.getAttribute(l[j[n]]);if(p){var q=JSON.parse(p);for(var r in q)if(o[r]!==undefined){if(k[j[n]][r]===undefined)k[j[n]][r]=[];k[j[n]][r].push(q[r]);}else if(k[j[n]][r]===undefined)k[j[n]][r]=q[r];}}i=g(i);}for(var s in k)for(var t in o)if(k[s][t]!==undefined)k[s][t]=k[s][t].join(o[t]);return k;}e.exports=h;});