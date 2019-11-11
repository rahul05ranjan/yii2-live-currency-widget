<?php 
$this->registerJsFile("https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js");
$this->registerCss("
table {
  border-collapse: collapse;
  width: 40%;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
  background-color: #4CAF50;
  color: white;
}
");
?>
<h2 class="base_currency_text"></h2>
<select class="base_currency_list" onchange="getCurrencyValue(this.value)">
</select>
<div id="displayDiv"></div>
<p class = "update_in"></p>
<table>
  <thead>
  <tr>
    <th>Currency</th>
    <th>Rate</th>
  </tr>
  </thead>
  <tbody class="here">
  </tbody>
</table>
<script>

  function getCurrencyValue(baseCurrency){
    let url = 'https://api.openrates.io/latest?base='+baseCurrency;
    fetch(url, {mode: 'cors'})
    .then(function(response) {
      return response.text();
    })
    .then(function(text) {
      let obj = JSON.parse(text);
      $('.base_currency_text').text(`Base : ${obj.base}`);
      var result = [];

    for(var i in obj.rates){
      result.push([i, obj.rates [i]]);
    }
    
    var html = result.map(val  => `<tr><td>${val[0]}</td><td>${val[1]}</td></tr>`);
    var base_currency_list = result.map(val  => `<option value=${val[0]} ${ val[0]===obj.base?'selected':''}>${val[0]}</option>`);
    $('.here').html(html);
    $('.base_currency_list').html(base_currency_list);
    })
    .catch(function(error) {
      console.log('Request failed', error)
    });
    
    countDown(10);
  }
  getCurrencyValue('USD');

  setInterval(() => {
    let baseCurrency = $('.base_currency_list').val();
    getCurrencyValue(baseCurrency);
    
  }, 10000);

  function countDown(i, callback) {
    callback = callback || function(){};
    var int = setInterval(function() {
        $('#displayDiv').html('');
        document.getElementById("displayDiv").innerHTML = "Next Update in " + i + " seconds";
        i-- || (clearInterval(int), callback());
    }, 1000);
}
</script>