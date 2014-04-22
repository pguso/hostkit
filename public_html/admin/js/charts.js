$(document).ready(function () {

    if (typeof s1 != "undefined") {
        var plot3 = $.jqplot('support', [s1], {
            seriesDefaults: {
                // make this a donut chart.
                renderer: $.jqplot.DonutRenderer,
                rendererOptions: {
                    // Donut's can be cut into slices like pies.
                    sliceMargin: 3,
                    // Pies and donuts can start at any arbitrary angle.
                    startAngle: -90,
                    showDataLabels: true,
                    // By default, data labels show the percentage of the donut/pie.
                    // You can show the data 'value' or data 'label' instead.
                    dataLabels: 'value'
                }
            },
            legend: { show: true, location: 'e' },
            grid: {
                drawGridLines: false,        // wether to draw lines across the grid or not.
                gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
                background: '#fafafa',      // CSS color spec for background color of grid.
                borderColor: '#fff',     // CSS color spec for border around grid.
                borderWidth: 0,           // pixel width of border around grid.
                shadow: false,               // draw a shadow for grid.
                shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
                shadowOffset: 1.5,          // offset from the line of the shadow.
                shadowWidth: 0,             // width of the stroke for the shadow.
                shadowDepth: 0
            }
        });
    }

    if (typeof s2 != "undefined") {
        var plot3 = $.jqplot('client', [s2], {
            seriesDefaults: {
                // make this a donut chart.
                renderer: $.jqplot.DonutRenderer,
                rendererOptions: {
                    // Donut's can be cut into slices like pies.
                    sliceMargin: 3,
                    // Pies and donuts can start at any arbitrary angle.
                    startAngle: -90,
                    showDataLabels: true,
                    // By default, data labels show the percentage of the donut/pie.
                    // You can show the data 'value' or data 'label' instead.
                    dataLabels: 'value'
                }
            },
            legend: { show: true, location: 'e' },
            grid: {
                drawGridLines: false,        // wether to draw lines across the grid or not.
                gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
                background: '#fafafa',      // CSS color spec for background color of grid.
                borderColor: '#fff',     // CSS color spec for border around grid.
                borderWidth: 0,           // pixel width of border around grid.
                shadow: false,               // draw a shadow for grid.
                shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
                shadowOffset: 1.5,          // offset from the line of the shadow.
                shadowWidth: 0,             // width of the stroke for the shadow.
                shadowDepth: 0
            }
        });
    }

    if (typeof line != "undefined") {
        //var line1=[['02',4], ['03',6.5], ['01',5.7], ['06',9], ['04',8.2]];
        var plot1 = $.jqplot('sales', [line], {
            axes: {xaxis: {renderer: $.jqplot.DateAxisRenderer}},
            series: [
                {lineWidth: 4, markerOptions: {style: 'filledCircle'}}
            ],
            grid: {
                drawGridLines: false,        // wether to draw lines across the grid or not.
                gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
                background: '#fff',      // CSS color spec for background color of grid.
                borderColor: '#fff',     // CSS color spec for border around grid.
                borderWidth: 0,           // pixel width of border around grid.
                shadow: false,               // draw a shadow for grid.
                shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
                shadowOffset: 1.5,          // offset from the line of the shadow.
                shadowWidth: 0,             // width of the stroke for the shadow.
                shadowDepth: 0
            },
            highlighter: {
                show: true,
                sizeAdjust: 7.5
            }
        });
    }


    if (typeof income != "undefined") {
        $.jqplot('income', income, {
            seriesDefaults: {
                renderer: $.jqplot.BarRenderer,
                // Show point labels to the right ('e'ast) of each bar.
                // edgeTolerance of -15 allows labels flow outside the grid
                // up to 15 pixels.  If they flow out more than that, they
                // will be hidden.
                pointLabels: { show: true, location: 'e', edgeTolerance: -15 },
                // Rotate the bar shadow as if bar is lit from top right.
                shadowAngle: 135,
                // Here's where we tell the chart it is oriented horizontally.
                rendererOptions: {
                    barDirection: 'horizontal'
                }
            },
            grid: {
                drawGridLines: false,        // wether to draw lines across the grid or not.
                gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
                background: '#fff',      // CSS color spec for background color of grid.
                borderColor: '#fff',     // CSS color spec for border around grid.
                borderWidth: 0,           // pixel width of border around grid.
                shadow: false,               // draw a shadow for grid.
                shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
                shadowOffset: 1.5,          // offset from the line of the shadow.
                shadowWidth: 0,             // width of the stroke for the shadow.
                shadowDepth: 0
            },
            series:[
                {label:'Total Sales'},
                {label:'Today Sales'},
                {label:'Unpaid Invoices'},
                {label:'This Month Sales'}
            ],
            legend: {
                show: true,
                placement: 'outsideGrid'
            },
            axes: {
                yaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer
                },
                xaxis: {
                    pad: 0,
                    tickOptions: {formatString: '$%d'}
                }
            }
        });
    }
});

