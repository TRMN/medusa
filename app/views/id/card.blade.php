<!DOCTYPE html>
<html>
<head>
    <style>
        @media print {
            @page {
                margin: 0in;
                width: 3.36in;
            }

            body {
                width: 3.36in;
                margin: 0in;
            }

            img {
                width: 3.36in;
                height: 2.05in;
            }
        }
    </style>
</head>
<body bgcolor="#000000">
<div style="page-break-before: always"><img src="data:image/png;base64, {{{ base64_encode($card->encode('png')) }}}"></div>
<div style="page-break-before: always"><img src="{{asset('images/TRMN-membership-card-back.png')}}"></div>
</body>
</html>
