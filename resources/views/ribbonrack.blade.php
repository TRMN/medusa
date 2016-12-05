<html>
<head>
    <title>Ribbon Rack for {!! $user->getGreeting() !!}
        {!! $user->first_name !!}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }} {!! $user->last_name !!}{{ !empty($user->suffix) ? ' ' . $user->suffix : '' }}{!!$user->getPostnominals()!!}
        , {!!$user->branch!!}</title>
    <style>
        div.ribbons {
            padding-top: 5px;
            width: 315px;
            text-align: center!important;
        }

        div.ribbons img {
            padding-bottom: 1px;
        }

        .ESWP, .OSWP {
            width: 262px;
        }

        .HS {
            height: 60px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body bgcolor="black">
@include('partials.leftribbons', ['user' => $user])
</body>
</html>