
<?php use Absoft\Line\Core\HTTP\Route;
use Absoft\Line\Core\HTTP\ViewResponse;

//ViewResponse::addLayout("/Layouts/header"); ?>
<html>
<head>
    <title>Line Framework</title>
    <link rel="icon" href="./images/zewd_logo_only.png">
    <link rel="stylesheet" href="./css/bootstrap.min.css">

    <style>
        body{
            color: #7f7f7f;
            width: 100vw;
            height: 100vh;
            overflow-x: hidden;
            overflow-y: auto;
            position: relative;
        }
        .image_logo{
            height: 200px;
            position: relative;
            top: 50%;
            transform: translateY(-50%);
        }

        .top_container{
            height: 500px;
        }

        .brand_name{
            /*color: #7f7f7f;*/
            color: #01c98d;
            font-family: "Yu Gothic UI Semibold", "Arial Rounded MT Bold", sans-serif, "Nirmala UI Semilight";
            font-weight: normal;
            font-size: 25px;
            position: relative;

        }
    </style>

</head>
<body>

    <div class="d-flex justify-content-between pl-5 pr-5 pt-3 pb-3" style=" color: #01c98d">
        <span class="brand_name" style="">ZEWD Software</span>

        <div class="d-inline-flex">
            <a class="btn btn-link" href="<?php print Route::address("/first_page"); ?>" >Home <span class="sr-only">(current)</span></a>
            <a class="btn btn-link" href="<?php print Route::address("/about_us"); ?>" >About us</a>
        </div>
    </div>

    <div class="d-flex justify-content-center mb-3 top_container">
        <img src="./images/zewd_white_green.png" class="image_logo" alt="Logo">
    </div>

    <div class="w-100 p-3 rounded" style="background: #7f7f7f;">

        <div class="container" >
            <div class="d-flex">

                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <p>
                                This is a wider card with supporting text below as a natural
                                lead-in to additional content. This content is a little bit longer.
                            </p>
                            <button class="btn btn-success btn-sm" style="background: #01c98d;">simple</button>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <p>
                                This is a wider card with supporting text below as a natural
                                lead-in to additional content. This content is a little bit longer.
                            </p>
                            <button class="btn btn-success btn-sm" style="background: #01c98d;">simple</button>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <p>
                                This is a wider card with supporting text below as a natural
                                lead-in to additional content. This content is a little bit longer.
                            </p>
                            <button class="btn btn-success btn-sm" style="background: #01c98d;">simple</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</body>
</html>
