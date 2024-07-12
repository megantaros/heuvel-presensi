<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Print</title>
    <style>
        body {
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .print-container {
            width: 100%;
            margin: 0 auto;
            /* padding: 20px; */
        }

        .header {
            margin-bottom: 20px;
            overflow: hidden;
        }

        .header .header-img {
            float: left;
            width: 200px;
            margin-right: 20px;
        }

        .header .header-img img {
            width: 100%;
        }

        .header .header-text {
            float: left;
            width: calc(100% - 150px);
        }

        .header h4 {
            margin: 0;
            font-weight: 600;
            font-size: 18pt;
        }

        .header p {
            margin: 0;
            font-size: 10pt;
        }

        .content {
            text-align: center;
            margin-bottom: 20px;
        }

        .content h4 {
            margin: 0;
            font-weight: 700;
            font-size: 14pt;
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 10px;
            text-align: left;
            font-size: 10pt;
        }

        th {
            background-color: #f1f1f1;
            text-align: center;
        }

        td.text-center {
            text-align: center;
        }

        @media print {
            body {
                font-size: 10pt;
                margin: 0;
                padding: 30px;
            }
            .print-container {
                padding: 10px;
            }
            .header, .content, table {
                margin: 0;
                width: 100%;
            }
            th, td {
                padding: 5px;
            }
        }
    </style>
  </head>
  <body>
    <div class="print-container">
        <div class="header">
            <div class="header-img">
                {{-- <img src="{{ public_path('img/logo/logo.png') }}" alt="Logo"> --}}
                <img src="{{ asset('img/logo/logo.png') }}" alt="Logo" style="height: 80px;">
            </div>
            <div>
                <h4>Heuvel Tribe</h4>
                <p>Office: Dorowati No.9, Karangsari, Wedomartani, Ngemplak, Sleman</p>  
                <p>Daerah Istimewa Yogyakarta</p>    
                <p>Phone: 0274-887744</p>   
                <p>Email: heuvelcloth@gmail.com</p>
            </div>
        </div>

        <hr>

        @yield('content')
    </div>

    <script>window.print()</script>
  </body>
</html>
