// TinyColor.js - <https://github.com/bgrins/TinyColor> - 2012 Brian Grinstead - v0.9.12
(function(C){var t,u,v,w,x,y,z;function d(a,c){a=a?a:"";if("object"==typeof a&&a.hasOwnProperty("_tc_id"))return a;var b=D(a),i=b.r,j=b.g,g=b.b,f=b.a,k=e(100*f)/100,E=b.format;1>i&&(i=e(i));1>j&&(j=e(j));1>g&&(g=e(g));return{ok:b.ok,format:E,_tc_id:F++,alpha:f,toHsv:function(){var a=A(i,j,g);return{h:360*a.h,s:a.s,v:a.v,a:f}},toHsvString:function(){var a=A(i,j,g),b=e(360*a.h),c=e(100*a.s),a=e(100*a.v);return 1==f?"hsv("+b+", "+c+"%, "+a+"%)":"hsva("+b+", "+c+"%, "+a+"%, "+k+")"},toHsl:function(){var a=
B(i,j,g);return{h:360*a.h,s:a.s,l:a.l,a:f}},toHslString:function(){var a=B(i,j,g),b=e(360*a.h),c=e(100*a.s),a=e(100*a.l);return 1==f?"hsl("+b+", "+c+"%, "+a+"%)":"hsla("+b+", "+c+"%, "+a+"%, "+k+")"},toHex:function(){return q(i,j,g)},toHexString:function(){return"#"+q(i,j,g)},toRgb:function(){return{r:e(i),g:e(j),b:e(g),a:f}},toRgbString:function(){return 1==f?"rgb("+e(i)+", "+e(j)+", "+e(g)+")":"rgba("+e(i)+", "+e(j)+", "+e(g)+", "+k+")"},toPercentageRgb:function(){return{r:e(100*h(i,255))+"%",g:e(100*
h(j,255))+"%",b:e(100*h(g,255))+"%",a:f}},toPercentageRgbString:function(){return 1==f?"rgb("+e(100*h(i,255))+"%, "+e(100*h(j,255))+"%, "+e(100*h(g,255))+"%)":"rgba("+e(100*h(i,255))+"%, "+e(100*h(j,255))+"%, "+e(100*h(g,255))+"%, "+k+")"},toName:function(){return G[q(i,j,g)]||!1},toFilter:function(){var a=q(i,j,g),b=a,e=Math.round(255*parseFloat(f)).toString(16),h=e,k=c&&c.gradientType?"GradientType = 1, ":"";secondColor&&(h=d(secondColor),b=h.toHex(),h=Math.round(255*parseFloat(h.alpha)).toString(16));
return"progid:DXImageTransform.Microsoft.gradient("+k+"startColorstr=#"+o(e)+a+",endColorstr=#"+o(h)+b+")"},toString:function(a){var a=a||this.format,b=!1;"rgb"===a&&(b=this.toRgbString());"prgb"===a&&(b=this.toPercentageRgbString());"hex"===a&&(b=this.toHexString());"name"===a&&(b=this.toName());"hsl"===a&&(b=this.toHslString());"hsv"===a&&(b=this.toHsvString());return b||this.toHexString()}}}function D(a){var c={r:255,g:255,b:255},b=1,i=!1,d=!1;if("string"==typeof a)a:{var a=a.replace(H,"").replace(I,
"").toLowerCase(),g=!1;if(r[a])a=r[a],g=!0;else if("transparent"==a){a={r:0,g:0,b:0,a:0};break a}var f,a=(f=t.exec(a))?{r:f[1],g:f[2],b:f[3]}:(f=u.exec(a))?{r:f[1],g:f[2],b:f[3],a:f[4]}:(f=v.exec(a))?{h:f[1],s:f[2],l:f[3]}:(f=w.exec(a))?{h:f[1],s:f[2],l:f[3],a:f[4]}:(f=x.exec(a))?{h:f[1],s:f[2],v:f[3]}:(f=y.exec(a))?{r:parseInt(f[1],16),g:parseInt(f[2],16),b:parseInt(f[3],16),format:g?"name":"hex"}:(f=z.exec(a))?{r:parseInt(f[1]+""+f[1],16),g:parseInt(f[2]+""+f[2],16),b:parseInt(f[3]+""+f[3],16),
format:g?"name":"hex"}:!1}if("object"==typeof a){if(a.hasOwnProperty("r")&&a.hasOwnProperty("g")&&a.hasOwnProperty("b"))c={r:255*h(a.r,255),g:255*h(a.g,255),b:255*h(a.b,255)},i=!0,d="%"===(""+a.r).substr(-1)?"prgb":"rgb";else if(a.hasOwnProperty("h")&&a.hasOwnProperty("s")&&a.hasOwnProperty("v")){a.s=p(a.s);a.v=p(a.v);var d=a.h,g=a.s,c=a.v,d=6*h(d,360),g=h(g,100),c=h(c,100),i=n.floor(d),e=d-i,d=c*(1-g);f=c*(1-e*g);g=c*(1-(1-e)*g);i%=6;c={r:255*[c,f,d,d,g,c][i],g:255*[g,c,c,f,d,d][i],b:255*[d,d,g,
c,c,f][i]};i=!0;d="hsv"}else a.hasOwnProperty("h")&&a.hasOwnProperty("s")&&a.hasOwnProperty("l")&&(a.s=p(a.s),a.l=p(a.l),c=J(a.h,a.s,a.l),i=!0,d="hsl");a.hasOwnProperty("a")&&(b=a.a)}b=parseFloat(b);if(isNaN(b)||0>b||1<b)b=1;return{ok:i,format:a.format||d,r:l(255,m(c.r,0)),g:l(255,m(c.g,0)),b:l(255,m(c.b,0)),a:b}}function B(a,c,b){var a=h(a,255),c=h(c,255),b=h(b,255),d=m(a,c,b),e=l(a,c,b),g,f=(d+e)/2;if(d==e)g=e=0;else{var k=d-e,e=0.5<f?k/(2-d-e):k/(d+e);switch(d){case a:g=(c-b)/k+(c<b?6:0);break;
case c:g=(b-a)/k+2;break;case b:g=(a-c)/k+4}g/=6}return{h:g,s:e,l:f}}function J(a,c,b){function d(a,b,c){0>c&&(c+=1);1<c&&(c-=1);return c<1/6?a+6*(b-a)*c:0.5>c?b:c<2/3?a+6*(b-a)*(2/3-c):a}a=h(a,360);c=h(c,100);b=h(b,100);if(0===c)b=c=a=b;else var e=0.5>b?b*(1+c):b+c-b*c,g=2*b-e,b=d(g,e,a+1/3),c=d(g,e,a),a=d(g,e,a-1/3);return{r:255*b,g:255*c,b:255*a}}function A(a,c,b){var a=h(a,255),c=h(c,255),b=h(b,255),d=m(a,c,b),e=l(a,c,b),g,f=d-e;if(d==e)g=0;else{switch(d){case a:g=(c-b)/f+(c<b?6:0);break;case c:g=
(b-a)/f+2;break;case b:g=(a-c)/f+4}g/=6}return{h:g,s:0===d?0:f/d,v:d}}function q(a,c,b){a=[o(e(a).toString(16)),o(e(c).toString(16)),o(e(b).toString(16))];return a[0][0]==a[0][1]&&a[1][0]==a[1][1]&&a[2][0]==a[2][1]?a[0][0]+a[1][0]+a[2][0]:a.join("")}function h(a,c){"string"==typeof a&&-1!=a.indexOf(".")&&1===parseFloat(a)&&(a="100%");var b="string"===typeof a&&-1!=a.indexOf("%"),a=l(c,m(0,parseFloat(a)));b&&(a=parseInt(a*c,10)/100);return 1.0E-6>n.abs(a-c)?1:a%c/parseFloat(c)}function o(a){return 1==
a.length?"0"+a:""+a}function p(a){1>=a&&(a=100*a+"%");return a}var H=/^[\s,#]+/,I=/\s+$/,F=0,n=Math,e=n.round,l=n.min,m=n.max,s=n.random;d.fromRatio=function(a){if("object"==typeof a){var c={},b;for(b in a)c[b]=p(a[b]);a=c}return d(a)};d.equals=function(a,c){return!a||!c?!1:d(a).toRgbString()==d(c).toRgbString()};d.random=function(){return d.fromRatio({r:s(),g:s(),b:s()})};d.desaturate=function(a,c){var b=d(a).toHsl();b.s-=(c||10)/100;b.s=l(1,m(0,b.s));return d(b)};d.saturate=function(a,c){var b=
d(a).toHsl();b.s+=(c||10)/100;b.s=l(1,m(0,b.s));return d(b)};d.greyscale=function(a){return d.desaturate(a,100)};d.lighten=function(a,c){var b=d(a).toHsl();b.l+=(c||10)/100;b.l=l(1,m(0,b.l));return d(b)};d.darken=function(a,c){var b=d(a).toHsl();b.l-=(c||10)/100;b.l=l(1,m(0,b.l));return d(b)};d.complement=function(a){a=d(a).toHsl();a.h=(a.h+180)%360;return d(a)};d.triad=function(a){var c=d(a).toHsl(),b=c.h;return[d(a),d({h:(b+120)%360,s:c.s,l:c.l}),d({h:(b+240)%360,s:c.s,l:c.l})]};d.tetrad=function(a){var c=
d(a).toHsl(),b=c.h;return[d(a),d({h:(b+90)%360,s:c.s,l:c.l}),d({h:(b+180)%360,s:c.s,l:c.l}),d({h:(b+270)%360,s:c.s,l:c.l})]};d.splitcomplement=function(a){var c=d(a).toHsl(),b=c.h;return[d(a),d({h:(b+72)%360,s:c.s,l:c.l}),d({h:(b+216)%360,s:c.s,l:c.l})]};d.analogous=function(a,c,b){var c=c||6,b=b||30,e=d(a).toHsl(),b=360/b,a=[d(a)];for(e.h=(e.h-(b*c>>1)+720)%360;--c;)e.h=(e.h+b)%360,a.push(d(e));return a};d.monochromatic=function(a,c){for(var c=c||6,b=d(a).toHsv(),e=b.h,h=b.s,b=b.v,g=[],f=1/c;c--;)g.push(d({h:e,
s:h,v:b})),b=(b+f)%1;return g};d.readable=function(a,c){var b=d(a).toRgb(),e=d(c).toRgb();return 10404<(e.r-b.r)*(e.r-b.r)+(e.g-b.g)*(e.g-b.g)+(e.b-b.b)*(e.b-b.b)};var r=d.names={aliceblue:"f0f8ff",antiquewhite:"faebd7",aqua:"0ff",aquamarine:"7fffd4",azure:"f0ffff",beige:"f5f5dc",bisque:"ffe4c4",black:"000",blanchedalmond:"ffebcd",blue:"00f",blueviolet:"8a2be2",brown:"a52a2a",burlywood:"deb887",burntsienna:"ea7e5d",cadetblue:"5f9ea0",chartreuse:"7fff00",chocolate:"d2691e",coral:"ff7f50",cornflowerblue:"6495ed",
cornsilk:"fff8dc",crimson:"dc143c",cyan:"0ff",darkblue:"00008b",darkcyan:"008b8b",darkgoldenrod:"b8860b",darkgray:"a9a9a9",darkgreen:"006400",darkgrey:"a9a9a9",darkkhaki:"bdb76b",darkmagenta:"8b008b",darkolivegreen:"556b2f",darkorange:"ff8c00",darkorchid:"9932cc",darkred:"8b0000",darksalmon:"e9967a",darkseagreen:"8fbc8f",darkslateblue:"483d8b",darkslategray:"2f4f4f",darkslategrey:"2f4f4f",darkturquoise:"00ced1",darkviolet:"9400d3",deeppink:"ff1493",deepskyblue:"00bfff",dimgray:"696969",dimgrey:"696969",
dodgerblue:"1e90ff",firebrick:"b22222",floralwhite:"fffaf0",forestgreen:"228b22",fuchsia:"f0f",gainsboro:"dcdcdc",ghostwhite:"f8f8ff",gold:"ffd700",goldenrod:"daa520",gray:"808080",green:"008000",greenyellow:"adff2f",grey:"808080",honeydew:"f0fff0",hotpink:"ff69b4",indianred:"cd5c5c",indigo:"4b0082",ivory:"fffff0",khaki:"f0e68c",lavender:"e6e6fa",lavenderblush:"fff0f5",lawngreen:"7cfc00",lemonchiffon:"fffacd",lightblue:"add8e6",lightcoral:"f08080",lightcyan:"e0ffff",lightgoldenrodyellow:"fafad2",
lightgray:"d3d3d3",lightgreen:"90ee90",lightgrey:"d3d3d3",lightpink:"ffb6c1",lightsalmon:"ffa07a",lightseagreen:"20b2aa",lightskyblue:"87cefa",lightslategray:"789",lightslategrey:"789",lightsteelblue:"b0c4de",lightyellow:"ffffe0",lime:"0f0",limegreen:"32cd32",linen:"faf0e6",magenta:"f0f",maroon:"800000",mediumaquamarine:"66cdaa",mediumblue:"0000cd",mediumorchid:"ba55d3",mediumpurple:"9370db",mediumseagreen:"3cb371",mediumslateblue:"7b68ee",mediumspringgreen:"00fa9a",mediumturquoise:"48d1cc",mediumvioletred:"c71585",
midnightblue:"191970",mintcream:"f5fffa",mistyrose:"ffe4e1",moccasin:"ffe4b5",navajowhite:"ffdead",navy:"000080",oldlace:"fdf5e6",olive:"808000",olivedrab:"6b8e23",orange:"ffa500",orangered:"ff4500",orchid:"da70d6",palegoldenrod:"eee8aa",palegreen:"98fb98",paleturquoise:"afeeee",palevioletred:"db7093",papayawhip:"ffefd5",peachpuff:"ffdab9",peru:"cd853f",pink:"ffc0cb",plum:"dda0dd",powderblue:"b0e0e6",purple:"800080",red:"f00",rosybrown:"bc8f8f",royalblue:"4169e1",saddlebrown:"8b4513",salmon:"fa8072",
sandybrown:"f4a460",seagreen:"2e8b57",seashell:"fff5ee",sienna:"a0522d",silver:"c0c0c0",skyblue:"87ceeb",slateblue:"6a5acd",slategray:"708090",slategrey:"708090",snow:"fffafa",springgreen:"00ff7f",steelblue:"4682b4",tan:"d2b48c",teal:"008080",thistle:"d8bfd8",tomato:"ff6347",turquoise:"40e0d0",violet:"ee82ee",wheat:"f5deb3",white:"fff",whitesmoke:"f5f5f5",yellow:"ff0",yellowgreen:"9acd32"},G=d.hexNames=function(a){var c={},b;for(b in a)a.hasOwnProperty(b)&&(c[a[b]]=b);return c}(r);t=RegExp("rgb[\\s|\\(]+((?:[-\\+]?\\d*\\.\\d+%?)|(?:[-\\+]?\\d+%?))[,|\\s]+((?:[-\\+]?\\d*\\.\\d+%?)|(?:[-\\+]?\\d+%?))[,|\\s]+((?:[-\\+]?\\d*\\.\\d+%?)|(?:[-\\+]?\\d+%?))\\s*\\)?");
u=RegExp("rgba[\\s|\\(]+((?:[-\\+]?\\d*\\.\\d+%?)|(?:[-\\+]?\\d+%?))[,|\\s]+((?:[-\\+]?\\d*\\.\\d+%?)|(?:[-\\+]?\\d+%?))[,|\\s]+((?:[-\\+]?\\d*\\.\\d+%?)|(?:[-\\+]?\\d+%?))[,|\\s]+((?:[-\\+]?\\d*\\.\\d+%?)|(?:[-\\+]?\\d+%?))\\s*\\)?");v=RegExp("hsl[\\s|\\(]+((?:[-\\+]?\\d*\\.\\d+%?)|(?:[-\\+]?\\d+%?))[,|\\s]+((?:[-\\+]?\\d*\\.\\d+%?)|(?:[-\\+]?\\d+%?))[,|\\s]+((?:[-\\+]?\\d*\\.\\d+%?)|(?:[-\\+]?\\d+%?))\\s*\\)?");w=RegExp("hsla[\\s|\\(]+((?:[-\\+]?\\d*\\.\\d+%?)|(?:[-\\+]?\\d+%?))[,|\\s]+((?:[-\\+]?\\d*\\.\\d+%?)|(?:[-\\+]?\\d+%?))[,|\\s]+((?:[-\\+]?\\d*\\.\\d+%?)|(?:[-\\+]?\\d+%?))[,|\\s]+((?:[-\\+]?\\d*\\.\\d+%?)|(?:[-\\+]?\\d+%?))\\s*\\)?");
x=RegExp("hsv[\\s|\\(]+((?:[-\\+]?\\d*\\.\\d+%?)|(?:[-\\+]?\\d+%?))[,|\\s]+((?:[-\\+]?\\d*\\.\\d+%?)|(?:[-\\+]?\\d+%?))[,|\\s]+((?:[-\\+]?\\d*\\.\\d+%?)|(?:[-\\+]?\\d+%?))\\s*\\)?");z=/^([0-9a-fA-F]{1})([0-9a-fA-F]{1})([0-9a-fA-F]{1})$/;y=/^([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})$/;"undefined"!==typeof module&&module.exports?module.exports=d:C.tinycolor=d})(this);
