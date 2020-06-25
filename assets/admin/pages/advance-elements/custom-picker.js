"use strict";

$(document).ready(function() {
    $("#datetimepicker1").datetimepicker({
        icons: {
            time: "icofont icofont-clock-time",
            date: "icofont icofont-ui-calendar",
            up: "icofont icofont-rounded-up",
            down: "icofont icofont-rounded-down",
            next: "icofont icofont-rounded-right",
            previous: "icofont icofont-rounded-left"
        }
    });
    $("#datetimepicker2").datetimepicker({
        locale: "ru",
        icons: {
            time: "icofont icofont-clock-time",
            date: "icofont icofont-ui-calendar",
            up: "icofont icofont-rounded-up",
            down: "icofont icofont-rounded-down",
            next: "icofont icofont-rounded-right",
            previous: "icofont icofont-rounded-left"
        }
    });
    $("#datetimepicker3").datetimepicker({
        format: "LT",
        icons: {
            time: "icofont icofont-clock-time",
            date: "icofont icofont-ui-calendar",
            up: "icofont icofont-rounded-up",
            down: "icofont icofont-rounded-down",
            next: "icofont icofont-rounded-right",
            previous: "icofont icofont-rounded-left"
        }
    });
    $("#datetimepicker4").datetimepicker({
        icons: {
            time: "icofont icofont-clock-time",
            date: "icofont icofont-ui-calendar",
            up: "icofont icofont-rounded-up",
            down: "icofont icofont-rounded-down",
            next: "icofont icofont-rounded-right",
            previous: "icofont icofont-rounded-left"
        }
    });
    $("#datetimepicker5").datetimepicker({
        defaultDate: "11-1-2013",
        disabledDates: [ moment("12-25-2013", "MM-DD-YYYY"), new Date(2013, 11 - 1, 21), "11-22-2013 00:53" ],
        icons: {
            time: "icofont icofont-clock-time",
            date: "icofont icofont-ui-calendar",
            up: "icofont icofont-rounded-up",
            down: "icofont icofont-rounded-down",
            next: "icofont icofont-rounded-right",
            previous: "icofont icofont-rounded-left"
        }
    });
    $("#datetimepicker6").datetimepicker({
        icons: {
            time: "icofont icofont-clock-time",
            date: "icofont icofont-ui-calendar",
            up: "icofont icofont-rounded-up",
            down: "icofont icofont-rounded-down",
            next: "icofont icofont-rounded-right",
            previous: "icofont icofont-rounded-left"
        }
    });
    $("#datetimepicker7").datetimepicker({
        useCurrent: false,
        icons: {
            time: "icofont icofont-clock-time",
            date: "icofont icofont-ui-calendar",
            up: "icofont icofont-rounded-up",
            down: "icofont icofont-rounded-down",
            next: "icofont icofont-rounded-right",
            previous: "icofont icofont-rounded-left"
        }
    });
    $("#datetimepicker6").on("dp.change", function(a) {
        $("#datetimepicker7").data("DateTimePicker").minDate(a.date);
    });
    $("#datetimepicker7").on("dp.change", function(a) {
        $("#datetimepicker6").data("DateTimePicker").maxDate(a.date);
    });
    $("#datetimepicker8").datetimepicker({
        icons: {
            time: "icofont icofont-clock-time",
            date: "icofont icofont-ui-calendar",
            up: "icofont icofont-rounded-up",
            down: "icofont icofont-rounded-down"
        }
    });
    $("#datetimepicker9").datetimepicker({
        viewMode: "years",
        icons: {
            time: "icofont icofont-clock-time",
            date: "icofont icofont-ui-calendar",
            up: "icofont icofont-rounded-up",
            down: "icofont icofont-rounded-down",
            next: "icofont icofont-rounded-right",
            previous: "icofont icofont-rounded-left"
        }
    });
    $("#datetimepicker10").datetimepicker({
        viewMode: "years",
        format: "MM/YYYY",
        icons: {
            time: "icofont icofont-clock-time",
            date: "icofont icofont-ui-calendar",
            up: "icofont icofont-rounded-up",
            down: "icofont icofont-rounded-down",
            next: "icofont icofont-rounded-right",
            previous: "icofont icofont-rounded-left"
        }
    });
    $("#datetimepicker11").datetimepicker({
        daysOfWeekDisabled: [ 0, 6 ],
        icons: {
            time: "icofont icofont-clock-time",
            date: "icofont icofont-ui-calendar",
            up: "icofont icofont-rounded-up",
            down: "icofont icofont-rounded-down",
            next: "icofont icofont-rounded-right",
            previous: "icofont icofont-rounded-left"
        }
    });
    $('input[name="daterange"]').daterangepicker();
    $(function() {
        $('input[name="birthdate"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true
        }, function(a, b, c) {
            var d = moment().diff(a, "years");
            alert("You are " + d + " years old.");
        });
        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: "Clear"
            }
        });
        $('input[name="datefilter"]').on("apply.daterangepicker", function(a, b) {
            $(this).val(b.startDate.format("MM/DD/YYYY") + " - " + b.endDate.format("MM/DD/YYYY"));
        });
        $('input[name="datefilter"]').on("cancel.daterangepicker", function(a, b) {
            $(this).val("");
        });
        var a = moment().subtract(29, "days");
        var b = moment();
        function c(a, b) {
            $("#reportrange span").html(a.format("MMMM D, YYYY") + " - " + b.format("MMMM D, YYYY"));
        }
        $("#reportrange").daterangepicker({
            startDate: a,
            endDate: b,
            drops: "up",
            ranges: {
                Today: [ moment(), moment() ],
                Yesterday: [ moment().subtract(1, "days"), moment().subtract(1, "days") ],
                "Last 7 Days": [ moment().subtract(6, "days"), moment() ],
                "Last 30 Days": [ moment().subtract(29, "days"), moment() ],
                "This Month": [ moment().startOf("month"), moment().endOf("month") ],
                "Last Month": [ moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month") ]
            }
        }, c);
        c(a, b);
        $(".input-daterange input").each(function() {
            $(this).datepicker();
        });
        $("#sandbox-container .input-daterange").datepicker({
            todayHighlight: true
        });
        $(".input-group-date-custom").datepicker({
            todayBtn: true,
            clearBtn: true,
            keyboardNavigation: false,
            forceParse: false,
            todayHighlight: true,
            defaultViewDate: {
                year: "2017",
                month: "01",
                day: "01"
            }
        });
        $(".multiple-select").datepicker({
            todayBtn: true,
            clearBtn: true,
            multidate: true,
            keyboardNavigation: false,
            forceParse: false,
            todayHighlight: true,
            defaultViewDate: {
                year: "2017",
                month: "01",
                day: "01"
            }
        });
        $("#config-demo").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            timePicker: true,
            timePicker24Hour: true,
            timePickerSeconds: true,
            showCustomRangeLabel: false,
            alwaysShowCalendars: true,
            startDate: "11/30/2016",
            endDate: "12/06/2016",
            drops: "up"
        }, function(a, b, c) {
            console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
        });
    });
    $("#dropper-default").dateDropper({
		format:"d/m/Y",
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
		maxYear: "2020",
    }), $("#dropper-animation").dateDropper({
        dropWidth: 200,
        init_animation: "bounce",
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c"
    }), $("#dropper-format").dateDropper({
        dropWidth: 200,
        format: "F S, Y",
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c"
    }), $("#dropper-lang").dateDropper({
        dropWidth: 200,
        format: "F S, Y",
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        lang: "ar"
    }), $("#dropper-lock").dateDropper({
        dropWidth: 200,
        format: "F S, Y",
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        lock: "from"
    }), $("#dropper-max-year").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        maxYear: "2020"
    }), $("#dropper-min-year").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        minYear: "1990"
    }), $("#year-range").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        yearsRange: "5"
    }), $("#dropper-width").dateDropper({
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        dropWidth: 500
    }), $("#dropper-dangercolor").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#e74c3c",
        dropBorder: "1px solid #e74c3c"
    }), $("#dropper-backcolor").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        dropBackgroundColor: "#bdc3c7"
    }), $("#dropper-txtcolor").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#46627f",
        dropBorder: "1px solid #46627f",
        dropTextColor: "#FFF",
        dropBackgroundColor: "#e74c3c"
    }), $("#dropper-radius").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        dropBorderRadius: "0"
    }), $("#dropper-border").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "2px solid #1abc9c"
    }), $("#dropper-shadow").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        dropBorderRadius: "20px",
        dropShadow: "0 0 20px 0 rgba(26, 188, 156, 0.6)"
    });
    function a() {
        $(".color-box .show-box").on("click", function() {
            $(".color-box").toggleClass("open");
        });
        $(".colors-list a").on("click", function() {
            var a = $("main").data("checkbox-color");
            var b = $(this).data("checkbox-color");
            var c = "checkbox-" + b;
            $(".rkmd-checkbox .input-checkbox").each(function(b, d) {
                var e = $(this).hasClass(a);
                if (e) {
                    $(this).removeClass(a);
                    $(this).addClass(c);
                }
                $("main").data("checkbox-color", c);
            });
        });
    }
    $("#custom").spectrum({
        color: "#f00"
    });
    $("#flat").spectrum({
        flat: true,
        showInput: true
    });
    $("#flatClearable").spectrum({
        flat: true,
        showInput: true,
        allowEmpty: true
    });
    $(".demo").each(function() {
        $(this).minicolors({
            control: $(this).attr("data-control") || "hue",
            defaultValue: $(this).attr("data-defaultValue") || "",
            format: $(this).attr("data-format") || "hex",
            keywords: $(this).attr("data-keywords") || "",
            inline: "true" === $(this).attr("data-inline"),
            letterCase: $(this).attr("data-letterCase") || "lowercase",
            opacity: $(this).attr("data-opacity"),
            position: $(this).attr("data-position") || "bottom left",
            swatches: $(this).attr("data-swatches") ? $(this).attr("data-swatches").split("|") : [],
            change: function(a, b) {
                if (!a) return;
                if (b) a += ", " + b;
                if ("object" === typeof console) console.log(a);
            },
            theme: "bootstrap"
        });
    });
});