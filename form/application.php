<?php include("./head.html");?>
<script type="application/javascript"> 
    var loadCounter = 0; 
    var load = function() { 
      alert($("#codeFrame").contents().find("body"));
        loadCounter += 1; 
        if (loadCounter === 2) { 
            $("iframe").attr("height", "350px"); 
            $(window).scrollTo(315,0);
            $("#div").css('display', 'none');
        } 
        
    } 
</script>
<div class="preamble">
    <p>
      <strong>Assessing and Controlling Financial, Industrial, and General Risk</strong><br>
      28.-30. October 2024, Prague<br>
      conference24@utia.cas.cz
    </p>
  </div>
  <div>
<iframe id="codeFrame" style="border:0px"
  width="100%"
  height="2000"
  src="https://docs.google.com/forms/d/e/1FAIpQLSc-50Pq930COmQPKAs3-aLwrdn2O05vNjg38hTokBTEaXyGmw/viewform?usp=sf_link"
  scrolling="no"
  onload="load()">
  
</iframe>
<div id="div" style="font-size: 11pt;
  line-height: 15pt;
  letter-spacing: 0;
  text-align: center;">
here is note
</div>
<?php include("./foot.html");?>

