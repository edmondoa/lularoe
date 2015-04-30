(function(app, push, check, ctrlpad){
$(function () {
    var ordersReport = function(title, subtitle, data, categories, tilt){
        var rotate = (tilt) ? -45 : 0;
        $('#container').highcharts({
            title: {
                text: title,
                x: -20 //center
            },
            subtitle: {
                text: subtitle,
                x: -20
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
                min: 0
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0,
                enabled: false
            },
            tooltip: {
                formatter: function() {
                    var name = this.series.name;

                    var txt = '<b>'+ this.x +'</b> <br/>';
                        txt += name +' Count: <b>';
                        txt += this.y+'</b><br/>';
                        txt += "Payment Method: <b>"+"Cash"+"</b><br/>";
                        txt += "Total Amount"+": <b>"+this.total+"</b>";
                        return txt;
                }
            },
            series: data
        });
     };
    
     var loadchart = function(option){
         $.get(ctrlpad.reportsCtrl.path + option,function(data){
             var rotatexlabel = (data.xorientation == "rotate") ? true : false;
             ordersReport(ctrlpad.reportsCtrl.title, data.subtitle, data.data, data.categories, rotatexlabel);
         });
     };
     
     loadchart('monthly');
     
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
         loadchart(selected);
    });
    
    $('body').delegate('#select_month', 'change', function(){
         var $_selector = $(this);
         var $_selectMonth = $('#select_month');
         var selected = $_selector.val();
         if(selected == "ytd" || selected == "daily"){
             $_selectMonth.hide();
         }else{
             $_selectMonth.show();
         }
         loadchart(selected);
    });
     
     
});

}(module, pushIfNotFound, checkExists, ControlPad));