//var time = $('#deal_time').val();
//var austDay = new Date(time);
//$('#countdown_here').countdown({until: austDay, compact: true, description: ''});


$('#countdown_here').ClassyCountdown({
    end:  $('#deal_time').val(),
    now:  $('#now_time').val(),
    labels: true,
    labelsOptions: {
        lang: {
            days: 'Ngày',
            hours: 'Giờ',
            minutes: 'Phút',
            seconds: 'Giây'
        },
        style: 'font-size: 12px; text-;'
    },
    style: {
        element: "",
        textResponsive: .5,
        days: {
            gauge: {
                thickness: .01,
                bgColor: "rgba(0,0,0,0.05)",
                fgColor: "#d80000"
            },
            textCSS: 'font-family:\'Open Sans\'; font-size:25px; font-weight:500; color:rgb(105, 104, 104);'
        },
        hours: {
            gauge: {
                thickness: .01,
                bgColor: "rgba(0,0,0,0.05)",
                fgColor: "#FF1919"
            },
            textCSS: 'font-family:\'Open Sans\'; font-size:25px;font-weight:500; color:rgb(105, 104, 104);'
        },
        minutes: {
            gauge: {
                thickness: .01,
                bgColor: "rgba(0,0,0,0.05)",
                fgColor: "#FF1919"
            },
            textCSS: 'font-family:\'Open Sans\'; font-size:25px; font-weight:500; color:rgb(105, 104, 104);'
        },
        seconds: {
            gauge: {
                thickness: .01,
                bgColor: "rgba(0,0,0,0.05)",
                fgColor: "#FF1919",
                lineCap: 'round'
            },
            textCSS: 'font-family:\'Open Sans\'; font-size:25px; font-weight:500; color:rgb(105, 104, 104);'
        }

    },
    onEndCallback: function() {
        console.log("Time out!");
    }
});
