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
            <div class="container-fluid row" id="elements">

            </div>
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
    var elements = document.getElementById('elements');
    var dayContainer = document.getElementById('day');
    var groups = [];
    $(document).ready(function () {
        function loadAllGroupWithSheep() {
            $.ajax({
                type: 'get',
                url: '{{route('group.index')}}',
                success: function (resp) {
                    getDay();
                    drawGroups(resp);
                    startShuffle();
                },
                error: function (err) {
                    console.log(err);
                }
            })
        }

        function drawGroups(resp) {
            var res = '';

            for (var i = 0; i < resp.length; i++) {
                res += drawGroup(resp[i]);
            }
            elements.innerHTML = res;
        }


        function drawGroup(group) {
            return `<div class='card col-3 m-1' >
                   <div class="card-header">
                        <p class='card-title'>${group.id} : ${group.name}</p>
                    </div>
                    <div class="card-body" id="group${group.id}">
                        ` +
                drawAllSheep(group.sheep)
                + `
                    </div>
              </div>`;
        }

        function drawAllSheep(sheep) {
            var res = '';

            for (var i = 0; i < sheep.length; i++) {
                res += `<p id='sheep${sheep[i].id}'>${sheep[i].name}</p>`;
            }

            return res;
        }

        function startShuffle() {
            setInterval(() => {
                $.ajax({
                    type: 'get',
                    url: '{{route('shuffle.group')}}',
                    success: function (resp) {
                        drawGroups(resp);
                    },
                    error: function (err) {
                        console.log(err);
                    }
                })
            }, 10 * 1000);
        }

        function getDay() {
            setInterval(() => {
                $.ajax({
                    type: 'get',
                    url: '{{route('day')}}',
                    success: function (resp) {
                        drawDay(resp);
                    },
                    error: function (err) {
                        console.log(err);
                    }
                })
            }, 10 * 1000);
        }

        function drawDay(day) {
            if (day % 10 === 0) {
                dayContainer.innerHTML = `Days count: ${day}. Meat day`;
            } else {
                dayContainer.innerHTML = `Days count: ${day}`;
            }
        }

        loadAllGroupWithSheep();


    });


</script>
</body>
</html>
