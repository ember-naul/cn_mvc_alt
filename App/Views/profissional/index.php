<?php
use App\Widgets\BaseWidget;
$breadcumb = [
    [
        'title' => 'Profissional',
        'url' => '/profissional/home',
    ],
];
BaseWidget::breadcumb('Profissional', $breadcumb);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <style>
        .content-wrapper {
            padding: 0;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .flex-container {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
        }

        .inter-h1 {
            font-family: 'Inter', sans-serif;
            font-weight: bold;
        }

        .second-line {
            display: block;
            color: #6c757d;
        }

        .jardineiro {
            max-width: 100%;
            height: auto;
        }

        .inter-a {
            text-decoration: none;
            color: #007bff;
        }

        .inter-a:hover {
            text-decoration: underline;
        }

        .titleh1 {
            font-size: 2rem;
        }

        .testep {
            font-size: 1.25rem;
        }

        .teste-2 {
            background-color: #d1d1d1;
            padding: 2rem;
            border-radius: .25rem;
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .btn-dark {
            width: 100%;
            max-width: 300px;
            margin-top: 1rem;
        }

        @media (min-width: 768px) {
            .titleh1 {
                font-size: 2.5rem;
            }

            .testep {
                font-size: 1.5rem;
            }

            .teste-2 {
                padding: 3rem;
            }
        }

        @media (min-width: 992px) {
            .titleh1 {
                font-size: 3rem;
            }

            .testep {
                font-size: 1.75rem;
            }

            .teste-2 {
                min-height: 300px;
                padding: 3rem;
            }
        }

        @media (min-width: 1200px) {
            .titleh1 {
                font-size: 4rem;
            }

            .testep {
                font-size: 2rem;
            }

            .teste-2 {
                max-width: 90%;
                margin: 1rem auto;
            }
        }

        #servicos {
            width: 99.58vw;
            margin-left: calc(-50vw + 50%);
            margin-right: calc(-50vw + 50%);
            padding: 0;
            min-height: 500px;
        }

        #servicos .container {
            padding: 0;
            max-width: 100%;
        }

        #servicos .row {
            margin: 0;
        }

        #sobrenos {
            width: 99.58vw;
            padding: 0;
            height min-height: 500px;
        }
    </style>
</head>

<body>
    <div class="wrapper mt-5">
    </div>
</body>

</html>