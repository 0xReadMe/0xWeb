!function(e){e.fn.scrollbox=function(t){var i={linear:!1,startDelay:2,delay:3,step:5,speed:32,switchItems:1,direction:"vertical",distance:"auto",autoPlay:!0,onMouseOverPause:!0,paused:!1,queue:null,listElement:"ul",listItemElement:"li",infiniteLoop:!0,switchAmount:0,afterForward:null,afterBackward:null,triggerStackable:!1};return t=e.extend(i,t),t.scrollOffset="vertical"===t.direction?"scrollTop":"scrollLeft",t.queue&&(t.queue=e("#"+t.queue)),this.each(function(){var i,n,l,r,a,s,c,o,u,f=e(this),d=null,m=null,h=!1,p=0,I=0;t.onMouseOverPause&&(f.bind("mouseover",function(){h=!0}),f.bind("mouseout",function(){h=!1})),i=f.children(t.listElement+":first-child"),!1===t.infiniteLoop&&0===t.switchAmount&&(t.switchAmount=i.children().length),s=function(){if(!h){var l,a,s,c,o;if(l=i.children(t.listItemElement+":first-child"),c="auto"!==t.distance?t.distance:"vertical"===t.direction?l.outerHeight(!0):l.outerWidth(!0),t.linear?s=Math.min(f[0][t.scrollOffset]+t.step,c):(o=Math.max(3,parseInt(.3*(c-f[0][t.scrollOffset]),10)),s=Math.min(f[0][t.scrollOffset]+o,c)),f[0][t.scrollOffset]=s,s>=c){for(a=0;a<t.switchItems;a++)t.queue&&t.queue.find(t.listItemElement).length>0?(i.append(t.queue.find(t.listItemElement)[0]),i.children(t.listItemElement+":first-child").remove()):i.append(i.children(t.listItemElement+":first-child")),++p;if(f[0][t.scrollOffset]=0,clearInterval(d),d=null,e.isFunction(t.afterForward)&&t.afterForward.call(f,{switchCount:p,currentFirstChild:i.children(t.listItemElement+":first-child")}),t.triggerStackable&&0!==I)return void n();if(!1===t.infiniteLoop&&p>=t.switchAmount)return;t.autoPlay&&(m=setTimeout(r,1e3*t.delay))}}},c=function(){if(!h){var l,a,s,c,o;if(0===f[0][t.scrollOffset]){for(a=0;a<t.switchItems;a++)i.children(t.listItemElement+":last-child").insertBefore(i.children(t.listItemElement+":first-child"));l=i.children(t.listItemElement+":first-child"),c="auto"!==t.distance?t.distance:"vertical"===t.direction?l.height():l.width(),f[0][t.scrollOffset]=c}if(t.linear?s=Math.max(f[0][t.scrollOffset]-t.step,0):(o=Math.max(3,parseInt(.3*f[0][t.scrollOffset],10)),s=Math.max(f[0][t.scrollOffset]-o,0)),f[0][t.scrollOffset]=s,0===s){if(--p,clearInterval(d),d=null,e.isFunction(t.afterBackward)&&t.afterBackward.call(f,{switchCount:p,currentFirstChild:i.children(t.listItemElement+":first-child")}),t.triggerStackable&&0!==I)return void n();t.autoPlay&&(m=setTimeout(r,1e3*t.delay))}}},n=function(){0!==I&&(I>0?(I--,m=setTimeout(r,0)):(I++,m=setTimeout(l,0)))},r=function(){clearInterval(d),d=setInterval(s,t.speed)},l=function(){clearInterval(d),d=setInterval(c,t.speed)},o=function(){t.autoPlay=!0,h=!1,clearInterval(d),d=setInterval(s,t.speed)},u=function(){h=!0},a=function(e){t.delay=e||t.delay,clearTimeout(m),t.autoPlay&&(m=setTimeout(r,1e3*t.delay))},t.autoPlay&&(m=setTimeout(r,1e3*t.startDelay)),f.bind("resetClock",function(e){a(e)}),f.bind("forward",function(){t.triggerStackable?null!==d?I++:r():(clearTimeout(m),r())}),f.bind("backward",function(){t.triggerStackable?null!==d?I--:l():(clearTimeout(m),l())}),f.bind("pauseHover",function(){u()}),f.bind("forwardHover",function(){o()}),f.bind("speedUp",function(e,i){"undefined"===i&&(i=Math.max(1,parseInt(t.speed/2,10))),t.speed=i}),f.bind("speedDown",function(e,i){"undefined"===i&&(i=2*t.speed),t.speed=i}),f.bind("updateConfig",function(i,n){t=e.extend(t,n)})})}}(jQuery);