<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>ArtistRiot | Reset Password</title>
        <style type="text/css">
        body {margin: 0; padding: 0; min-width: 100%!important;}
        .content {width: 100%; max-width: 600px;}  
        </style>
    </head>
    <body>
        
		<table width="100%" cellspacing="0" cellpadding="0" style="max-width:600px;border-left:solid 1px #e6e6e6;border-right:solid 1px #e6e6e6">
			<tbody>
			<tr>
			<td valign="middle" align="left" height="50" bgcolor="#00436d" style="background-color:black;padding:0;margin:0">
				<a style="text-decoration:none;outline:none;color:#ffffff;font-size:13px" href="http://artistriot.com/artistriot" target="_blank">
				  <img border="0" height="30" src="http://artistriot.com/artistriot/img/logo_AR.png" alt="Artistriot.com" style="border:none; margin-left: 20px;" >
				</a>
				</td>
			</tr>
			</tbody>
		</table>

		<table width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 40px;max-width:600px;border-left:solid 1px #e6e6e6;border-right:solid 1px #e6e6e6; background-color:white;">
			<tbody>
			<tr>
			<td valign="middle" align="left" height="50" style="background-color:white;padding:0;margin:0;padding-left:20px;">
				Hi <?php  echo $first_name.' '.$last_name; ?>, 
			</td>
			</tr>
			<tr>
				<td style="padding-left:20px;width:100%;">
					<?php echo sprintf(lang('email_forgot_password_subheading'), anchor('auth/reset_password/'. $forgotten_password_code, lang('email_forgot_password_link')));?>
				</td>
			</tr>
			<tr>
				<td style="padding-left:20px;width:100%;">
					<br>
					Cheers,
				</td>
			</tr>
			<tr>
				<td style="padding-left:20px;width:100%;">
					Team ArtistRiot
				</td>
			</tr>	
			</tbody>
			</table>
		<table width="100%" cellspacing="0" cellpadding="0" style="max-width:600px;border-left:solid 1px #e6e6e6;border-right:solid 1px #e6e6e6; background-color:white;">
			<tbody>
			<tr style="background-color:black;">
			<td valign="middle" align="right" height="50" style="padding:0;margin:0;">
				<div style="width:50%;float:left;">
				<a style="text-decoration:none;outline:none;color:#ffffff;font-size:13px" href="https://www.facebook.com/Artist.Riot1" target="_blank">
				  <img border="0" height="30" src="http://artistriot.com/artistriot/img/icons/facebook.png" style="border:none; margin-left: 20px;" >
				</a>
				</div>
				<div style="width:50%;float:left;">
				<a style="text-decoration:none;outline:none;color:#ffffff;font-size:13px" href="https://twitter.com/ArtistRiot" target="_blank">
				  <img border="0" height="30" src="http://artistriot.com/artistriot/img/icons/twitter.png" alt="Artistriot.com" style="border:none;padding-right: 80%" >
				</a>
				</div>
			</td>
				
			</tr>
			</tbody>
		</table>	
		
		
    </body>
</html>