$(document).ready(function() {

  var countrySelect = document.getElementById('countrySelect');

  $.ajax({
    url: "js/cityToCountry.json",
    dataType: "json",
    success: function(results) {
      var countries = Object.keys(results);
      countries.sort();

      for( var i = 0; i < countries.length; i++ ) {
        var option = document.createElement('option');
        var txt = document.createTextNode(countries[i]);
        option.appendChild(txt);
        $(option).attr('value', countries[i]);

        countrySelect.appendChild(option);
      }
    }
  })

});
