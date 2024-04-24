{{-- <div>
    <div id="printdiv">
        @php
            $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        @endphp
        <div class="row mt-4">
            @for ($i = 0; $i < $printcount; $i++)
                <div class="col-md-3">
                    {{ strval($uniqid) }}
                    <div>{!! DNS2D::getBarcodeHTML(strval($uniqid), 'PHARMA2T', 3, 33, 'green', true) !!}</div>
                </div>
            @endfor
        </div>
    </div>
    <script>
        function printreceipt() {
            var printContents = document.getElementById('printdiv').innerHTML;
            var print = document.body.innerHTML = printContents;
            window.print();
            window.onafterprint = window.close;
        }
        window.onload = printreceipt();
    </script>
</div> --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inpatient Barcode</title>

</head>

<body>

    <div id="printdiv">
        <div class="row mt-4">
            @for ($i = 0; $i < $printcount; $i++)
                <div class="col-md-3">
                    {{ strval($uniqid) }}
                    <div>{!! DNS2D::getBarcodeHTML(strval($uniqid), 'PHARMA2T', 3, 33, 'green', true) !!}</div>
                </div>
            @endfor
        </div>
    </div>
    <script>
        function printreceipt() {
            var printContents = document.getElementById('printdiv').innerHTML;
            var print = document.body.innerHTML = printContents;
            window.print();
            window.onafterprint = window.close;
        }
        window.onload = printreceipt();
    </script>
</body>

</html>
