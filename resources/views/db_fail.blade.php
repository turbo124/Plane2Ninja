@include('header')

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="text-center">Failed to connect to database</h1>
            </div>
        </div>

        <div class="row">
            <h2 class="text-center">{{ $message }}</h2>
        </div>

        <div class="jumbotron col-md-offset-3 col-md-6 text-center">
            <p class="lead">You need to enter the correct database details in the .env file located in the root of the Plane2Ninja directory. Once you have entered the details, try refreshing this page.</p>

            <p class="lead">
                Values found in .env file <br><br>

                DB_CONNECTION= {{ env('DB_HOST') }}<br>
                DB_HOST= {{ env('DB_CONNECTION') }}<br>
                DB_PORT= {{ env('DB_PORT') }}<br>
                DB_DATABASE= {{ env('DB_DATABASE') }}<br>
                DB_USERNAME= {{ env('DB_USERNAME') }}<br>
                DB_PASSWORD= {{ env('DB_PASSWORD') }}<br>
            </p>
        </div>
    </div>
</body>
