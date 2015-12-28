(function(a){var b=(a.browser.msie?"paste":"input")+".mask";var c=window.orientation!=undefined;a.mask={definitions:{9:"[0-9]",a:"[A-Za-z]","*":"[A-Za-z0-9]"}};a.fn.extend({caret:function(a,b){if(this.length==0){return}if(typeof a=="number"){b=typeof b=="number"?b:a;return this.each(function(){if(this.setSelectionRange){this.focus();this.setSelectionRange(a,b)}else{if(this.createTextRange){var c=this.createTextRange();c.collapse(true);c.moveEnd("character",b);c.moveStart("character",a);c.select()}}})}else{if(this[0].setSelectionRange){a=this[0].selectionStart;b=this[0].selectionEnd}else{if(document.selection&&document.selection.createRange){var c=document.selection.createRange();a=0-c.duplicate().moveStart("character",-1e5);b=a+c.text.length}}return{begin:a,end:b}}},unmask:function(){return this.trigger("unmask")},mask:function(g,h){if(!g&&this.length>0){var i=a(this[0]);var j=i.data("tests");return a.map(i.data("buffer"),function(a,b){return j[b]?a:null}).join("")}h=a.extend({placeholder:"_",completed:null},h);var k=a.mask.definitions;var j=[];var l=g.length;var m=null;var n=g.length;a.each(g.split(""),function(a,b){if(b=="?"){n--;l=a}else{if(k[b]){j.push(new RegExp(k[b]));if(m==null){m=j.length-1}}else{j.push(null)}}});return this.each(function(){function A(a){var b=i.val();var c=-1;for(var d=0,e=0;d<n;d++){if(j[d]){q[d]=h.placeholder;while(e++<b.length){var f=b.charAt(e-1);if(j[d].test(f)){q[d]=f;c=d;break}}if(e>b.length){break}}else{if(q[d]==b[e]&&d!=l){e++;c=d}}}if(!a&&c+1<l){i.val("");y(0,n)}else{if(a||c+1>=l){z();if(!a){i.val(i.val().substring(0,c+1))}}}return l?d:m}function z(){return i.val(q.join("")).val()}function y(a,b){for(var c=a;c<b&&c<n;c++){if(j[c]){q[c]=h.placeholder}}}function x(b){if(r){r=false;return b.keyCode==8?false:null}b=b||window.event;var c=b.charCode||b.keyCode||b.which;var d=a(this).caret();if(b.ctrlKey||b.altKey||b.metaKey){return true}else{if(c>=32&&c<=125||c>186){var f=t(d.begin-1);if(f<n){var g=String.fromCharCode(c);if(j[f].test(g)){v(f);q[f]=g;z();var k=t(f);a(this).caret(k);if(h.completed&&k==n){h.completed.call(i)}}}}}return false}function w(b){var f=a(this).caret();var g=b.keyCode;r=g<16||g>16&&g<32||g>32&&g<41;if(f.begin-f.end!=0&&(!r||g==8||g==46)){y(f.begin,f.end)}if(g==8||g==46||c&&g==127){u(f.begin+(g==46?0:-1));return false}else{if(g==27){i.val(s);i.caret(0,A());return false}}}function v(a){for(var b=a,c=h.placeholder;b<n;b++){if(j[b]){var d=t(b);var e=q[b];q[b]=c;if(d<n&&j[d].test(e)){c=e}else{break}}}}function u(a){while(!j[a]&&--a>=0){}for(var b=a;b<n;b++){if(j[b]){q[b]=h.placeholder;var c=t(b);if(c<n&&j[b].test(q[c])){q[b]=q[c]}else{break}}}z();i.caret(Math.max(m,a))}function t(a){while(++a<=n&&!j[a]){}return a}var i=a(this);var q=a.map(g.split(""),function(a,b){if(a!="?"){return k[a]?h.placeholder:a}});var r=false;var s=i.val();i.data("buffer",q).data("tests",j);if(!i.attr("readonly")){i.one("unmask",function(){i.unbind(".mask").removeData("buffer").removeData("tests")}).bind("focus.mask",function(){s=i.val();var a=A();z();setTimeout(function(){if(a==g.length){i.caret(0,a)}else{i.caret(a)}},0)}).bind("blur.mask",function(){A();if(i.val()!=s){i.change()}}).bind("keydown.mask",w).bind("keypress.mask",x).bind(b,function(){setTimeout(function(){i.caret(A(true))},0)})}A()})}})})(jQuery);(function(a){a.fn.maskMoney=function(b){b=a.extend({symbol:"R$",showSymbol:false,symbolStay:false,thousands:".",decimal:",",precision:2,defaultZero:true,allowZero:false,allowNegative:false},b);return this.each(function(){function m(a){if(b.allowNegative){var c=a.val();if(a.val()!=""&&a.val().charAt(0)=="-"){return a.val().replace("-","")}else{return"-"+a.val()}}else{return a.val()}}function l(a){if(b.showSymbol){if(a.substr(0,b.symbol.length)!=b.symbol)return b.symbol+a}return a}function k(){var a=parseFloat("0")/Math.pow(10,b.precision);return a.toFixed(b.precision).replace(new RegExp("\\.","g"),b.decimal)}function j(a){a=a.replace(b.symbol,"");var c="0123456789";var d=a.length;var e="",f="",g="";if(d!=0&&a.charAt(0)=="-"){a=a.replace("-","");if(b.allowNegative){g="-"}}if(d==0){if(!b.defaultZero)return f;f="0.00"}for(var h=0;h<d;h++){if(a.charAt(h)!="0"&&a.charAt(h)!=b.decimal)break}for(;h<d;h++){if(c.indexOf(a.charAt(h))!=-1)e+=a.charAt(h)}var i=parseFloat(e);i=isNaN(i)?0:i/Math.pow(10,b.precision);f=i.toFixed(b.precision);h=b.precision==0?0:1;var j,k=(f=f.split("."))[h].substr(0,b.precision);for(j=(f=f[0]).length;(j-=3)>=1;){f=f.substr(0,j)+b.thousands+f.substr(j)}return b.precision>0?l(g+f+b.decimal+k+Array(b.precision+1-k.length).join(0)):l(g+f)}function i(a,b){var d=c.val().length;c.val(j(a.value));var e=c.val().length;b=b-(d-e);c.setCursorPosition(b)}function h(a){if(a.preventDefault){a.preventDefault()}else{a.returnValue=false}}function g(e){if(a.browser.msie){d(e)}if(c.val()==""||c.val()==l(k())||c.val()==b.symbol){if(!b.allowZero)c.val("");else if(!b.symbolStay)c.val(k());else c.val(l(k()))}else{if(!b.symbolStay)c.val(c.val().replace(b.symbol,""));else if(b.symbolStay&&c.val()==b.symbol)c.val(l(k()))}}function f(a){var d=k();if(c.val()==d){c.val("")}else if(c.val()==""&&b.defaultZero){c.val(l(d))}else{c.val(l(c.val()))}if(this.createTextRange){var e=this.createTextRange();e.collapse(false);e.select()}}function e(a){a=a||window.event;var b=a.charCode||a.keyCode||a.which;if(b==undefined)return false;if(c.attr("readonly")&&b!=13&&b!=9)return false;var d=c.get(0);var e=c.getInputSelection(d);var f=e.start;var g=e.end;if(b==8){h(a);if(f==g){d.value=d.value.substring(0,f-1)+d.value.substring(g,d.value.length);f=f-1}else{d.value=d.value.substring(0,f)+d.value.substring(g,d.value.length)}i(d,f);return false}else if(b==9){return true}else if(b==46||b==63272){h(a);if(d.selectionStart==d.selectionEnd){d.value=d.value.substring(0,f)+d.value.substring(g+1,d.value.length)}else{d.value=d.value.substring(0,f)+d.value.substring(g,d.value.length)}i(d,f);return false}else{return true}}function d(a){a=a||window.event;var b=a.charCode||a.keyCode||a.which;if(b==undefined)return false;if(c.attr("readonly")&&b!=13&&b!=9)return false;if(b<48||b>57){if(b==45){c.val(m(c));return false}if(b==43){c.val(c.val().replace("-",""));return false}else if(b==13||b==9){return true}else if(b==37||b==39){return true}else{h(a);return true}}else if(c.val().length==c.attr("maxlength")){return false}else{h(a);var d=String.fromCharCode(b);var e=c.get(0);var f=c.getInputSelection(e);var g=f.start;var j=f.end;e.value=e.value.substring(0,g)+d+e.value.substring(j,e.value.length);i(e,g+1);return false}}var c=a(this);c.bind("keypress.maskMoney",d);c.bind("keydown.maskMoney",e);c.bind("blur.maskMoney",g);c.bind("focus.maskMoney",f);c.one("unmaskMoney",function(){c.unbind(".maskMoney");if(a.browser.msie){this.onpaste=null}else if(a.browser.mozilla){this.removeEventListener("input",g,false)}})})};a.fn.unmaskMoney=function(){return this.trigger("unmaskMoney")};a.fn.setCursorPosition=function(a){this.each(function(b,c){if(c.setSelectionRange){c.focus();c.setSelectionRange(a,a)}else if(c.createTextRange){var d=c.createTextRange();d.collapse(true);d.moveEnd("character",a);d.moveStart("character",a);d.select()}});return this};a.fn.getInputSelection=function(a){var b=0,c=0,d,e,f,g,h;if(typeof a.selectionStart=="number"&&typeof a.selectionEnd=="number"){b=a.selectionStart;c=a.selectionEnd}else{e=document.selection.createRange();if(e&&e.parentElement()==a){g=a.value.length;d=a.value.replace(/\r\n/g,"\n");f=a.createTextRange();f.moveToBookmark(e.getBookmark());h=a.createTextRange();h.collapse(false);if(f.compareEndPoints("StartToEnd",h)>-1){b=c=g}else{b=-f.moveStart("character",-g);b+=d.slice(0,b).split("\n").length-1;if(f.compareEndPoints("EndToEnd",h)>-1){c=g}else{c=-f.moveEnd("character",-g);c+=d.slice(0,c).split("\n").length-1}}}}return{start:b,end:c}}})(jQuery)