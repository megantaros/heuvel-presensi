<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Print</title>
    <style type="text/css">
        body {
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            margin: 0;
            padding: 20px;
            color: #333;
            font-size: 12pt !important;
        }

        .print-container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 20px;
            width: 100%;
        }

        .header img {
            width: 130px;
        }

        .header h4 {
            margin: 0;
            font-weight: 600;
        }

        .header p {
            margin: 0;
        }

        .content {
            text-align: center;
            margin-bottom: 20px;
        }

        .content h4 {
            margin: 0;
            font-weight: 700;
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
                font-size: 10pt !important;
                margin: 0;
                padding: 0;
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
            <img src="{{ public_path('img/logo/logo.png') }}" alt="Logo">
            <div>
                <h4>Heuvel Tribe</h4>
                <p>Office: Dorowati No.9, Karangsari, Wedomartani, Ngemplak, Sleman<br> 
                   Daerah Istimewa Yogyakarta<br>
                   <span>Phone: 0274-887744</span><br>
                   <span>Email: heuvelcloth@gmail.com</span>
                </p>
            </div>
        </div>

        <hr>

        @yield('content')
    </div>
  </body>
</html>
