<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Sheep management system</title>
</head>
<body>
<h1>Sheep management system</h1>
<h1 id="day"></h1>
<div class="container">
    <div class="row">
        <div class="col-2">

        </div>
        <div class="col-10">
            <ul>
                <li><h3 id="total"></h3></li>
                <li><h3 id="killed"></h3></li>
                <li><h3 id="alive"></h3></li>
                <li><h3 id="maxGroup"></h3></li>
                <li><h3 id="minGroup"></h3></li>
            </ul>
        </div>
    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script
    src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    var total = document.getElementById('total');
    var killed = document.getElementById('killed');
    var alive = document.getElementById('alive');
    var maxGroup = document.getElementById('maxGroup');
    var minGroup = document.getElementById('minGroup');
    $(document).ready(function () {
        function loadStat() {
            setInterval(() => {
                $.ajax({
                    type: 'get',
                    url: '{{route('sheep.total')}}',
                    success: function (resp) {
                        total.innerHTML = `Total: ${resp}`;
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });

                $.ajax({
                    type: 'get',
                    url: '{{route('sheep.alive')}}',
                    success: function (resp) {
                        alive.innerHTML = `Alive: ${resp}`;
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });

                $.ajax({
                    type: 'get',
                    url: '{{route('sheep.dead')}}',
                    success: function (resp) {
                        killed.innerHTML = `Killed: ${resp}`;
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });

                $.ajax({
                    type: 'get',
                    url: '{{route('group.max')}}',
                    success: function (resp) {
                        maxGroup.innerHTML = `Max group: ${resp}`;
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });

                $.ajax({
                    type: 'get',
                    url: '{{route('group.min')}}',
                    success: function (resp) {
                        minGroup.innerHTML = `Min group: ${resp}`;
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }, 10 * 1000);
        }

        loadStat();
    });


</script>
</body>
</html>
