<?php include ("./head.html"); ?>


<div style="margin:40px">
  <p style="font-weight:700">For registration, please fill the form below.</p>
  <p style="font-size:70%">
    Early bird  by 23 Sep , standard by 14 Oct.
  </p>
</div>

<div id="page-body">

<div id="regis">
  <form id="myform" name="myform" onsubmit="subform(); return false;">
    <input type="hidden" id="price" name="price" value=350>
    <input type="hidden" id="payId" name="payId">
    <input type="hidden" id="id" name="id">

    <table>
      <tr>
        <td><label for="mail">Your e-mail:</label></td>
        <td><input type="email" id="mail" name="mail" placeholder="Enter your e-mail.." autofocus autocomplete="off"></td>
      </tr>
      <tr>
        <td><label for="name">Your name:</label>
        <td><input type="text" id="name" name="name" placeholder="Enter your name.." autocomplete="off"></td>
      </tr>
      <tr>
        <td><label for="name">Affiliation:</label></td>
        <td><input type="text" id="affili" name="affili" placeholder="Your affiliation.." autocomplete="off"></td>
      </tr>
    </table>

    <div>
      <label for="dinner">Conference dinner - 40 €:</label>
      <input type="checkbox" id="dinner" name="dinner" value="40" autocomplete="off" onchange="diner()">
    </div>
    
    <div class="offer">
      <label>City Tour:</label>
      <ul class="offer">
        <li><input type="radio" id="nab1" name="excor" value="A walk through Prague's pubs, bars, wine bars, and taverns" autocomplete="off">A walk through Prague's pubs, bars, wine bars, and taverns
        </li>
        <li><input type="radio" id="nab2" name="excor" value="From the Nazi Protectorate to Liberation" autocomplete="off">From the Nazi Protectorate to Liberation
        </li>
        <li><input type="radio" id="nab3" name="excor" value="Guided tour" autocomplete="off">Guided tour of the main sights of Malá Strana and the Old Town
        </li>
        <li><input type="radio" id="nab4" name="excor" value="I am not interested in any of this" autocomplete="off">I am not interested in any of this
        </li>
      </ul>
    </div>
    <p>
      <label for="student">I am a PhD student:</label>
      <input type="checkbox" id="student" name="student" value="30" autocomplete="off" onchange="stude()">
    </p>
    <p>
      <label for="payment">Payment method:</label>
      <input type="radio" id="card" name="payment" value="card" checked>Credit card
      <input type="radio" id="trans" name="payment" value="transfer">Bank transfer
    </p>
    <p>
      <label>Total price:</label>
      <span id="tprice"> 350</span> &euro;
    </p>
    <div class=submit-button>
      <input type="submit" value="Register">
    </div>
  </form>
  
  <div id="comgate-container" style="z-index: 10003; position: fixed; top: 90px;">
    <!-- Atribut allow=payment je pro zobrazení brány v iframe nezbytný 
    <iframe id='comgate-iframe' allow="payment" src="[platební URL]" frameborder="0px"></iframe>-->
  </div>
</div>


<div id="nofoot">Payments are accepted by UTIA AV ČR, more information <a href="https://conference24.utia.cz/info"
    target="pay">here</a>
</div>

</div>

<?php include ("./foot.html"); ?>
<script src="./registration.js"></script>
