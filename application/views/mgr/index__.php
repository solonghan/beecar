<!DOCTYPE html>
<html>
<head>
    <? include("quote/header.php"); ?>
    <!-- <link rel="stylesheet" href="vendors/swiper/css/swiper.min.css"> -->
    <!-- <link href="vendors/nvd3/css/nv.d3.min.css" rel="stylesheet" type="text/css"> -->
    <!-- <link rel="stylesheet" href="vendors/lcswitch/css/lc_switch.css"> -->
    
    <link href="css/custom_css/flot_charts.css" rel="stylesheet" type="text/css">

    <link href="css/custom_css/dashboard1.css" rel="stylesheet" type="text/css"/>
    <!-- <link href="css/custom_css/dashboard1_timeline.css" rel="stylesheet"/> -->
    <link href="vendors/toastr/css/toastr.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="css/custom_css/toastr_notificatons.css">

    
    <link href="vendors/circliful/css/jquery.circliful.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="vendors/animate/animate.min.css"/>

    <link rel="stylesheet" type="text/css" href="css/custom_css/widgets1.css">
    
    <link rel="stylesheet" type="text/css" href="css/custom_css/circle_sliders.css">

    <style>
        .panel{
            border-radius: 12px;
        }
        .panel-heading{
            border-top-right-radius: 12px;
            border-top-left-radius: 12px;
        }
        .sub_statistic{
            margin: 10px 0;
            border-right: 1px solid #CCC;
            cursor: pointer;
        }
        .no_border{
            border: 0;
        }
        .sub_value{
            text-align: center;
            margin: 10px 0 0 0;
        }
        .sub_value .mini{
            font-size: 14px; 
            color: #AAA;
        }
        .panel-title .mini{
            font-size: 12px;
        }
        .sub_title{
            font-size: 18px; 
            width: 100%; 
            text-align: center; 
            padding: 10px;
            margin: 0 10%;
            width: 80%;
        }
        .sub_title.meeting_1_color{
            border-bottom: 7px solid #00d100; 
        }
        .sub_title.meeting_2_color{
            border-bottom: 7px solid #548235; 
        }
        .sub_title.meeting_3_color{
            border-bottom: 7px solid #c5e0b4; 
        }
        

        .sub_title.buyer_1_color{
            border-bottom: 7px solid #4472c4; 
        }
        .sub_title.buyer_2_color{
            border-bottom: 7px solid #00b0f0; 
        }
        .sub_title.buyer_3_color{
            border-bottom: 7px solid #deebf7; 
        }

        .sub_title.exhibitor_1_color{
            border-bottom: 7px solid #bf9000; 
        }
        .sub_title.exhibitor_2_color{
            border-bottom: 7px solid #ffc000; 
        }
        .sub_title.exhibitor_3_color{
            border-bottom: 7px solid #ffe699; 
        }
    </style>
</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">

        <section class="content-header" style="margin-bottom: 0;">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-5 col-xs-8">
                    <div class="header-element">
                        <h3>Dashboard</h3>
                    </div>
                </div>
                <!-- <div class="col-lg-4 col-lg-offset-2 col-md-6 col-sm-7 col-xs-4">
                    <div class="header-object">
                        <span class="option-search pull-right hidden-xs">
                            <span class="search-wrapper">
                                <input type="text" placeholder="Search here"><i class="ti-search"></i>
                            </span>
                        </span>
                    </div>
                </div> -->
            </div>
        </section>


        <section class="content">
            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <span class="ti-pie-chart"></span> 會議達成率<span class="mini">/Meeting</span>
                            </h4>
                            <!-- <span class="pull-right">
                                    <i class="fa fa-fw ti-angle-up clickable"></i>
                                    <i class="fa fa-fw ti-close removepanel clickable"></i>
                            </span> -->
                        </div>
                        <div class="panel-body row">
                            <div class="col-md-12 text-center">
                                <input class="knob meeting meeting_1" data-width="200" data-height="200" data-fgColor="#00d100" value="<?=intval(36/100*100) ?>" readonly data-displayinput=true>
                                <input class="knob meeting meeting_2" data-width="200" data-height="200" data-fgColor="#548235" value="<?=intval(20/100*100) ?>" readonly data-displayinput=true>
                                <input class="knob meeting meeting_3" data-width="200" data-height="200" data-fgColor="#c5e0b4" value="<?=intval(16/100*100) ?>" readonly data-displayinput=true>
                            </div>
                            <div class="col-md-4 sub_statistic" data-id="meeting_1">
                                <h2 class="sub_value">36<span class="mini">/100</span></h2>
                                <h5 class="sub_title meeting_1_color">total</h5>
                            </div>
                            <div class="col-md-4 sub_statistic" data-id="meeting_2">
                                <h2 class="sub_value">20<span class="mini">/60</span></h2>
                                <h5 class="sub_title meeting_2_color">online</h5>
                            </div>
                            <div class="col-md-4 sub_statistic no_border" data-id="meeting_3">
                                <h2 class="sub_value">16<span class="mini">/40</span></h2>
                                <h5 class="sub_title meeting_3_color">onsite</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-xs-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <span class="ti-pie-chart"></span> 買主達成率<span class="mini">/Buyer</span>
                            </h4>
                            <!-- <span class="pull-right">
                                    <i class="fa fa-fw ti-angle-up clickable"></i>
                                    <i class="fa fa-fw ti-close removepanel clickable"></i>
                            </span> -->
                        </div>
                        <div class="panel-body row">
                            <div class="col-md-12 text-center">
                                <input class="knob buyer buyer_1" data-width="200" data-height="200" data-fgColor="#4472c4" value="<?=intval(28/60*100) ?>" readonly data-displayinput=true>
                                <input class="knob buyer buyer_2" data-width="200" data-height="200" data-fgColor="#00b0f0" value="<?=intval(18/60*100) ?>" readonly data-displayinput=true>
                                <input class="knob buyer buyer_3" data-width="200" data-height="200" data-fgColor="#deebf7" value="<?=intval(10/60*100) ?>" readonly data-displayinput=true>
                            </div>
                            <div class="col-md-4 sub_statistic" data-id="buyer_1">
                                <h2 class="sub_value">28<span class="mini">/60</span></h2>
                                <h5 class="sub_title buyer_1_color">total</h5>
                            </div>
                            <div class="col-md-4 sub_statistic" data-id="buyer_2">
                                <h2 class="sub_value">18<span class="mini">/20</span></h2>
                                <h5 class="sub_title buyer_2_color">online</h5>
                            </div>
                            <div class="col-md-4 sub_statistic no_border" data-id="buyer_3">
                                <h2 class="sub_value">10<span class="mini">/40</span></h2>
                                <h5 class="sub_title buyer_3_color">onsite</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-xs-12">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <span class="ti-pie-chart"></span> 廠商達成率<span class="mini">/Exhibitor</span>
                            </h4>
                            <!-- <span class="pull-right">
                                    <i class="fa fa-fw ti-angle-up clickable"></i>
                                    <i class="fa fa-fw ti-close removepanel clickable"></i>
                            </span> -->
                        </div>
                        <div class="panel-body row">
                            <div class="col-md-12 text-center">
                                <input class="knob exhibitor exhibitor_1" data-width="200" data-height="200" data-fgColor="#bf9000" value="<?=intval(8/40*100) ?>" readonly data-displayinput=true>
                                <input class="knob exhibitor exhibitor_2" data-width="200" data-height="200" data-fgColor="#ffc000" value="<?=intval(6/40*100) ?>" readonly data-displayinput=true>
                                <input class="knob exhibitor exhibitor_3" data-width="200" data-height="200" data-fgColor="#ffe699" value="<?=intval(2/40*100) ?>" readonly data-displayinput=true>
                            </div>
                            <div class="col-md-4 sub_statistic" data-id="exhibitor_1">
                                <h2 class="sub_value">8<span class="mini">/40</span></h2>
                                <h5 class="sub_title exhibitor_1_color">total</h5>
                            </div>
                            <div class="col-md-4 sub_statistic" data-id="exhibitor_2">
                                <h2 class="sub_value">8<span class="mini">/20</span></h2>
                                <h5 class="sub_title exhibitor_2_color">online</h5>
                            </div>
                            <div class="col-md-4 sub_statistic no_border" data-id="exhibitor_3">
                                <h2 class="sub_value">2<span class="mini">/20</span></h2>
                                <h5 class="sub_title exhibitor_3_color">onsite</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row" style="margin-bottom: 15px;">
                <div class="col-md-12 col-xs-12">
                    <div id="tag_chart" style="height: 500px; box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);"></div>
                </div>
            </div>

            <?
                $objs1 = [
                    ['US', 1200],
                    ['CO', 960],
                    ['CV', 657],
                    ['KI', 545],
                    ['AD', 262],
                    ['NP', 189],
                    ['TW', 130],
                    ['CC', 75],
                    ['GB', 67],
                    ['IN', 22],
                ];
                $objs2 = [
                    ['TW', 520],
                    ['BE', 340],
                    ['US', 167],
                    ['CN', 155],
                    ['AL', 90],
                    ['NP', 69],
                    ['SE', 20],
                    ['CC', 17],
                    ['AI', 10],
                    ['NI', 3],
                ];
            ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="ti-layout-cta-left"></i> 買主 - 國別統計
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>國別</th>
                                            <th>國碼</th>
                                            <th>佔比</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                            $total = 0;
                                            foreach ($objs1 as $obj) {
                                                $total += intval($obj[1]);
                                            }

                                            foreach ($objs1 as $index => $obj) {
                                                echo '<tr>';
                                                echo '<td>Top '.str_pad($index+1, 2, '0', STR_PAD_LEFT).'</td>';
                                                echo '<td><img style="width:20px;" src="'.base_url().'flag/'.strtolower($obj[0]).'.png"> '.$timezone[$obj[0]]['country_name'].'</td>';
                                                echo '<td>'.$timezone[$obj[0]]['country_code'].'</td>';
                                                echo '<td>'.intval($obj[1] / $total * 100).'%</td>';
                                                echo '</tr>';
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="ti-layout-cta-left"></i> 廠商 - 國別統計
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>國別</th>
                                            <th>國碼</th>
                                            <th>佔比</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                            $total = 0;
                                            foreach ($objs2 as $obj) {
                                                $total += intval($obj[1]);
                                            }

                                            foreach ($objs2 as $index => $obj) {
                                                echo '<tr>';
                                                echo '<td>Top '.str_pad($index+1, 2, '0', STR_PAD_LEFT).'</td>';
                                                echo '<td><img style="width:20px;" src="'.base_url().'flag/'.strtolower($obj[0]).'.png"> '.$timezone[$obj[0]]['country_name'].'</td>';
                                                echo '<td>'.$timezone[$obj[0]]['country_code'].'</td>';
                                                echo '<td>'.intval($obj[1] / $total * 100).'%</td>';
                                                echo '</tr>';
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="widget-bg-color-icon card-box">
                        <div class="bg-icon bg-warning pull-left">
                            <i class="ti-eye text-white"></i>
                        </div>
                        <div class="text-right">
                            <h3 class="text-dark"><b id="widget_count1">2652</b></h3>
                            <p>Visitors</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="widget-bg-color-icon card-box border_success">
                        <div class="bg-icon pull-left">
                            <i class="ti-pie-chart text-success"></i>
                        </div>
                        <div class="text-right">
                            <h3 class="text-success"><b id="widget_count3">3251</b></h3>
                            <p>Sales status</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="widget-bg-color-icon card-box">
                        <div class="bg-icon bg-icon-info pull-left">
                            <i class="ti-cup text-primary"></i>
                        </div>
                        <div class="text-right">
                            <h3 class="text-dark"><b id="widget_count2">7698</b></h3>
                            <p class="text-primary">Income status</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="widget-bg-color-icon card-box border_danger">
                        <div class="text-center">
                            <h3 class="text-danger"><b id="widget_count4">4358</b></h3>
                            <p>Total sales:<span class="text-success"> 3251</span><span class="pull-right"><i
                                    class="ti-angle-double-down text-danger m-r-5"></i>7.85%</span></p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="main-widgets">
                    <div class="col-md-4 col-sm-4 text-center">
                        <div class="status-data">
                            <h4><b>Status</b></h4>
                            <div class="row">
                                <div class="col-xs-4 daily-data">Daily Visits <br> <b>243</b></div>
                                <div class="col-xs-4 monthly-data">Monthly Visits <br> <b>7.29K</b></div>
                                <div class="col-xs-4 actual">Total Visits <br> <b>86.4k</b></div>
                                <div class="col-xs-12">
                                    <hr>
                                </div>
                                <div class="col-xs-12">
                                    <span id="visitsspark-chart"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 text-center">
                        <div class="sales-data">
                            <h4><b>Sales</b></h4>
                            <div class="row">
                                <div class="col-xs-4 daily-data">Daily Sales <br> <b>112</b></div>
                                <div class="col-xs-4 monthly-data">Monthly Sales <br> <b>3.3K</b></div>
                                <div class="col-xs-4 actual">Total Sales <br> <b>40.3k</b></div>
                                <div class="col-xs-12">
                                    <hr>
                                </div>
                                <div class="col-xs-12">
                                    <span id="salesspark-chart"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 text-center">
                        <div class="server-load">
                            <h4><b>Server Load</b></h4>
                            <div class="row">
                                <div class="col-xs-4 daily-data">Used Space <br> <b>617 GB</b></div>
                                <div class="col-xs-4 monthly-data">Total Space <br> <b>1 TB</b></div>
                                <div class="col-xs-4 actual">Actual Load <br> <b>61.7 %</b></div>
                                <div class="col-xs-12">
                                    <hr>
                                </div>
                                <div class="col-xs-12">
                                    <span id="loadspark-chart1" class=""></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel ">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="ti-bar-chart-alt"></i> 近30天流量
                            </h4>
                            
                        </div>
                        <div class="panel-body">
                            <div id="basicFlotLegend" class="flotLegend"></div>
                            <div id="line-chart" class="flotChart1"></div>
                        </div>
                    </div>
                </div>

            </div> -->
        </section>
        
    </aside>
    <!-- /.right-side --> </div>
<!-- ./wrapper -->
<!-- global js -->
<div id="qn"></div>
<script src="js/app.js" type="text/javascript"></script>
<!-- end of global js -->
<script type="text/javascript" src="vendors/moment/js/moment.min.js"></script>
<script type="text/javascript" src="vendors/advanced_newsTicker/js/newsTicker.js"></script>
<!-- <script type="text/javascript" src="js/dashboard1.js"></script> -->

<script type="text/javascript" src="js/custom_js/sparkline/jquery.flot.spline.js"></script>

<script type="text/javascript" src="vendors/flip/js/jquery.flip.min.js"></script>
<script type="text/javascript" src="vendors/lcswitch/js/lc_switch.min.js"></script>


<script src="vendors/flotchart/js/jquery.flot.js" type="text/javascript"></script>
<script src="vendors/flotchart/js/jquery.flot.resize.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="vendors/flotchart/js/jquery.flot.stack.js"></script>
<script language="javascript" type="text/javascript" src="vendors/flotchart/js/jquery.flot.time.js"></script>
<script src="vendors/flotspline/js/jquery.flot.spline.min.js" type="text/javascript"></script>
<script src="vendors/flotchart/js/jquery.flot.categories.js" type="text/javascript"></script>
<script src="vendors/flotchart/js/jquery.flot.pie.js" type="text/javascript"></script>
<script src="vendors/flot.tooltip/js/jquery.flot.tooltip.js" type="text/javascript"></script>


<script src="vendors/toastr/js/toastr.min.js"></script>
<script src="vendors/datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>



<script type="text/javascript" src="vendors/countUp.js/js/countUp.js"></script>
<!--Sparkline Chart-->
<script type="text/javascript" src="vendors/jquery-knob/js/jquery.knob.js"></script>
<!-- flip --->
<script src="vendors/flip/js/jquery.flip.min.js" type="text/javascript"></script>
<!-- circliful -->
<script src="vendors/circliful/js/jquery.circliful.min.js" type="text/javascript"></script>
<!-- sparkline charts -->
<script src="js/custom_js/sparkline/jquery.flot.spline.js"></script>

<script type="text/javascript" src="js/custom_js/widgets1.js"></script>


<script src="vendors/jquery-knob/js/jquery.knob.js"></script>
<script src="js/custom_js/sparkline/jquery.flot.spline.js"></script>
<script src="js/custom_js/circle_sliders.js"></script>


<script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
<script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
<script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
<script src="https://cdn.anychart.com/releases/v8/themes/pastel.min.js"></script>
<link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
<link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">
  

<script>
    toastr.options = {
          "closeButton": true,
          "debug": false,
          "newestOnTop": false,
          "progressBar": false,
          "positionClass": "toast-bottom-full-width",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "1000",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "swing",
          "showMethod": "show"
        };
    $(document).ready(function($) {
        $(".sub_statistic").on('click', function(event) {
            var id = $(this).attr("data-id");
            var key = id.split('_')[0]
            $(document).find('.'+key).each(function(index, el) {
                $(this).parent('div').css({'display':'none'});
            });
            $("."+key+"."+id).parent('div').css({'display':'inline'});
        });
        $(".sub_statistic[data-id=meeting_1]").trigger('click');
        $(".sub_statistic[data-id=buyer_1]").trigger('click');
        $(".sub_statistic[data-id=exhibitor_1]").trigger('click');


        /////////// TAG CHART
        anychart.onDocumentReady(function () {
        // set chart theme
        anychart.theme('pastel');
          // create data set
          var dataSet = anychart.data.set(getData());

          // map data for the first series, take x from the zero column and value from the first column of data set
          var firstSeriesData = dataSet.mapAs({ x: 0, value: 1 });

          // map data for the second series, take x from the zero column and value from the second column of data set
          var secondSeriesData = dataSet.mapAs({ x: 0, value: 2 });

          // create bar chart
          var chart = anychart.bar();

          // turn on chart animation
          chart.animation(true);

          // set padding
          chart.padding([10, 20, 5, 20]);
          var background = chart.background();
          background.stroke('1 #dcdcdc');
          background.cornerType("round");
          background.corners(12);

          // force chart to stack values by Y scale.
          chart.yScale().stackMode('value');

          // format y axis labels so they are always positive
          chart
            .yAxis()
            .labels()
            .format(function () {
              return Math.abs(this.value).toLocaleString();
            });

          // set title for Y-axis
          chart.yAxis(0).title('次數');

          // allow labels to overlap
          chart.xAxis(0).overlapMode('allow-overlap');

          // turn on extra axis for the symmetry
          chart
            .xAxis(1)
            .enabled(true)
            .orientation('right')
            .overlapMode('allow-overlap');

          // set chart title text
          chart.title('TAG使用統計表');

          chart.interactivity().hoverMode('by-x');

          chart
            .tooltip()
            .title(false)
            .separator(false)
            .displayMode('separated')
            .positionMode('point')
            .useHtml(true)
            .fontSize(12)
            .offsetX(5)
            .offsetY(0)
            .format(function () {
              return (
                '<span style="color: #D9D9D9"></span>' +
                Math.abs(this.value).toLocaleString()
              );
            });

          // temp variable to store series instance
          var series;

          // create first series with mapped data
          series = chart.bar(firstSeriesData);
          series.name('廠商/Exhibitor').color('darkgoldenrod');
          series.tooltip().position('right').anchor('left-center');

          // create second series with mapped data
          series = chart.bar(secondSeriesData);
          series.name('買主/Buyer').color('cornflowerblue');
          series.tooltip().position('left').anchor('right-center');

          // turn on legend
          chart
            .legend()
            .enabled(true)
            .inverted(true)
            .fontSize(13)
            .padding([0, 0, 20, 0]);

          // set container id for the chart
          chart.container('tag_chart');

          // initiate chart drawing
          chart.draw();
        });

        function getData() {
          return [
            ["Creation", Math.floor(Math.random() * 200), Math.floor(Math.random() * 200)*-1],
            ["Artificial Intelligence", Math.floor(Math.random() * 200), Math.floor(Math.random() * 200)*-1],
            ["Machine Learning", Math.floor(Math.random() * 200), Math.floor(Math.random() * 200)*-1],
            ["Research & Development", Math.floor(Math.random() * 200), Math.floor(Math.random() * 200)*-1],
            ["System integrator", Math.floor(Math.random() * 200), Math.floor(Math.random() * 200)*-1],
            ["Fianancia", Math.floor(Math.random() * 200), Math.floor(Math.random() * 200)*-1],
          ];
        }









        $("#subscribers-chart").sparkline([3, 4, 6, 3, 5], {
            type: 'pie',
            width: '55',
            height: '55',
            sliceColors: ['#6699cc', '#66cc99', '#f0ad4e', '#66ccff', '#66cc99']
        });

        var d1, d2, data, Options;

        <?
            $d1 = array();
            $d2 = array();
            $axis = array();

            $today = date("Y-m-d");
            $max_value = 0;

            for ($i=0; $i < 30; $i++) { 
                $d = date('Y-m-d', strtotime("-".$i." day", strtotime($today)));
                array_push($d1, array(strtotime($d)*1000, 0));
                array_push($d2, array(strtotime($d)*1000, 0));
                array_push($axis, array($i, $d));
            }

            for ($i=0; $i <count($statistic); $i++) { 
                for($j = 0; $j < count($d1); $j++){
                    if (strtotime(date($statistic[$i]['date']))*1000 == $d1[$j][0]) {
                        $d1[$j][1] = $statistic[$i]['value'];

                    }   
                }
                if ($statistic[$i]['value'] > $max_value) $max_value = $statistic[$i]['value'];
                // array_push($d1, array( strtotime(date($statistic[$i]['date']))*1000, $statistic[$i]['value'] ));
                // array_push($axis, array($i, date("Y-m-d", strtotime($statistic[$i]['date']))));
            }

            for ($i=0; $i <count($statistic_independent); $i++) { 
                for($j = 0; $j < count($d2); $j++){
                    if (strtotime(date($statistic_independent[$i]['date']))*1000 == $d2[$j][0]) {
                        $d2[$j][1] = $statistic_independent[$i]['value'];

                    }   
                }
                if ($statistic_independent[$i]['value'] > $max_value) $max_value = $statistic_independent[$i]['value'];
                // array_push($d1, array( strtotime(date($statistic[$i]['date']))*1000, $statistic[$i]['value'] ));
                // array_push($axis, array($i, date("Y-m-d", strtotime($statistic[$i]['date']))));
            }

            $y_step = $max_value / 100 * 10;
        ?>
        d1 = <?=json_encode($d1) ?>;
        d2 = <?=json_encode($d2) ?>;
        

        data = [
            {
                label: "流量",
                data: d1,
                color: "#66cc99"
            },
            {
                label: "不重複訪客",
                data: d2,
                color: "#f0ad4e"
            }
        ];

        Options = {
            xaxis: {
                <?
                    // $min = (count($axis) <= 0) ? 0 :explode("-", $axis[0][1]);
                    // $max = (count($axis) <= 0) ? 0 :explode("-", $axis[count($axis)-1][1]);
                    
                    $today = date("Y-m-d");
                    $min = date('Y-m-d', strtotime("-30 day", strtotime($today)));
                    $max = strtotime($today)*1000;
                ?>
                // min: (new Date(<?=$min[0] ?>, <?=$min[1] ?>, <?=$min[2] ?>)).getTime(),
                // max: (new Date(<?=$max[0] ?>, <?=$max[1] ?>, <?=$max[2] ?>)).getTime(),
                mode: "time",
                tickSize: [1, "day"],
                // monthNames: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"],
                // tickLength: 0

                tickLength: 5,  
                timezone: "browser",
                timeformat: "%b<br>%d"
            },
            yaxis: {
                tickSize: <?=$y_step ?>
            },
            series: {
                lines: {
                    show: true,
                    fill: false,
                    lineWidth: 2
                },
                points: {
                    show: true,
                    radius: 4.5,
                    fill: true,
                    fillColor: "#ffffff",
                    lineWidth: 2
                }
            },
            grid: {
                hoverable: true,
                clickable: false,
                borderWidth: 0
            },
            legend: {
                container: '#basicFlotLegend',
                show: true
            },

            tooltip: true,
            tooltipOpts: {
                content: '%s: %y'
            }

        };


        var holder = $('#line-chart');

        if (holder.length) {
            $.plot(holder, data, Options);
        }
    });
    
</script>
</body>

</html>