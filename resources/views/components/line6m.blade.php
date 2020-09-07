<script type="text/javascript">
//  2か月前までの折れ線グラフを表示 
// ▼グラフの中身
var lineChartData_6m = {

//2か月前~今月
 labels : [
    //  "2020年7月","8月","9月",
     @for($i=-5;$i<=0;$i++)
     "{{date('y年n月',strtotime(" $i month"))}}",
     
     @endfor

 ],
 datasets : [
    {
     lineTension:0,
       label: "出費",
       fillColor : "rgba(92,220,92,0)", // 線から下端までを塗りつぶす色
       strokeColor : "rgb(0)", // 折れ線の色
       pointColor : "rgb(0)",  // ドットの塗りつぶし色
       pointStrokeColor : "black",        // ドットの枠線色
       pointHighlightFill : "black",     // マウスが載った際のドットの塗りつぶし色
       pointHighlightStroke : "black",    // マウスが載った際のドットの枠線色

       //日ごとの出費の合計を入れたい
       data : [ 
        {{$sum6m['合計']}}
         ],      // 各点の値
       
    },

    //  食費
    {
       lineTension:0,
         label: "食費",
         fillColor : "rgba(92,220,92,0)", // 線から下端までを塗りつぶす色
         strokeColor : "rgb(250, 107, 11)", // 折れ線の色
         pointColor : "rgb(40)",  // ドットの塗りつぶし色
         pointStrokeColor : "black",        // ドットの枠線色
         pointHighlightFill : "black",     // マウスが載った際のドットの塗りつぶし色
         pointHighlightStroke : "black",    // マウスが載った際のドットの枠線色

         //日ごとの出費の合計を入れたい
         data : [ 
           {{$sum6m['食費']}}
           ],      // 各点の値
         
      },

      //日用品費
      {
       lineTension:0,
         label: "出費",
         fillColor : "rgba(92,220,92,0)", // 線から下端までを塗りつぶす色
         strokeColor : "rgb(4, 136, 4)", // 折れ線の色
         pointColor : "rgb(40)",  // ドットの塗りつぶし色
         pointStrokeColor : "black",        // ドットの枠線色
         pointHighlightFill : "black",     // マウスが載った際のドットの塗りつぶし色
         pointHighlightStroke : "black",    // マウスが載った際のドットの枠線色

         //日ごとの出費の合計を入れたい
         data : [ 
           {{$sum6m['日用品費']}}
           ],      // 各点の値
         
      },
      //レジャー費
      {
       lineTension:0,
       label: "出費",
         fillColor : "rgba(92,220,92,0)", // 線から下端までを塗りつぶす色
         strokeColor : "rgb(255,0,0)", // 折れ線の色
         pointColor : "rgb(40)",  // ドットの塗りつぶし色
         pointStrokeColor : "black",        // ドットの枠線色
         pointHighlightFill : "black",     // マウスが載った際のドットの塗りつぶし色
         pointHighlightStroke : "black",    // マウスが載った際のドットの枠線色

         //日ごとの出費の合計を入れたい
         data : [ 
           {{$sum6m['レジャー費']}}
           ],      // 各点の値
         
      },
      //交通費
      {
        lineTension:0,
         label: "出費",
         fillColor : "rgba(92,220,92,0)", // 線から下端までを塗りつぶす色
         strokeColor : "rgb(5, 2, 197)", // 折れ線の色
         pointColor : "rgb(40)",  // ドットの塗りつぶし色
         pointStrokeColor : "black",        // ドットの枠線色
         pointHighlightFill : "black",     // マウスが載った際のドットの塗りつぶし色
         pointHighlightStroke : "black",    // マウスが載った際のドットの枠線色


         //日ごとの出費の合計を入れたい
         data : [ 
           {{$sum6m['交通費']}}
           ],      // 各点の値
         
      },
      {
        lineTension:0,
         label: "出費",
         fillColor : "rgba(92,220,92,0)", // 線から下端までを塗りつぶす色
         strokeColor : "rgb(223, 0, 204)", // 折れ線の色
         pointColor : "rgb(40)",  // ドットの塗りつぶし色
         pointStrokeColor : "black",        // ドットの枠線色
         pointHighlightFill : "black",     // マウスが載った際のドットの塗りつぶし色
         pointHighlightStroke : "black",    // マウスが載った際のドットの枠線色


         //日ごとの出費の合計を入れたい
         data : [ 
           {{$sum6m['固定費']}}
           ],      // 各点の値
         
      },
      {
        lineTension:0,
         label: "出費",
         fillColor : "rgba(92,220,92,0)", // 線から下端までを塗りつぶす色
         strokeColor : "rgb(109, 109, 109)", // 折れ線の色
         pointColor : "rgb(40)",  // ドットの塗りつぶし色
         pointStrokeColor : "black",        // ドットの枠線色
         pointHighlightFill : "black",     // マウスが載った際のドットの塗りつぶし色
         pointHighlightStroke : "black",    // マウスが載った際のドットの枠線色


         //日ごとの出費の合計を入れたい
         data : [ 
           {{$sum6m['その他']}}
           ],      // 各点の値
         
      },
    
 ]

}

window.addEventListener('load', function(){
var ctx = document.getElementById("graph-area-6m").getContext("2d");
ctx.canvas.height = 300;
 window.myLine = new Chart(ctx).Line(lineChartData_6m,{
   responsive : true
 });
});
</script>