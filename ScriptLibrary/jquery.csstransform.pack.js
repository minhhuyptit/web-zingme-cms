/*
 Universal CSS Transforms
 Version: 1.6.0
 (c) 2013 DMXzone.com
 @build 14-02-2013 14:13:33
*/
(function(e){function d(a,b,c,e,l,d){6==arguments.length&&(this.a=a,this.b=b,this.c=c,this.d=e,this.tx=l,this.ty=d)}function g(a,b){var c=parseFloat(a);return"NaN"==c+""||"Infinity"==c+""||"-Infinity"==c+""?void 0===b?0:b:c}function k(a){if(!a||!(a in h))throw'Invalid transformation type "'+a+'"';this.type=a;this.args=[].concat(k.defaultArgs[a])}function f(a){this._stack=[];this._stackIndex={};this.element=a||null}function j(a){this.element=a||null;this.origStyle=null;this.origState={};this.wrapper=
null;this._stack=[];this._stackIndex={};this.filterReg=/(progid:DXImageTransform\.Microsoft\.)?Matrix\s*\([^\)]*\)/i}var h={matrix:"",rotate:"deg",scale:"",scaleX:"",scaleY:"",skew:"deg",skewX:"deg",skewY:"deg",translate:"px",translateX:"px",translateY:"px",transform:""};e.versionCompare=function(a){for(var a=String(a).split("."),b=e.prototype.jquery.split("."),c=0;c<Math.max(b.length,a.length);c++){void 0===a[c]&&(a[c]=0);void 0===b[c]&&(b[c]=0);if(parseFloat(a[c])>parseFloat(b[c]))return 1;if(parseFloat(a[c])<
parseFloat(b[c]))return-1}return 0};e.versionGTE=function(a){return 0>=e.versionCompare(a)};e.versionLTE=function(a){return 0<=e.versionCompare(a)};var i=document.createElement("div");e.support.transform=void 0!==i.style.transform?"transform":void 0!==i.style["-ms-transform"]?"-ms-transform":void 0!==i.style.MozTransform?"MozTransform":void 0!==i.style.WebkitTransform?"WebkitTransform":void 0!==i.style.OTransform?"OTransform":void 0!==i.style.KhtmlTransform?"KhtmlTransform":!1;e.cssHooks||(e.cssHooks=
{});e.cssHooks.multipliedMatrix={get:function(a){return f.getInstance(a).get("multipliedMatrix")}};e.each(h,function(a,b){e.cssHooks[a]={set:function(b,e){f.getInstance(b).set(a,e).paint()},get:function(b){return f.getInstance(b).get(a)}};a!="matrix"&&(e.fx.step[a]=function(c){c.unit=b;f.getInstance(c.elem).set(a,c.now).paint()})});if(e.versionLTE("1.4.2")){var m=jQuery.curCSS;jQuery.curCSS=function(a,b,c){var d=e.cssHooks[b]?e.cssHooks[b].get:null;return b in h&&d?d(a):m.apply(jQuery,arguments)};
var n=e.fn.css;e.fn.css=function(a,b){if(typeof a=="string"){if(b!==void 0){var c=e.cssHooks[a]?e.cssHooks[a].set:null;if(a in h&&c)return this.each(function(d){c(this,e.isFunction(b)?b(d,e(this).css(a)):b)})}}else this.each(function(b){var c,d,f;for(c in a){d=e.cssHooks[c]?e.cssHooks[c].set:null;if(c in h&&d){f=a[c];e.isFunction(f)&&(f=f(b,e(this).css(c)));d(this,f)}}});return n.apply(this,arguments)}}var o=e.fx.prototype.cur;e.fx.prototype.cur=function(){var a=e.cssHooks[this.prop]?e.cssHooks[this.prop].get:
null;return this.prop in h&&a?parseFloat(String(a(this.elem)).replace(/^[^\d-\.\+]*/,"")):o.apply(this,arguments)};d.prototype={a:1,b:0,c:0,d:1,tx:0,ty:0};d.prototype.multiply=function(a){var b=this.a,c=this.b,e=this.c,d=this.d,f=this.tx,g=this.ty;this.a=b*a.a+c*a.c;this.b=b*a.b+c*a.d;this.c=e*a.a+d*a.c;this.d=e*a.b+d*a.d;this.tx=f*a.a+g*a.c+a.tx;this.ty=f*a.b+g*a.d+a.ty;return this};d.prototype.toString=function(){return this.a+", "+this.b+", "+this.c+", "+this.d+", "+this.tx+", "+this.ty};d.prototype.isIdentity=
function(){return this.a===1&&this.b===0&&this.c===0&&this.d===1&&this.tx===0&&this.ty===0};d.rotate=function(a){var b=Math.PI/180*g(a),a=Math.cos(b),b=Math.sin(b);return new d(a,b,-b,a,0,0)};d.scale=function(a,b){a=g(a,1);b=g(b,a);return new d(a,0,0,b,0,0)};d.scaleX=function(a){return new d(g(a,1),0,0,1,0,0)};d.scaleY=function(a){return new d(1,0,0,g(a,1),0,0)};d.translate=function(a,b){return new d(1,0,0,1,g(a),g(b))};d.translateX=function(a){return new d(1,0,0,1,g(a),0)};d.translateY=function(a){return new d(1,
0,0,1,0,g(a))};d.skew=function(a,b){return new d(1,Math.tan(g(b)*(Math.PI/180)),Math.tan(g(a)*(Math.PI/180)),1,0,0)};d.skewX=function(a){return new d(1,0,Math.tan(g(a)*(Math.PI/180)),1,0,0)};d.skewY=function(a){return new d(1,Math.tan(g(a)*(Math.PI/180)),0,1,0,0)};d.matrix=function(a,b,c,e,f,g){return new d(a,b,c,e,f,g)};k.prototype={toString:function(){return this.type+(this.type=="matrix"?"("+this.getMatrix()+")":"("+this.args.join(h[this.type]+", ")+h[this.type]+")")},init:function(){this.args=
[];var a=arguments.length;if(a>0){var b;for(b=0;b<a;b++)this.args.push(arguments[b])}return this},getMatrix:function(){return d[this.type].apply(d,this.args)}};k.defaultArgs={matrix:[1,0,0,1,0,0],rotate:[0],scale:[1,1],scaleX:[1],scaleY:[1],skew:[0,0],skewX:[0],skewY:[0],translate:[0,0],translateX:[0],translateY:[0]};f.prototype._defaultValues={matrix:[1,0,0,1,0,0],rotate:["0deg"],scale:[1,1],scaleX:[1],scaleY:[1],skew:["0deg","0deg"],skewX:["0deg"],skewY:["0deg"],translate:["0px","0px"],translateX:["0px"],
translateY:["0px"]};f.prototype.empty=function(){this._stack=[];this._stackIndex={};return this};f.prototype.isEmpty=function(){return this._stack.length===0};f.prototype.get=function(a){return!a||a=="transform"?this.toString():a=="multipliedMatrix"?"matrix("+this.getMatrix()+")":this._stackIndex[a]!==void 0?this._stack[this._stackIndex[a]].args.join(","):this._defaultValues[a].join(",")};f.prototype.toString=function(){for(var a=[],b=this._stack.length;b;)a.unshift(this._stack[--b].toString());return a.join(" ")||
"none"};f.prototype.getMatrix=function(){for(var a=new d,b=this._stack.length;b;)a.multiply(this._stack[--b].getMatrix());return a};f.prototype.getCSS=function(){return this.toString()};f.prototype.setCSS=function(a){this.empty();var b=/^(\w+)\(([\d\w,-\.]+)$/i;if((a=String(a||""))&&a!="none"){a=a.replace(/\s+/g,"").split(")");if(a.length>0)for(var c,e,d=0;d<a.length;d++)if(a[d])if(c=b.exec(a[d])){e=c[1];h[e]&&this.set(e,c[2])}}return this};f.prototype.set=function(a,b){if(a)if(a=="transform")this.setCSS(b);
else if(a!="none"){for(var c=e.isArray(b)?b:typeof b=="string"?b.split(/,/):[b],d=[],f=c.length,g,h,i,j;f;){g=c[--f];this._stackIndex[a]===void 0&&(this._stackIndex[a]=this._stack.push(new k(a))-1);j=this._stack[this._stackIndex[a]];i=parseFloat(j.args[f]);g=e.trim(String(g));if(h=g.replace(/\s/g,"").match(/^(([\+-]=)?(-?\d+(\.\d+)?)).*$/)){h[3]&&(g=parseFloat(h[3]));if(h[2])switch(h[2]){case "+=":g=i+g;break;case "-=":g=i-g}}isNaN(g)||d.unshift(g)}j.args=d}return this};f.prototype.paint=function(){this.element.style[e.support.transform]=
this.toString();return this};f.factory=function(a){return!e.support.transform&&f.isFilterSupported()?new j(a):new f(a)};f.getInstance=function(a){if(!a.transformManager)a.transformManager=f.factory(a);return a.transformManager};f.isFilterSupported=function(){var a=document.getElementsByTagName("body")[0].filters,b=a&&typeof a=="object"&&!window.opera;f.isFilterSupported=function(){return b};return b};j.prototype=new f;j.prototype.paint=function(){this.origStyle||this.initTransform();var a=this.getMatrix();
if(a.isIdentity())this.uninitTransform();else{var b=Math.abs(a.b-a.c);if(b>100)a.b=a.b*(b/100);var b=this.element.style,c=b.filter||"",d="";if(a.a!==1||a.b!==0||a.c!==0||a.d!==1)d="progid:DXImageTransform.Microsoft.Matrix(M11="+a.a+",M12="+a.c+",M21="+a.b+",M22="+a.d+",sizingMethod='auto expand',FilterType='nearest neighbor')";if(this.filterReg.test(c))b.filter=c.replace(this.filterReg,d);else if(d)b.filter=d+" "+b.filter;b.top=(this.origState.height-e(this.element).height())/2+a.ty+this.origState.top+
"px";b.left=(this.origState.width-e(this.element).width())/2+a.tx+this.origState.left+"px"}return this};j.prototype.initTransform=function(){function a(){if(!d.origStyle)d.origStyle={};for(var a=0;a<arguments.length;a++)d.origStyle[arguments[a]]=c.css(arguments[a])}function b(){var a=c.css("float");a=="none"&&(a=c.attr("align"));a!="left"&&a!="right"&&(a="none");return a}var c=e(this.element),d=this;this.origState={width:c.width(),height:c.height(),top:0,left:0};switch(c.css("position")){case "absolute":this.origState.top=
c.position().top;this.origState.left=c.position().left;a("width","height","top","left");c.css({width:this.origState.width,height:this.origState.height,top:this.origState.top,left:this.origState.left});break;case "fixed":this.origState.top=c.offset().top;this.origState.left=c.offset().left;a("width","height","top","left");c.css({width:this.origState.width,height:this.origState.height,top:this.origState.top,left:this.origState.left});break;case "relative":this.origState.top=parseFloat(c.css("top"));
this.origState.left=parseFloat(c.css("left"));if(isNaN(this.origState.top))this.origState.top=0;if(isNaN(this.origState.left))this.origState.left=0;a("width","height","top","left","position");c.css({width:this.origState.width,height:this.origState.height,top:this.origState.top,left:this.origState.left,position:"absolute"});if(!this.wrapper){c.wrap('<span class="dmx-filter-transform-wrapper" />');this.wrapper=c.parent().css({display:c.css("display")=="block"?"block":"inline-block",position:"relative",
"float":b(),width:c.outerWidth({margin:true}),height:c.outerHeight({margin:true})})}break;default:this.origState.top=0;this.origState.left=0;a("width","height","top","left","position","filter");c.css({width:this.origState.width,height:this.origState.height,top:this.origState.top,left:this.origState.left,position:"absolute"});if(!this.wrapper){c.wrap('<span class="dmx-filter-transform-wrapper" />');this.wrapper=c.parent().css({display:c.css("display")=="block"?"block":"inline-block",position:"relative",
"float":b(),width:c.outerWidth({margin:true}),height:c.outerHeight({margin:true})})}}};j.prototype.uninitTransform=function(){this.origState={};if(this.origStyle){e(this.element).css(this.origStyle);this.origStyle=null}if(this.wrapper){this.wrapper.before(e(this.element));this.wrapper.remove();this.wrapper=null}}})(jQuery);
