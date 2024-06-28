<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TutorWand Question Paper</title>
    <link rel="apple-touch-icon" href="{{ asset('assets/images/teachers/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/teachers/favicon.png') }}" />
    <style>
        body {
            margin: 0px;
        }
        
        .resp-iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="resp-container">
        <iframe class="resp-iframe" frameBorder="0" align="top" src="{{ $paperUrl }}" scrolling="no"></iframe>
    </div>
</body>
</html>
