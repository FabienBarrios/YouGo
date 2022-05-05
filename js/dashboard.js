(function ($) {

    var options = {
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
            data: generateDayWiseTimeSeries(),
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
                "23",
                "24"
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

    var chart = new ApexCharts(
        document.querySelector("#timeline-chart"),
        options
    );

    chart.render();

    var resetCssClasses = function (activeEl) {
        var els = document.querySelectorAll("button");
        Array.prototype.forEach.call(els, function (el) {
            el.classList.remove('active');
        });
        activeEl.target.classList.add('active')
    }

    document.querySelector("#lundi").addEventListener('click', function (e) {
        resetCssClasses(e)
        chart.updateOptions({
            xaxis: {
                min: new Date('2 May 2022').getTime(),
                max: new Date('2 May 2022').getTime(),
            }
        })
    })

    document.querySelector("#mardi").addEventListener('click', function (e) {
        resetCssClasses(e);
    })

    function generateDayWiseTimeSeries(s, count) {
        var values = [0, 0, 0, 25, 35, 15, 35, 50, 90, 80, 30, 20, 0, 0, 0, 25, 35, 15, 35, 50, 75, 80, 30, 20];
        return values;
    }


})(jQuery); 