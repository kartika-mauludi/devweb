<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
 <link rel="stylesheet" href="{{ asset('assets/css/mail.css') }}">
</head>
<body>
<div class="col-md-12">   
 <div class="row">
		
        <div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
            <div class="row">
    			<div class="receipt-header">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="receipt-left">
							<h2 class="sitename">Databaseriset</h2>
						</div>
					</div>
				
				</div>
            </div>
			
			<h3>Hai {{ $data['name']  }}</h3>
			<h4>Kamu menerima email ini karena, Kamu masih belum melakukan pembayaran</h4>
			
			<h4>Silahkan melanjutkan pembayaran kamu</h4> 
			<h4><p class="text-center">Jika Anda memiliki pertanyaan, hubungi kami melalui WhatsApp di <a href="https://wa.me/6285236868125">+62 852-3686-8125</a></p></h4>

			
        </div>    
	</div>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
	
</script>
</body>
</html>