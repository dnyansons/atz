<?php $this->load->view("user/common/header"); ?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                     <?php echo $this->session->flashdata("message"); ?>
				
					<?php if($seller_pickup_details ==""){?>
                    <div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Reminder!</strong> Please Fill Up The Details of Your Pick Up Address.
                    </div>    
                    <?php } ?>
					
					<?php if($bank_details ==""){?>
                    <div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Reminder!</strong> Please Fill Up Your Bank Details.
                    </div>    
                    <?php } ?>
					
                    <?php if($user_info->approved_status !="Approved"){?>
                    <div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Reminder!</strong> Please complete your company profile and fill up your bank details for approval.
                    </div>    
                    <?php } ?>
                    <!--<div class="alert alert-success alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Alert!</strong> You have currently opted <?php echo strtoupper($join_package); ?> plan. 
                        To upgrade or renew please visit <a target="_blank" href="<?php echo site_url();?>supplier_membership">Membership</a> section.
                    </div>-->
                    
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-yellow update-card">
                                <a href="<?php echo base_url(); ?>seller/orders"><div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-8">
                                            <h4 class="text-white"><?php echo number_format($tot_order); ?></h4>
                                            <h6 class="text-white m-b-0">Total Order</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <canvas id="update-chart-1" height="50"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>Today`s Order</p>
                                </div></a>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-green update-card">
                                <a href="<?php echo base_url(); ?>seller/report/sale_report"><div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-8">
                                            <h4 class="text-white"><?php echo number_format($tot_sale,2); ?></h4>
                                            <h6 class="text-white m-b-0">Total Sale In <?php echo $currency; ?> </h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <canvas id="update-chart-2" height="50"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>Today`s Sale</p>
                                </div></a>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-pink update-card">
                                <div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-8">
                                            <h4 class="text-white"><?php echo $tot_customer; ?></h4>
                                            <h6 class="text-white m-b-0">Total Customers</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <canvas id="update-chart-3" height="50"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>ATZ Cart</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-lite-green update-card">
                               <a href="<?php echo base_url();?>seller/products"> <div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-8">
                                            <h4 class="text-white"><?php echo $approved_count;?></h4>
                                            <h6 class="text-white m-b-0">Approved Products</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <canvas id="update-chart-4" height="50"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>ATZ Cart</p>
                                </div></a>
                            </div>
                        </div>
                        <!----------------------------------------------------------------->
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-yellow update-card">
                                <div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-8">
                                            <h4 class="text-white"><?php echo $wallet['available_balance']; ?></h4>
                                            <h6 class="text-white m-b-0">Available Balance</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <canvas id="update-chart-1" height="50"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>Payment's Not Yet Settled</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-green update-card">
                                <div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-8">
                                            <h4 class="text-white"><?php echo $wallet['pending_balance']; ?></h4>
                                            <h6 class="text-white m-b-0">Pending Balance</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <canvas id="update-chart-2" height="50"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>Order's In Process</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-pink update-card">
                                <div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-8">
                                            <h4 class="text-white"><?php echo $wallet['hold_balance']; ?></h4>
                                            <h6 class="text-white m-b-0">Disputes</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <canvas id="update-chart-3" height="50"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>Balance On Hold</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-lite-green update-card">
                                <div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-8">
                                            <h4 class="text-white"><?php echo $wallet['settled_balance'];?></h4>
                                            <h6 class="text-white m-b-0">Ledger Balance</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <canvas id="update-chart-4" height="50"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>Total Settled Amount</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>World Map</h5>
                                    <div id="regions_div"></div>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-12">
                            <div class="card user-card2">
                                <div class="card-block text-center">
                                    <div class="card">
                                        <h5 class="alert-info">Month Wise Order</h5>
                                        <br>
                                        <div class="card-block bg-c-green">
                                            <div id="proj-earning" style="height: 250px"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12">
                            <div class="card table-card">
                                <div class="card-header">
                                    <h5>Latest Order</h5>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                            <li><i class="feather icon-minus minimize-card"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="table table-hover  table-borderless">
                                            <thead>
                                                <tr>
                                                    <th>OderID</th>
                                                    <th>Customer</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1; foreach($latest_order as $order) { ?>
                                                <tr>
                                                    <td><?php echo $order['orders_id']; ?></td>
                                                    <td><?php echo $order['user_name']; ?></td>
                                                    <td><?php echo $order['orders_status_name']; ?></td>
                                                    <td><?php echo $order['date_purchased']; ?></td>
                                                    <td><?php echo $order['final_price']; ?></td>
                                                    <td class=""><a href="<?php echo base_url(); ?>user/orders/view/<?php echo $order['orders_id']; ?>" class="btn btn-info btn-sm">View</a></td>
                                                </tr>
                                                <?php $i++; } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    "use strict";
    $(document).ready(function() {
        function e(e, t, a) {
            return null == a && (a = "rgba(0,0,0,0)"), {
                labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15"],
                datasets: [{
                    label: "",
                    borderColor: e,
                    borderWidth: 2,
                    hitRadius: 30,
                    pointRadius: 3,
                    pointHoverRadius: 4,
                    pointBorderWidth: 5,
                    pointHoverBorderWidth: 12,
                    pointBackgroundColor: Chart.helpers.color("#000000").alpha(0).rgbString(),
                    pointBorderColor: e,
                    pointHoverBackgroundColor: e,
                    pointHoverBorderColor: Chart.helpers.color("#000000").alpha(.1).rgbString(),
                    fill: !0,
                    lineTension: 0,
                    backgroundColor: a,
                    data: t
                }]
            }
        }
    
        function t() {
            return {
                title: {
                    display: !1
                },
                tooltips: {
                    position: "nearest",
                    mode: "index",
                    intersect: !1,
                    yPadding: 10,
                    xPadding: 10
                },
                legend: {
                    display: !1,
                    labels: {
                        usePointStyle: !1
                    }
                },
                responsive: !0,
                responsive: !0,
                maintainAspectRatio: !0,
                hover: {
                    mode: "index"
                },
                scales: {
                    xAxes: [{
                        display: !1,
                        gridLines: !1,
                        scaleLabel: {
                            display: !0,
                            labelString: "Month"
                        }
                    }],
                    yAxes: [{
                        display: !1,
                        gridLines: !1,
                        scaleLabel: {
                            display: !0,
                            labelString: "Value"
                        },
                        ticks: {
                            beginAtZero: !0
                        }
                    }]
                },
                elements: {
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                layout: {
                    padding: {
                        left: 10,
                        right: 10,
                        top: 25,
                        bottom: 25
                    }
                }
            }
        }
        var a = (AmCharts.makeChart("visitor", {
            type: "serial",
            hideCredits: !0,
            theme: "light",
            dataDateFormat: "YYYY-MM-DD",
            precision: 2,
            valueAxes: [{
                id: "v1",
                title: "Visitors",
                position: "left",
                autoGridCount: !1,
                labelFunction: function(e) {
                    return "$" + Math.round(e) + "M"
                }
            }, {
                id: "v2",
                title: "New Visitors",
                gridAlpha: 0,
                position: "right",
                autoGridCount: !1
            }],
            graphs: [{
                id: "g3",
                valueAxis: "v1",
                lineColor: "#feb798",
                fillColors: "#feb798",
                fillAlphas: 1,
                type: "column",
                title: "old Visitor",
                valueField: "sales2",
                clustered: !1,
                columnWidth: .5,
                legendValueText: "$[[value]]M",
                balloonText: "[[title]]<br /><b style='font-size: 130%'>$[[value]]M</b>"
            }, {
                id: "g4",
                valueAxis: "v1",
                lineColor: "#fe9365",
                fillColors: "#fe9365",
                fillAlphas: 1,
                type: "column",
                title: "New visitor",
                valueField: "sales1",
                clustered: !1,
                columnWidth: .3,
                legendValueText: "$[[value]]M",
                balloonText: "[[title]]<br /><b style='font-size: 130%'>$[[value]]M</b>"
            }, {
                id: "g1",
                valueAxis: "v2",
                bullet: "round",
                bulletBorderAlpha: 1,
                bulletColor: "#FFFFFF",
                bulletSize: 5,
                hideBulletsCount: 50,
                lineThickness: 2,
                lineColor: "#0df3a3",
                type: "smoothedLine",
                title: "Last Month Visitor",
                useLineColorForBulletBorder: !0,
                valueField: "market1",
                balloonText: "[[title]]<br /><b style='font-size: 130%'>[[value]]</b>"
            }, {
                id: "g2",
                valueAxis: "v2",
                bullet: "round",
                bulletBorderAlpha: 1,
                bulletColor: "#FFFFFF",
                bulletSize: 5,
                hideBulletsCount: 50,
                lineThickness: 2,
                lineColor: "#fe5d70",
                dashLength: 5,
                title: "Average Visitor",
                useLineColorForBulletBorder: !0,
                valueField: "market2",
                balloonText: "[[title]]<br /><b style='font-size: 130%'>[[value]]</b>"
            }],
            chartCursor: {
                pan: !0,
                valueLineEnabled: !0,
                valueLineBalloonEnabled: !0,
                cursorAlpha: 0,
                valueLineAlpha: .2
            },
            categoryField: "date",
            categoryAxis: {
                parseDates: !0,
                dashLength: 1,
                minorGridEnabled: !0
            },
            legend: {
                useGraphSettings: !0,
                position: "top"
            },
            balloon: {
                borderThickness: 1,
                cornerRadius: 5,
                shadowAlpha: 0
            },
            dataProvider: [{
                date: "2013-01-16",
                market1: 71,
                market2: 75,
                sales1: 5,
                sales2: 8
            }, {
                date: "2013-01-17",
                market1: 74,
                market2: 78,
                sales1: 4,
                sales2: 6
            }, {
                date: "2013-01-18",
                market1: 78,
                market2: 88,
                sales1: 5,
                sales2: 2
            }, {
                date: "2013-01-19",
                market1: 85,
                market2: 89,
                sales1: 8,
                sales2: 9
            }, {
                date: "2013-01-20",
                market1: 82,
                market2: 89,
                sales1: 9,
                sales2: 6
            }, {
                date: "2013-01-21",
                market1: 83,
                market2: 85,
                sales1: 3,
                sales2: 5
            }, {
                date: "2013-01-22",
                market1: 88,
                market2: 92,
                sales1: 5,
                sales2: 7
            }, {
                date: "2013-01-23",
                market1: 85,
                market2: 90,
                sales1: 7,
                sales2: 6
            }, {
                date: "2013-01-24",
                market1: 85,
                market2: 91,
                sales1: 9,
                sales2: 5
            }, {
                date: "2013-01-25",
                market1: 80,
                market2: 84,
                sales1: 5,
                sales2: 8
            }, {
                date: "2013-01-26",
                market1: 87,
                market2: 92,
                sales1: 4,
                sales2: 8
            }, {
                date: "2013-01-27",
                market1: 84,
                market2: 87,
                sales1: 3,
                sales2: 4
            }, {
                date: "2013-01-28",
                market1: 83,
                market2: 88,
                sales1: 5,
                sales2: 7
            }, {
                date: "2013-01-29",
                market1: 84,
                market2: 87,
                sales1: 5,
                sales2: 8
            }, {
                date: "2013-01-30",
                market1: 81,
                market2: 85,
                sales1: 4,
                sales2: 7
            }]
        }), AmCharts.makeChart("proj-earning", {
            type: "serial",
            hideCredits: !0,
            theme: "light",
            dataProvider: [
    		<?php
        foreach($monthly_orders as $or)
        {
        	?>
    			{
                type: "<?php echo $or['Month'];  ?>",
                visits: <?php echo $or['orders'];  ?>
            },
    		<?php }
        ?>
    		],
            valueAxes: [{
                gridAlpha: .3,
                gridColor: "#fff",
                axisColor: "transparent",
                color: "#fff",
                dashLength: 0 
            }],
            gridAboveGraphs: !0,
            startDuration: 1,
            graphs: [{
                balloonText: "Total Order: <b>[[value]]</b>",
                fillAlphas: 1,
                lineAlpha: 1,
                lineColor: "#fff",
                type: "column",
                valueField: "visits",
                columnWidth: .5
            }],
            chartCursor: {
                categoryBalloonEnabled: !1,
                cursorAlpha: 0,
                zoomable: !1
            },
            categoryField: "type",
            categoryAxis: {
                gridPosition: "start",
                gridAlpha: 0,
                axesAlpha: 0,
                lineAlpha: 0,
                fontSize: 12,
                color: "#fff",
                tickLength: 0
            },
            export: {
                enabled: !1
            }
        }), document.getElementById("newuserchart").getContext("2d"));
        window.myDoughnut = new Chart(a, {
            type: "doughnut",
            data: {
                datasets: [{
                    data: [10, 34, 5],
                    backgroundColor: ["#fe9365", "#01a9ac", "#fe5d70"],
                    label: "Dataset 1"
                }],
                labels: ["Satisfied", "Unsatisfied", "NA"]
            },
            options: {
                maintainAspectRatio: !1,
                responsive: !0,
                legend: {
                    position: "bottom"
                },
                title: {
                    display: !0,
                    text: ""
                },
                animation: {
                    animateScale: !0,
                    animateRotate: !0
                }
            }
        });
        var a = document.getElementById("sale-chart1").getContext("2d"),
            a = (new Chart(a, {
                type: "line",
                data: e("#b71c1c", [25, 30, 15, 20, 25, 30, 15, 25, 35, 30, 20, 10, 12, 1], "transparent"),
                options: t()
            }), document.getElementById("sale-chart2").getContext("2d")),
            a = (new Chart(a, {
                type: "line",
                data: e("#00692c", [30, 15, 25, 35, 30, 20, 25, 30, 15, 20, 25, 10, 12, 1], "transparent"),
                options: t()
            }), document.getElementById("sale-chart3").getContext("2d"));
        new Chart(a, {
            type: "line",
            data: e("#096567", [15, 20, 25, 10, 30, 15, 25, 35, 30, 20, 25, 30, 12, 1], "transparent"),
            options: t()
        })
    });
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
      'packages':['geochart'],
      // Note: you will need to get a mapsApiKey for your project.
      // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
      'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
    });
    google.charts.setOnLoadCallback(drawRegionsMap);
    
    function drawRegionsMap() {
      var data = google.visualization.arrayToDataTable([
        ['Country', 'ATZ Cart Available'],
        ['India', 1]
        
      ]);
    
      var options = {};
    
      var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
    
      chart.draw(data, options);
    }
</script>
<?php $this->load->view("user/common/footer");?>