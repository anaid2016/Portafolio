<?php
					include("phpmailer/class.phpmailer.php");
					include("phpmailer/class.smtp.php");
					$campos=$_POST["codigo"];
					$_SESSION['estado']="3";
					$_SESSION['ordenventa']="";
				
				
					 $opfileb=fopen("porque.txt","w");
						fwrite($opfileb, 'Aqui llega \n');
						fclose($opfileb);
						
					$mail = new PHPMailer();
					$mail->IsSMTP();
					
					$mail->SMTPAuth = true;
					$mail->SMTPSecure = "ssl";
					$mail->Host = "smtp.gmail.com";
					$mail->Port = 465;
					$mail->Username = "anaid0410@gmail.com";
					$mail->Password = "GABRIEL2016";
			
					$mensaje   = "<font color='#3CA47F'><b><i>Bueno Dias:</i></b></font><br>\n";
					$mensaje.="<font color='#3CA47F'>Para ver su Factura de Compra por favor dar clic aqui <a href='http://127.0.0.1/proveedor/pages/factorden.php?orden=".$campos."'>Orden de Compra Virtual</a></font><br>\n";
										
					$mensaje.='<a href="http://uis.edu.co/">UIS - Universidad Industrial de Santander</a>';
									
					$para="anaid85_84@hotmail.com";
					$titulo=' Orden de Venta';
					$mail->From = "anaid0410@gmail.com";
					$mail->FromName = "Sistema Proveedor";
					$mail->Subject = $titulo;
					$mail->AltBody = $mensaje;
					$mail->MsgHTML($mensaje);
					$mail->AddAddress($para, "Usuario UIS");
					$mail->IsHTML(true);
		 
					if(!$mail->Send()) {
					  return "Error: " . $mail->ErrorInfo."\n";
					  
					  $opfileb=fopen("porque.txt","w");
						fwrite($opfileb, $mail->ErrorInfo);
						fclose($opfileb);
					} else {
					  return "Mensaje enviado correctamente al usuario";
					  
					  $opfileb=fopen("porque.txt","w");
						fwrite($opfileb, 'Si trata de enviar correo');
						fclose($opfileb);
					}	

?>