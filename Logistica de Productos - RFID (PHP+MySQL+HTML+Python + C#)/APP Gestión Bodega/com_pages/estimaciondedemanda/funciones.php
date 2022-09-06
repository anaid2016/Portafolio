<?php

function suavexpsimple($yearmenor,$year,$mesactual2,$mesactual,$intro0,$vinformacion,$alfa){
	 $daysprom=0;
	 $xnew=array();
	 $pronosticos=1;
	 $error=0;
	 
	 for($b=$yearmenor;$b<=$year;$b++){
			
		$ini=($b==$yearmenor)? (int)$mesactual2:1;
		$fin=($b==$year)? (int)$mesactual:12;
		
		
		
		for($c=$ini;$c<=$fin;$c++){
			   
		   //$vinformacion[$intro0][$b][$c]=(!isset($vinformacion[$intro0][$b][$c]))? 0:$vinformacion[$intro0][$b][$c];
			  
			    if(isset($vinformacion[$intro0][$b][$c])){
					
					$vinformacion[$intro0][$daysprom]=$vinformacion[$intro0][$b][$c];
					if($daysprom==1){
						$xnew[$daysprom]=$vinformacion[$intro0][$daysprom];
					}
					$daysprom+=1;
			   }
		}
	 }
	 
	 if($daysprom<=1){
	 	return "NHA";
	 }else{
		 for($r=2;$r<$daysprom;$r++){
			$ant=$r-1;
			$xnew[$r]=($alfa*$vinformacion[$intro0][$r])+(1-$alfa)*($xnew[$ant]);
			$ult_x=$xnew[$r];
			$error=abs($vinformacion[$intro0][$r]-$xnew[$ant]);
		}
			

		$vdatos[0]=$ult_x;
		$vdatos[1]=$error;
		return $vdatos;
	}
}



function suavhotltende($yearmenor,$year,$mesactual2,$mesactual,$intro0,$vinformacion,$alfa,$beta,$meses){
	 $daysprom=0;
	 $xnew=array();
	 $pronosticos=$meses;
	 $error=0;
	 $ult_x=0;
	 
	 for($b=$yearmenor;$b<=$year;$b++){
			
		$ini=($b==$yearmenor)? (int)$mesactual2:1;
		$fin=($b==$year)? (int)$mesactual:12;
		
		for($c=$ini;$c<=$fin;$c++){
			   
		   //$vinformacion[$intro0][$b][$c]=(!isset($vinformacion[$intro0][$b][$c]))? 0:$vinformacion[$intro0][$b][$c];
			  
			   if(isset($vinformacion[$intro0][$b][$c])){
					$vinformacion[$intro0][$daysprom]=$vinformacion[$intro0][$b][$c];
					if($daysprom==1){
						$xnew[$daysprom]=$vinformacion[$intro0][$daysprom];
						$m[$daysprom]=$vinformacion[$intro0][$daysprom]-$vinformacion[$intro0][0];
						
					}
					$daysprom+=1;
			   }
		}
	 }
	 
	 if($daysprom<=1){
	 	return "NHA";
	 }else{
		 //CALCULOS ----------------------------------------------------------------------------------
		 for($r=2;$r<$daysprom;$r++){
				$ant=$r-1;
				
				$xnew[$r]=($alfa*$vinformacion[$intro0][$r])+(1-$alfa)*($xnew[$ant]+$m[$ant]);
				$m[$r]=$beta*($xnew[$r]-$xnew[$ant])+(1-$beta)*($m[$ant]);
			
				$ult_x=$xnew[$r];
				$ult_m=$m[$r];
				$error=abs($vinformacion[$intro0][$r]-$xnew[$ant]);
		}
			
		
		for($p=0;$p<$pronosticos;$p++){
			$sig=$daysprom+$p;
			$xnew[$sig]=$ult_x+($ult_m*($p+1));
		}
			
		$vdatos[0]=$xnew[$sig];
		$vdatos[1]=$error;
		return $vdatos;
	}
}



function suavhotlwintmultiplicativo($yearmenor,$year,$mesactual2,$mesactual,$intro0,$vinformacion,$alfa,$beta,$gama,$meses){

	 $sum12periodos=0;
	 $summeses=array();
	 $xnew=array();
	 $daysprom=0;
	 $cuenta=0;
	 $pronosticos=$meses;
	 $s=12;
	 $error=0;
	 $ult_x="";
	 $ult_m="";
	 
	 for($b=$yearmenor;$b<=$year;$b++){
				
				//Calculo del tiempo de inicio y el promedio para primer valor de la serie......
				$ini=($b==$yearmenor)? (int)$mesactual2:1;
				$fin=($b==$year)? (int)$mesactual:12;
		
				
				for($c=$ini;$c<=$fin;$c++){
				
					   if(!empty($vinformacion[$intro0][$b][$c])){
						   
					   		 $vinformacion[$intro0][$daysprom]=$vinformacion[$intro0][$b][$c];
					  
					   		if($daysprom<12){
								$sum12periodos=$sum12periodos+$vinformacion[$intro0][$b][$c];
					   		}
					   
							/*if($daysprom>12 and $daysprom<=24){
								$sum24periodos=$sum24periodos+$vinformacion[$intro0][$b][$c];
						   }*/
						   
							$daysprom+=1;
					   }else{
						   $vinformacion[$intro0][$daysprom]=0.01;
						   
						   if($daysprom<12){
								$sum12periodos=$sum12periodos+0.01;
					   		}
							$daysprom+=1;
					   }

				}
		 }
	 
	 if($daysprom<$s){
		return $vdatos[0]="NHA"; 
	 }else{
	 
		$promedio=$sum12periodos/12;		//Promedio año 1
		$m[11]=0;
		$xnew[11]=$promedio;
						
		for($r=0;$r<$daysprom;$r++){
			$ant=$r-1;
			$secu=$r-$s;
		
		 if($vinformacion[$intro0][$r]>1){	
			if($r<$s){
				$festaciones[$r]=$vinformacion[$intro0][$r]/$promedio;	
			}else{
					$xnew[$r]=$alfa*($vinformacion[$intro0][$r]/$festaciones[$secu])+(1-$alfa)*($xnew[$ant]+$m[$ant]);
					$m[$r]=$beta*($xnew[$r]-$xnew[$ant])+(1-$beta)*($m[$ant]);
					$festaciones[$r]=$gama*(($vinformacion[$intro0][$r]/$xnew[$r]))+(1-$gama)*$festaciones[$secu];
					$ult_x=$xnew[$r];
					$ult_m=$m[$r];
					$error=abs($vinformacion[$intro0][$r]-$xnew[$ant]);
			}
		 }else{
			return $vdatos[0]="NHA";  
		 }
		}
		
		for($p=0;$p<$pronosticos;$p++){
			$secupron=($daysprom+$p)-($s);
			$sig=$daysprom+$p;
			$xnew[$sig]=($ult_x+($ult_m*($p+1)))*$festaciones[$secupron];
		}
		
		$prueba=$daysprom+$pronosticos-1;
		$vdatos[0]=$xnew[$prueba];
		$vdatos[1]=$error;
		
		return $vdatos;
	 }
				 
}
	 


function suavhotlwintaditivo($yearmenor,$year,$mesactual2,$mesactual,$intro0,$vinformacion,$alfa,$beta,$gama,$meses){

	 $sum12periodos=0;
	 $summeses=array();
	 $daysprom=0;
	 $cuenta=0;
	 $pronosticos=$meses;
	 $s=12;
	 $error=0;
	 $ult_x="";
	 $ult_m="";
	 
	 for($b=$yearmenor;$b<=$year;$b++){
				
				//Calculo del tiempo de inicio y el promedio para primer valor de la serie......
				$ini=($b==$yearmenor)? (int)$mesactual2:1;
				$fin=($b==$year)? (int)$mesactual:12;
		
				
				for($c=$ini;$c<=$fin;$c++){
				
					   if(!empty($vinformacion[$intro0][$b][$c])){
						   
					   		 $vinformacion[$intro0][$daysprom]=$vinformacion[$intro0][$b][$c];
					  
					   		if($daysprom<12){
								$sum12periodos=$sum12periodos+$vinformacion[$intro0][$b][$c];
					   		}
					   
							/*if($daysprom>12 and $daysprom<=24){
								$sum24periodos=$sum24periodos+$vinformacion[$intro0][$b][$c];
						   }*/
						   
							$daysprom+=1;
					   }else{
						   $vinformacion[$intro0][$daysprom]=0;
						   
						   if($daysprom<12){
								$sum12periodos=$sum12periodos+0;
					   		}
							$daysprom+=1;
					   }

				}
		 }
	 
	 if($daysprom<$s){
		return $vdatos[0]="NHA"; 
	 }else{
	 
		$promedio=$sum12periodos/12;		//Promedio año 1
		$m[11]=0;
		$xnew[11]=$promedio;
						
		for($r=0;$r<$daysprom;$r++){
			$ant=$r-1;
			$secu=$r-$s;
			if($vinformacion[$intro0][$r]>1){
				if($r<$s){
					$festaciones[$r]=$vinformacion[$intro0][$r]-$promedio;		
				}else{
					$xnew[$r]=$alfa*($vinformacion[$intro0][$r]-$festaciones[$secu])+(1-$alfa)*($xnew[$ant]+$m[$ant]);
					$m[$r]=$beta*($xnew[$r]-$xnew[$ant])+(1-$beta)*($m[$ant]);
					$festaciones[$r]=$gama*(($vinformacion[$intro0][$r]-$xnew[$r]))+(1-$gama)*$festaciones[$secu];
					$ult_x=$xnew[$r];
					$ult_m=$m[$r];
					$error=abs($vinformacion[$intro0][$r]-$xnew[$ant]);
				}
			}else{
				return $vdatos[0]="NHA"; 
			}
		}
		
		for($p=0;$p<$pronosticos;$p++){
			$secupron=($daysprom+$p)-($s);
			$sig=$daysprom+$p;
			$xnew[$sig]=$ult_x+($ult_m*($p+1))+$festaciones[$secupron];
		}
		
		$prueba=$daysprom+$pronosticos-1;
		$vdatos[0]=$xnew[$prueba];
		$vdatos[1]=$error;

		return $vdatos;
	 }
				 
}		



?>