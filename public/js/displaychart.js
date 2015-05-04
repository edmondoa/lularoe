(function(app, push, check, ctrlpad){
$(function () {
    var ordersReport = function(title, subtitle, ytitle, data, categories, tilt){
        var rotate = (tilt) ? -45 : 0;
        $('#container').highcharts({
            title: {
                text: title
            },
            subtitle: {
                text: subtitle
            },
            xAxis: {
                categories: categories,
                labels:{
                    rotation: rotate
                }
            },
            yAxis: {
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }],
                min: 0,
                title: ytitle
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            tooltip: {
                formatter: function() {
                    var name = this.series.name;

                    var txt = '<b>'+ this.x +'</b> <br/>';
                        txt += name +': <b>';
                        txt += this.y+'</b><br/>';
                        txt += "Payment Method: <b>"+"Cash"+"</b><br/>";
                        txt += "Total Amount"+": <b>"+this.total+"</b>";
                        return txt;
                }
            },
            series: data
        });
     };
    
     var loadchart = function(option, m, d){
         var path = ctrlpad.reportsCtrl.path + option;
         path += (m != false) ? "?m="+m : "";
         path += (d != false) ? "?d="+d : "";
         $.get(path,function(data){
             var rotatexlabel = (data.xorientation == "rotate") ? true : false;
             ordersReport(ctrlpad.reportsCtrl.title, data.subtitle, ctrlpad.reportsCtrl.ytitle, data.data, data.categories, rotatexlabel);
         });
     };
     
     loadchart('monthly', false, false);
     
     $('body').delegate('#view_selector', 'change', function(){
         var $_selector = $(this);
         var $_selectMonth = $('#select_month');
         var $_selectDate = $('#select_date');
         var selected = $_selector.val();
         if(selected == "ytd" || selected == "daily"){
             $_selectMonth.hide();
         }else{
             $_selectMonth.show();
         }
         if(selected == "daily"){
             $_selectDate.show();    
         }else{
             $_selectDate.hide();   
         }
         loadchart(selected, false, false);
    });
    
    $('body').delegate('#month_selector', 'change', function(){
         var $_selector = $(this);
         var view_selector = $('#view_selector');
         var selected = $_selector.val();
         console.log('selected');
         console.log(selected);
         console.log($_selector);
         loadchart(view_selector.val(), selected, false);
    });
        
    $('body').delegate('.collapse', 'shown.bs.collapse', function(){
        var target = '#'+$(this).attr('data-parent');
        $(target).addClass('collapse-open');   
    });
     
});

}(module, pushIfNotFound, checkExists, ControlPad));