$(document).ready(function() {
            $.ajax({
                url: "buildFileTable.php",
                data: {apiKey: apiKey},
                type: "GET",
                context: document.body
              }).done(function(msg) {
                document.getElementById("result-display").innerHTML = msg;
              });
});