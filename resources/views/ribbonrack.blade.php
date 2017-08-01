<html>
<head>
    <title>Ribbon Rack for {!! $user->getGreeting() !!}
        {!! $user->first_name !!}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }} {!! $user->last_name !!}{{ !empty($user->suffix) ? ' ' . $user->suffix : '' }}{!!$user->getPostnominals()!!}
        , {!!$user->branch!!}</title>
    <style>
        div.ribbons {
            padding-top: 5px;
            padding-bottom: 10px;
            text-align: center !important;
            white-space: nowrap;
        }

        div.ribbons img {
            padding-bottom: 1px;
        }

        .ribbon {
            width: 105px;
        }

        .citation {
            width: 105px;
            margin-right: -6px;
        }

        div.stripes {
            padding-top: 20px !important;
            padding-bottom: 240px !important;
            border: 1px solid white;
            border-top-left-radius: 125px;
            border-top-right-radius: 125px;
            margin-top: 20px;
        }

        div.unit {
            border: 1px solid white;
            border-top-left-radius: 125px;
            border-top-right-radius: 125px;
            margin-top: 10px;
        }

        div.name-badge-RMN {
            background: #edde9b;
            border: #a08242 2px solid;
            width: 200px;
            height: 50px;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            margin: 0 auto;
            font-family: Optima, Arial, Helvetica, Verdana, Sans Serif;
            font-weight: bold;
            font-size: 24px;
            display: table-cell;
            color: #000000;
            line-height: 1;
            text-transform: uppercase;
            vertical-align: middle;
            white-space: nowrap;
        }

        div.name-badge-GSN {
            background: #000000;
            border: #ffffff 2px solid;
            width: 200px;
            height: 50px;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            margin: 0 auto;
            font-weight: bold;
            font-size: 24px;
            display: table-cell;
            line-height: 1;
            text-transform: uppercase;
            vertical-align: middle;
            color: #ffffff;
            font-family: Optima, Arial, Helvetica, Verdana, Sans Serif;
            white-space: nowrap;
        }

        div.name-badge-wrapper {
            display: table;
            margin: 0 auto;
            width: 316px;
            padding-bottom: 10px;
        }

        div.name-badge-spacer {
            display: table-cell;
            width: 58px !important;
            height: 50px;
        }

        .ESWP, .OSWP {
            width: 262px;
        }

        .MT, .MID, .WS {
            margin-bottom: -175px;
        }

        .HS {
            width: 55px;
            margin-bottom: 10px;
        }

        .SAW, .EAW, .OAW, .ESAW, .OSAW, .EMAW, .OMAW, .ENW, .ONW, .ESNW, .OSNW, .EMNW, .OMNW, .EOW, .OOW, .ESOW, .OSOW, .EMOW, .OMOW, .ESW, .OSW, .ESSW, .OSSW, .EMSW, .OMSW {
            width: 262px;
            margin-bottom: 10px;
        }

        .UNC {
            width: 266px;
            margin-top: 20px;
            margin-bottom: 10px;
            margin-right: 1px;
            transform: rotate(1deg);
        }

        .patch {
            width: 220px;
            margin-top: 20px;
        }

        .patch-with-unc {
            margin-top: -55px;
            margin-left: -4px;
            padding-bottom: 10px !important;
        }

        .branch {
            width: 75%;
        }

        body {
            width: 325px;
        }
    </style>
</head>
<body bgcolor="black">
@include('partials.leftribbons', ['user' => $user])
</body>
</html>