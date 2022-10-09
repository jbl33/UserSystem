$( document ).ready(function() {
    $("#search-btn").click(function(){
        document.getElementById("error-text").innerHTML = "";
        if($("#search-box").val() == "") {
            document.getElementById("error-text").innerHTML = "Error: You must input a value!";
        } else {
            var search_query = $("#search-box").val();
            var apiKey = $("#api-key").val();
            var table;
            $.ajax({
                url: "buildtable.php",
                data: { query: search_query, apiKey: apiKey},
                type: "GET",
                context: document.body
              }).done(function(msg) {
                document.getElementById("result-table").innerHTML = msg;
              });
        }
    });
});
