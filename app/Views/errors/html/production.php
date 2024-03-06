<!-- =======================================================
      * CMS DATAGOE
      * Content Management System.
      *
      * @author			Vian Taum <viantaum17@gmail.com>
      * @website		www.datagoe.com
      * @copyright		(c) 2023 - Datagoe Software
 ======================================================== -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= lang('Errors.whoops') ?></title>
    <meta content="CMS DATAGOE" name="Vian Taum" />

    <link rel="shortcut icon" href="<?= base_url('/public/img/konfigurasi/icon/default.png') ?>">
    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Maven+Pro:400,900" rel="stylesheet">

    <!-- Custom stlylesheet -->

    <style>
        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {
            background: #fafafa;
            padding: 0;
            margin: 0;
        }

        #notfound {
            position: relative;
            height: 100vh;
        }

        #notfound .notfound {
            position: absolute;
            left: 50%;
            top: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .notfound {
            max-width: 920px;
            width: 100%;
            line-height: 1.4;
            text-align: center;
            padding-left: 15px;
            padding-right: 15px;
        }

        .notfound .notfound-404 {
            position: absolute;
            height: 100px;
            top: 0;
            left: 50%;
            -webkit-transform: translateX(-50%);
            -ms-transform: translateX(-50%);
            transform: translateX(-50%);
            z-index: -1;
        }

        .notfound .notfound-404 h1 {
            font-family: 'Maven Pro', sans-serif;
            color: #ececec;
            font-weight: 900;
            font-size: 276px;
            margin: 0px;
            position: absolute;
            left: 50%;
            top: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .notfound h2 {
            font-family: 'Maven Pro', sans-serif;
            font-size: 30px;
            color: #000;
            font-weight: 900;
            text-transform: uppercase;
            margin: 0px;
        }

        .notfound p {
            font-family: 'Maven Pro', sans-serif;
            font-size: 16px;
            color: #b81010;
            font-weight: 400;
            text-transform: uppercase;
            margin-top: 15px;
        }

        .notfound a {
            font-family: 'Maven Pro', sans-serif;
            font-size: 14px;
            text-decoration: none;
            text-transform: uppercase;
            background: #ec310e;
            display: inline-block;
            padding: 9px 38px;
            border: 2px solid transparent;
            border-radius: 40px;
            color: #fff;
            font-weight: 400;
            -webkit-transition: 0.2s all;
            transition: 0.2s all;
        }

        .notfound a:hover {
            background-color: #fff;
            border-color: #ec310e;
            color: #ec310e;
        }

        @media only screen and (max-width: 480px) {
            .notfound .notfound-404 h1 {
                font-size: 162px;
            }

            .notfound h2 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

    <div id="notfound">
        <div class="notfound">
            <div class="notfound-404">
                <h1>Error</h1>
            </div>
            <h2>Mohon maaf!</h2>
            <p class="text-danger">
                Situs tampaknya mengalami masalah. Akan segera kami Atasi. <br> Silahkan coba lagi nanti..!
            </p>
            <a href="https://wa.me/081353967028" target="_blank">Hubungi kami</a>
        </div>
    </div>

</body>

</html>