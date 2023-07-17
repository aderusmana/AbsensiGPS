 <!-- ///////////// Js Files ////////////////////  -->
 <!-- Jquery -->
 <script src="{{ asset('assets') }}/js/lib/jquery-3.4.1.min.js"></script>
 <!-- Bootstrap-->
 <script src="{{ asset('assets') }}/js/lib/popper.min.js"></script>
 <script src="{{ asset('assets') }}/js/lib/bootstrap.min.js"></script>
 <!-- Ionicons -->
 <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
 <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
 <!-- Owl Carousel -->
 <script src="{{ asset('assets') }}/js/plugins/owl-carousel/owl.carousel.min.js"></script>
 <!-- jQuery Circle Progress -->
 <script src="{{ asset('assets') }}/js/plugins/jquery-circle-progress/circle-progress.min.js"></script>
 <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
 <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
 <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
 <!-- Base Js File -->
 <script src="{{ asset('assets') }}/js/base.js"></script>

 {{-- // sweetalert --}}

 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


 {{-- webcam --}}
 <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>

 {{-- datepicker --}}
 <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>

 {{-- <script>
     am4core.ready(function() {

         // Themes begin
         am4core.useTheme(am4themes_animated);
         // Themes end

         var chart = am4core.create("chartdiv", am4charts.PieChart3D);
         chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

         chart.legend = new am4charts.Legend();

         chart.data = [{
                 country: "Hadir",
                 litres: 501.9
             },
             {
                 country: "Sakit",
                 litres: 301.9
             },
             {
                 country: "Izin",
                 litres: 201.1
             },
             {
                 country: "Terlambat",
                 litres: 165.8
             },
         ];



         var series = chart.series.push(new am4charts.PieSeries3D());
         series.dataFields.value = "litres";
         series.dataFields.category = "country";
         series.alignLabels = false;
         series.labels.template.text = "{value.percent.formatNumber('#.0')}%";
         series.labels.template.radius = am4core.percent(-40);
         series.labels.template.fill = am4core.color("white");
         series.colors.list = [
             am4core.color("#1171ba"),
             am4core.color("#fca903"),
             am4core.color("#37db63"),
             am4core.color("#ba113b"),
         ];
     }); // end am4core.ready()
 </script> --}}
 @stack('myScript')
