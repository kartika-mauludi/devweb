<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title>Request Withdraw</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <style>
     body{
    background:#eee;
    margin-top:20px;
    }
/*# sourceMappingURL=bootstrap.css.map */
/* ===bootstrap== */

    .text-danger strong {
                color: #9f181c;
            }
            .receipt-main {
                background: #ffffff none repeat scroll 0 0;
                border-bottom: 12px solid #0135A3;
                border-top: 12px solid #007BFF;
                margin-top: 50px;
                margin-bottom: 50px;
                padding: 40px 30px !important;
                position: relative;
                box-shadow: 0 1px 21px #acacac;
                color: #333333;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            .receipt-main p {
                color: #333333;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                line-height: 1.42857;
            }
            .receipt-footer h1 {
                font-size: 15px;
                font-weight: 400 !important;
                margin: 0 !important;
            }
            .receipt-main::after {
                background: #0135A3 none repeat scroll 0 0;
                content: "";
                height: 5px;
                left: 0;
                position: absolute;
                right: 0;
                top: -13px;
            }
            .receipt-main thead {
                background: #414143 none repeat scroll 0 0;
            }
            .receipt-main thead th {
                color:#fff;
            }
            .receipt-right h5 {
                font-size: 16px;
                font-weight: bold;
                margin: 0 0 7px 0;
            }
            .receipt-right p {
                font-size: 12px;
                margin: 0px;
            }
            .receipt-right p i {
                text-align: center;
                width: 18px;
            }
            .receipt-main td {
                padding: 9px 20px !important;
            }
            .receipt-main th {
                padding: 13px 20px !important;
            }
            .receipt-main td {
                font-size: 13px;
                font-weight: initial !important;
            }
            .receipt-main td p:last-child {
                margin: 0;
                padding: 0;
            }	
            .receipt-main td h2 {
                font-size: 20px;
                font-weight: 900;
                margin: 0;
                text-transform: uppercase;
            }
            .receipt-header-mid .receipt-left h1 {
                font-weight: 100;
                margin: 34px 0 0;
                text-align: right;
                text-transform: uppercase;
            }
            .receipt-header-mid {
                margin: 24px 0;
                overflow: hidden;
            }
            
            #container {
                background-color: #dcdcdc;
            }
            .btn{
                background-color: #04AA6D; /* Green */
                border: none;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                border-radius: 10px;
            }
            .m3 {
                margin: 20px;
            }
    th, td {
  border-bottom: 1px solid #ddd;
}
</style>
</head>
<body>

        <div style="width:80%; margin:auto;">
    			<div class="receipt-header">
						<div class="receipt-left">
							<h1 class="sitename">Databaseriset</h1>
							<!-- <img class="img-responsive" alt="iamgurdeeposahan" src="https://bootdey.com/img/Content/avatar/avatar6.png" style="width: 71px; border-radius: 43px;"> -->
						</div>
					</div>
				
			<h2>Request withdraw</h2>
            <h3>
                Customer  {{ $data['user']->name }} mengajukan penarikan affiliator sejumlah Rp {{  number_format($data["amount"] , 0, ",", ".")  }}, berikut detail dari customer
             
            </h3>
            <div style="justify-content: center;"></div>

            <table class="table table-hover" style="overflow:scroll ;padding: 0.25rem 0.25rem;">
            <tr>
                <th style="text-align:left; font-size: 0.8rem; padding: 0.25rem 0.25rem; ">Nama</th>
                <td style="font-size: 0.8rem;">{{ $data['user']->name }}</h3>    
            </tr>
            <tr>
                <th style="text-align:left; font-size: 0.8rem; padding: 0.25rem 0.25rem;">Nama Bank</th>
                <td style="font-size: 0.8rem;">{{ $data['user']->bank_name }}</td>
            </tr>
            <tr>
                <th style="text-align:left; font-size: 0.8rem; padding: 0.25rem 0.25rem;">Atas Nama Rekening</th>
                <td style="font-size: 0.8rem;">{{ $data['user']->bank_name_account }}</td>
            </tr>
            <tr>
                <th style="text-align:left; font-size: 0.8rem; padding: 0.25rem 0.25rem;">Nomor Rekening</th>
                <td style="font-size: 0.8rem;">{{ $data["user"]->bank_account }}</td>
            </tr>
            <tr>
                <th style="text-align:left; font-size: 0.8rem; padding: 0.25rem 0.25rem;">Nomor HP</th>
                <td style="font-size: 0.8rem;">{{ $data["user"]->nomor }}</td>
            </tr>
            <tr>
                <th style="text-align:left; font-size: 0.8rem; padding: 0.25rem 0.25rem;">Jumlah Penarikan</th>
                <td style="font-size: 0.8rem;">Rp. {{  number_format($data["amount"] , 0, ",", ".")  }}</td>
            </tr>
            </table>

            </div>
        </div>    
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
	
</script>
</body>
</html>