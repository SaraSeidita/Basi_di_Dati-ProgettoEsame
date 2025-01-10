<?php 

include('db_connect.php');
include('header.php');

?>

<!doctype html>
<?php include('head.php');?>

<html>
<head>
    <title>Paginazione blog</title>
    <script>
    $(document).ready(function(){
        var limit = 5; // Numero di elementi per pagina
        var offset = 0; // Offset iniziale

        function loadProducts() {
            $.ajax({
                url: 'visual_list.php',
                type: 'GET',
                data: {limit: limit, offset: offset},
                success: function(response) {
                    $('#blogList').html(response);
                }
            });
        }
        loadProducts();
        $('#next').click(function() {
            offset += limit;
            loadProducts();
        });
        $('#prev').click(function() {
            if (offset >= limit) {
                offset -= limit;
                loadProducts();
            }
        });
    });
    </script>
</head>
<body>
<h2 class="titleList">Lista dei blog</h2>
<div id="blogList"></div>
<p class="nextprev"><button id="prev">Previous</button>
<button id="next">Next</button></p>
</body>
</html>

</body>
