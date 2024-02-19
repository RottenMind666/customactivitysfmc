<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
</head>

<body class="bg-dark">
    <div class="text-center text-white mb-5">
        <h1>Test Custom Activity XCC</h1>
        <img style="width: 128px; height: 128px;" src="https://www.xcconsulting.it/wp-content/uploads/2023/05/logo.png"
            alt="">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <label class="text-white" for="object">Oggetto</label>
                <select class="form-control" name="object" id="object">
                    <option value="Customer">Customer</option>
                    <option value="Audit">Audit</option>
                    <option value="Subscribers">Subscribers</option>
                </select>
            </div>
            <div class="col-6">
                <label class="text-white" for="objectfield">Lista campi</label>
                <select class="form-control" multiple name="objectfield" id="objectfield">
                    <option selected disabled value="ID">ID</option>
                    <option value="Name">Name</option>
                    <option value="Surname">Surname</option>
                    <option value="Email">Email</option>
                    <option value="Phone">Phone</option>
                </select>
            </div>
            <div class="col-12">
                <label class="text-white" for="promocode">Codice Promo</label>
                <select class="form-control" name="promocode" id="promocode">
                    <option value="PROMO20OFF">PROMO20OFF</option>
                    <option value="SAVEMORE15">SAVEMORE15</option>
                    <option value="DEALS4U">DEALS4U</option>
                    <option value="FLASHSALE25">FLASHSALE25</option>
                    <option value="DISCOUNT50NOW">DISCOUNT50NOW</option>
                </select>
            </div>
            <div class="col-12 mt-3">
                <div class="row text-center">
                    <button class="btn btn-dark fw-bold" style="border: 1px solid #EFE43D; color: #EFE43D;">SALVA
                        CONFIGURAZIONE</button>
                </div>
            </div>
            <div class="col-12">
                <button id="testapi" class="btn btn-success"> Test API </button>
            </div>
        </div>
    </div>
</body>
<script>
    $('#testapi').on('click', () => {
        $.ajax({
            type: 'GET',
            url: "{{route('gnoccoallasorrentina')}}",
            data: {},
            success: function(response) {
                console.log(response);
                // Gestisci la risposta qui
            },
            error: function(error) {
                console.error(error);
                // Gestisci gli errori qui
            }
        });
    });
</script>

</html>
