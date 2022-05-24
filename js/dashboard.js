(function ($) {

    let options = {
        chart: {
            type: "bar",
            height: 300,
            foreColor: "#8C87C2",
            fontFamily: 'Rubik, sans-serif',
            stacked: true,
            dropShadow: {
                enabled: true,
                enabledSeries: [0],
                top: -2,
                left: 2,
                blur: 5,
                opacity: 0.06
            },
            toolbar: {
                show: false,
            }
        },
        colors: ['#7B6FFF', '#1652F0'],
        stroke: {
            curve: "smooth",
            width: 3
        },
        dataLabels: {
            enabled: false
        },
        series: [{
            name: 'Affluence',
            data: tab_values_1,
        }],
        markers: {
            size: 0,
            strokeColor: "#fff",
            strokeWidth: 3,
            strokeOpacity: 1,
            fillOpacity: 1,
            hover: {
                size: 6
            }
        },
        xaxis: {
            categories:[
                "24",
                "01",
                "02",
                "03",
                "04",
                "05",
                "06",
                "07",
                "08",
                "09",
                "10",
                "11",
                "12",
                "13",
                "14",
                "15",
                "16",
                "17",
                "18",
                "19",
                "20",
                "21",
                "22",
                "23"
            ],

        },
        yaxis: {
            labels: {
                offsetX: -10,
                offsetY: 0
            },
            tooltip: {
                enabled: true,
            }
        },
        grid: {
            show: false,
            padding: {
                left: -5,
                right: 5
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'left'
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.5,
                opacityTo: 0,
                stops: [0, 100, 100]
            }
        },
    };

    let chart = new ApexCharts(
        document.querySelector("#timeline-chart"),
        options
    );

    chart.render();

    let resetCssClasses = function (activeEl) {
        $(".day").each(function() {
            this.classList.remove('active');
        });

        activeEl.target.classList.add('active');
    }

    document.querySelector("#lundi").addEventListener('click', function (e) {
        resetCssClasses(e)
        chart.updateSeries([{
            data: tab_values_1
        }])
        $('#pick_day').text(Math.max.apply(null, tab_values_1)+"%");
        //$('#hour_open').text(heureOuverture(tab_values_1));

    })

    document.querySelector("#mardi").addEventListener('click', function (e) {
        resetCssClasses(e);
        chart.updateSeries([{
            data: tab_values_2
        }]);
        $('#pick_day').text(Math.max.apply(null, tab_values_2)+"%");
    })

    document.querySelector("#mercredi").addEventListener('click', function (e) {
        resetCssClasses(e)
        chart.updateSeries([{
            data: tab_values_3
        }])
        $('#pick_day').text(Math.max.apply(null, tab_values_3)+"%");
    })

    document.querySelector("#jeudi").addEventListener('click', function (e) {
        resetCssClasses(e)
        chart.updateSeries([{
            data: tab_values_4
        }])
        $('#pick_day').text(Math.max.apply(null, tab_values_4)+"%");
    })

    document.querySelector("#vendredi").addEventListener('click', function (e) {
        resetCssClasses(e)
        chart.updateSeries([{
            data: tab_values_5
        }])
        $('#pick_day').text(Math.max.apply(null, tab_values_5)+"%");
    })

    document.querySelector("#samedi").addEventListener('click', function (e) {
        resetCssClasses(e)
        chart.updateSeries([{
            data: tab_values_6
        }])
        $('#pick_day').text(Math.max.apply(null, tab_values_6)+"%");
    })

    document.querySelector("#dimanche").addEventListener('click', function (e) {
        resetCssClasses(e)
        chart.updateSeries([{
            data: tab_values_7
        }])
        $('#pick_day').text(Math.max.apply(null, tab_values_7)+"%");
    })

    function heureOuverture(tab){
        let tab_index = [];
        tab_index.push(getAllIndexes(tab, 0));
        alert(tab_index);
        return Math.min.apply(null, tab_index)+"h-"+(Math.max.apply(null, tab_index)+1)+"h";
    }

    function getAllIndexes(arr, val) {
        let indexes = [], i;
        for(i = 0; i < arr.length; i++)
            if (arr[i] === val)
                indexes.push(i);
        return indexes;
    }


})(jQuery);