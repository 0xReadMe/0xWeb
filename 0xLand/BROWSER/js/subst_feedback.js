var freeForm = new function(){
     this.flds = {};
     this.busy = false;
     
    this.flts = function(elem, nf){                   
        var str = elem.val();
            nf = nf ? 'flt_'+nf : 'flt_empty';
        
        var fex = {
            flt_email  : function(txt){return /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,6}$/gi.test(txt)},
            flt_empty  : function(txt) {return /\S/g.test(txt)}
        }
           
           if (nf != 'flt_nocheck') {
                var chk = fex[nf](str) ? 1 : 0;    
                if (!chk) {
                    var err = $('#trans_error').html();
                    elem.addClass('fail');
                    if (elem.next('div').length == 0)
                        ($('<div class="error">' + err + '</div>')).insertAfter(elem);
                } else {
                    elem.removeClass('fail');
                    if (elem.next('div').length > 0)
                         elem.next('div').detach();
                }
                    
           } else {
                chk = 1;
           }
            
            freeForm.flds[elem.attr('name')] = str;
        return chk;
    }
}