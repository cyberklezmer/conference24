function diner(){
  if( $("#dinner").is(":checked") == true){
    $("#price").val( parseInt( $("#price").val()) +  parseInt( $("#dinner").val()));
  }else{
    $("#price").val( parseInt( $("#price").val()) -  parseInt( $("#dinner").val()));
  } 
  $("#tprice").text($("#price").val());
}

function stude(){
  if( $("#student").is(":checked") == true){
    $("#price").val( parseInt( $("#price").val()) - 100);
  }else{
    $("#price").val( parseInt( $("#price").val()) + 100);
  } 
  $("#tprice").text($("#price").val());
}

function subform(){
  if( $("#myform").valid()){
    $.ajax({
      url: "./savereg.php",
      method: "POST",
      data: $("#myform").serialize(),
      error: function (request, status, error) {
          alert('ERROR  '+request.responseText+' '+status+' '+ error);
      },
      success: function (msg){
        
        if( $('#card').is(":checked")){
          var resu = JSON.parse(msg);
          var url = resu["response"].split("&");
          url = url[3].split("=");
          url= decodeURIComponent(url[1]);
          $("#comgate-container").html('<P><iframe id="comgate-iframe" allow="payment" src="'+url+'" frameborder="0px"></iframe>');
          comgateOpen();
          $("#id").val( resu["id"]);
        }else{
          $("#regis").html( msg);
          $("#nofoot").css('display', "none");
        }
      }
    })
      
  }
}

$("#myform").ready(function(){
   $("#myform").validate({
      errorElement: 'div',
      rules: {
        name: {
					required: true,
        },
	    	mail:	{
					validate_email: true
				}
		  }
   });
})

// funkce pro otevření iframu s bránou
function comgateOpen() {
    let comgate_container = document.getElementById("comgate-container");
    comgate_container.style.display = "block";
}
// funkce pro zavření iframu s bránou
function comgateClose() {
    //let comgate_container = document.getElementById("comgate-container");
    //comgate_container.style.display = "none";

    $("#comgate-container").css("display", "none")
    // bude odstraněno z DOM - již nepůjde zobrazit znovu pomocí comgateOpen
    // let comgate_iframe = document.getElementById("comgate-iframe");
    // comgate_iframe.remove();

    var url = window.top.location.toString();
    //window.top.location = url; //url.substr(0, url.indexOf("form"));
}

// odchycení zprávy poslané z iframu pomocí postMessage
if (window.addEventListener) {
  window.addEventListener('message', function (e) {
  // validace, že message obsahuje data
    if (!e || !(e !== null && e !== void 0 && e.data)) return;
    //alert( printObj(e.data)); 
    const { scope, action, value } = e.data;
    
    if (scope === 'comgate-to-eshop' && action === 'status' && value) {
      // id = XXXX-XXXX-XXXX
      // isTest = true/false (testovací platba)
      // refId = ID objednávky od klienta
      // status = stav platby
      const { id, isTest, refId, status } = value;
 //this.alert(value)   ;
      if (['PAID', 'AUTHORIZED'].includes(status)) {
          // obsloužení stavu PAID/AUTHORIZED - zaplaceno/předautorizováno
          $.ajax({
            url: "./savepayed.php",
            method: "POST",
            data: "id="+$("#id").val()+"&status="+status,
            error: function (request, status, error) {
                alert(request.responseText+' '+status+' '+error);
            },
            success: function (data){
              $("#regis").html(data);
              $("#nofoot").css("display", "none");
              comgateClose();            
             }
          })
      } else if (status === 'CANCELLED') {
          // obsloužení stavu CANCELLED - nezaplaceno
          myDelete(true, status);
      } else {
          // obsloužení dalších stavů, atd (velmi krajní případ) ...
          // PENDING, UNKNOWN
 /*         if( status == "PENDING"){
            myDelete(false, status);
          } else {
*/           
            $.ajax({
              url: "./error.php",
              method: "POST",
              data: "id="+$("#id").val()+"&status="+status,
              error: function (request, status, error) {
                  alert(request.responseText+' '+status+' '+error);
              },
              success: function (data){
                $("#regis").html(data);
                comgateClose();
                $("#nofoot").css("display", "none");
              }               
            })

//          }

      }
    } /*else {
      if(e.data["action"] == "router"){
        //alert( printObj(e.data)); //cg-store-btn
        if( ["Cancel Payment"].includes(e.data["routeName"])){
          myDelete( true);
        }
      }           
    }*/
  }, false);
}

function myDelete( redir, status){
  $.ajax({
    url: "./delereg.php",
    method: "POST",
    data: "id="+$("#id").val()+"&status="+status,
    error: function (request, status, error) {
        alert(request.responseText+' '+status+' '+error);
    },
    success: function (){
      if( redir){
        var url = window.top.location.toString();
        window.top.location = url; //url.substr(0, url.indexOf("form"));
      }else {
        comgateClose();
      }
    }               
  })  
}
let printObj = function (obj) {
  let string = '';

  for (let prop in obj) {
      if (typeof obj[prop] == 'string') {
          string += prop + ': ' + obj[prop] + '; \n';
      }
      else {
          string += prop + ': { \n' + print(obj[prop]) + '}';
      }
  }
  return string;
}