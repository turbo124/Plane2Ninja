@include('header')

<body>

    <div class="container-fluid">
        <div class="row text-center"><h1>Export Data</h1></div>
        <div class="row col-md-offset-4 col-md-4" style="margin-top:20px;"><button type="button" class="btn btn-primary btn-lg btn-block" id="clients">Download Clients</button></div>
        <div class="row col-md-offset-4 col-md-4" style="margin-top:20px;"><button type="button" class="btn btn-info btn-lg btn-block" id="products">Download Products</button></div>
        <div class="row col-md-offset-4 col-md-4" style="margin-top:20px;"><button type="button" class="btn btn-warning btn-lg btn-block" id="invoices">Download Invoices</button></div>
        <div class="row col-md-offset-4 col-md-4" style="margin-top:20px;"><button type="button" class="btn btn-danger btn-lg btn-block" id="quotes">Download Quotes</button></div>
    </div>

</body>

@include('footer')


<script>

    $('.btn').click('click', function() {


        window.location.href = '/crunch/' + this.id;


    });

</script>