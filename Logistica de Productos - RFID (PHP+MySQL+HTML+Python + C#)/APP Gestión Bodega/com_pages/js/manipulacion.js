$(document).ready(function(){

	document.getElementById('cantidad').value=1; 

	$(document).on('click','caption',function(){
		//obtener la tabla que contiene el caption clickeado
		var objTabla=$(this).parent();
			//el cuerpo de la tabla esta visible?
			//lo siguiente es unicamente para cambiar el icono del caption
			if(objTabla.find('tbody').is(':visible')){
				//eliminamos la clase clsContraer
				$(this).removeClass('clsContraer');
				//agregamos la clase clsExpandir
				$(this).addClass('clsExpandir');
			}else{
				//eliminamos la clase clsExpadir
				$(this).removeClass('clsExpandir');
				//agregamos la clase clsContraer
				$(this).addClass('clsContraer');
			}
			//mostramos u ocultamos el cuerpo de la tabla
			objTabla.find('tbody').toggle();
	});
		
	//evento que se dispara al hacer clic en el boton para agregar una nueva fila
	$(document).on('click','.clsAgregarFila',function(){
	
		/*obtener el cuerpo de la tabla; contamos cuantas filas (tr) tiene
		si queda solamente una fila le preguntamos al usuario si desea eliminarla*/
		var objCuerpo=$(this).parents().get(2);
		var conteo=$(objCuerpo).find('tr').length;
		var real=conteo+1;
		document.getElementById('cantidad').value=real; 
		
		anterior=document.getElementById('cantidad2').value;
		document.getElementById('cantidad2').value=parseInt(anterior)+1;
		
		if((parseInt(anterior)+1)>real){
			real=parseInt(anterior)+1;	
		}
		
		//almacenamos en una variable todo el contenido de la nueva fila que deseamos
		//agregar. pueden incluirse id's, nombres y cualquier tag... sigue siendo html
		var strNueva_Fila='<tr id="linea'+real+'">'+
			'<input type="hidden" name="idp'+real+'" value="" id="idpr'+real+'">'+	
			'<td><input type="text" class="clsAnchoTotal" name="a'+real+'" id="tags"></td>'+
			'<td><input type="text" class="clsAnchoTotal" name="b'+real+'" ></td>'+
			'<td><input type="text" class="clsAnchoTotal" name="c'+real+'" ></td>'+
			'<td><select name="d'+real+'">'+
					'<option value="1">OTRO-EXTERIOR</option>'+
					'<option value="25">ANTIOQUIA-MEDELLIN</option>'+
					'<option value="5002">ANTIOQUIA-ABEJORRAL</option>'+
					'<option value="5004">ANTIOQUIA-ABRIAQUI</option>'+
					'<option value="5021">ANTIOQUIA-ALEJANDRIA</option>'+
					'<option value="5030">ANTIOQUIA-AMAGA</option>'+
					'<option value="5031">ANTIOQUIA-AMALFI</option>'+
					'<option value="5034">ANTIOQUIA-ANDES</option>'+
					'<option value="5036">ANTIOQUIA-ANGELOPOLIS</option>'+
					'<option value="5038">ANTIOQUIA-ANGOSTURA</option>'+
					'<option value="5040">ANTIOQUIA-ANORI</option>'+
					'<option value="5042">ANTIOQUIA-SANTA FE DE ANTIOQUIA</option>'+
					'<option value="5044">ANTIOQUIA-ANZA</option>'+
					'<option value="5045">ANTIOQUIA-APARTADO</option>'+
					'<option value="5051">ANTIOQUIA-ARBOLETES</option>'+
					'<option value="5055">ANTIOQUIA-ARGELIA</option>'+
					'<option value="5059">ANTIOQUIA-ARMENIA</option>'+
					'<option value="5079">ANTIOQUIA-BARBOSA</option>'+
					'<option value="5086">ANTIOQUIA-BELMIRA</option>'+
					'<option value="5088">ANTIOQUIA-BELLO</option>'+
					'<option value="5091">ANTIOQUIA-BETANIA</option>'+
					'<option value="5093">ANTIOQUIA-BETULIA</option>'+
					'<option value="5101">ANTIOQUIA-CIUDAD BOLIVAR</option>'+
					'<option value="5107">ANTIOQUIA-BRICEY0</option>'+
					'<option value="5113">ANTIOQUIA-BURITICA</option>'+
					'<option value="5120">ANTIOQUIA-CACERES</option>'+
					'<option value="5125">ANTIOQUIA-CAICEDO</option>'+
					'<option value="5129">ANTIOQUIA-CALDAS</option>'+
					'<option value="5134">ANTIOQUIA-CAMPAMENTO</option>'+
					'<option value="5138">ANTIOQUIA-CAÃƒâ€˜ASGORDAS</option>'+
					'<option value="5142">ANTIOQUIA-CARACOLI</option>'+
					'<option value="5145">ANTIOQUIA-CARAMANTA</option>'+
					'<option value="5147">ANTIOQUIA-CAREPA</option>'+
					'<option value="5148">ANTIOQUIA-CARMEN DE VIBORAL</option>'+
					'<option value="5150">ANTIOQUIA-CAROLINA</option>'+
					'<option value="5154">ANTIOQUIA-CAUCASIA</option>'+
					'<option value="5172">ANTIOQUIA-CHIGORODO</option>'+
					'<option value="5190">ANTIOQUIA-CISNEROS</option>'+
					'<option value="5197">ANTIOQUIA-COCORNA</option>'+
					'<option value="5206">ANTIOQUIA-CONCEPCION</option>'+
					'<option value="5209">ANTIOQUIA-CONCORDIA</option>'+
					'<option value="5212">ANTIOQUIA-COPACABANA</option>'+
					'<option value="5234">ANTIOQUIA-DABEIBA</option>'+
					'<option value="5237">ANTIOQUIA-DON MATIAS</option>'+
					'<option value="5240">ANTIOQUIA-EBEJICO</option>'+
					'<option value="5250">ANTIOQUIA-EL BAGRE</option>'+
					'<option value="5264">ANTIOQUIA-ENTRERRIOS</option>'+
					'<option value="5266">ANTIOQUIA-ENVIGADO</option>'+
					'<option value="5282">ANTIOQUIA-FREDONIA</option>'+
					'<option value="5284">ANTIOQUIA-FRONTINO</option>'+
					'<option value="5306">ANTIOQUIA-GIRALDO</option>'+
					'<option value="5308">ANTIOQUIA-GIRARDOTA</option>'+
					'<option value="5310">ANTIOQUIA-GOMEZ PLATA</option>'+
					'<option value="5313">ANTIOQUIA-GRANADA</option>'+
					'<option value="5315">ANTIOQUIA-GUADALUPE</option>'+
					'<option value="5318">ANTIOQUIA-GUARNE</option>'+
					'<option value="5321">ANTIOQUIA-GUATAPE</option>'+
					'<option value="5347">ANTIOQUIA-HELICONIA</option>'+
					'<option value="5353">ANTIOQUIA-HISPANIA</option>'+
					'<option value="5360">ANTIOQUIA-ITAGUI</option>'+
					'<option value="5361">ANTIOQUIA-ITUANGO</option>'+
					'<option value="5364">ANTIOQUIA-JARDIN</option>'+
					'<option value="5368">ANTIOQUIA-JERICO</option>'+
					'<option value="5376">ANTIOQUIA-LA CEJA</option>'+
					'<option value="5380">ANTIOQUIA-LA ESTRELLA</option>'+
					'<option value="5390">ANTIOQUIA-LA PINTADA</option>'+
					'<option value="5400">ANTIOQUIA-LA UNION</option>'+
					'<option value="5411">ANTIOQUIA-LIBORINA</option>'+
					'<option value="5425">ANTIOQUIA-MACEO</option>'+
					'<option value="5440">ANTIOQUIA-MARINILLA</option>'+
					'<option value="5467">ANTIOQUIA-MONTEBELLO</option>'+
					'<option value="5475">ANTIOQUIA-MURINDO</option>'+
					'<option value="5480">ANTIOQUIA-MUTATA</option>'+
					'<option value="5483">ANTIOQUIA-NARIÃƒâ€˜O</option>'+
					'<option value="5490">ANTIOQUIA-NECOCLI</option>'+
					'<option value="5495">ANTIOQUIA-NECHI</option>'+
					'<option value="5501">ANTIOQUIA-OLAYA</option>'+
					'<option value="5541">ANTIOQUIA-EL PEÃƒâ€˜OL</option>'+
					'<option value="5543">ANTIOQUIA-PEQUE</option>'+
					'<option value="5576">ANTIOQUIA-PUEBLO RICO</option>'+
					'<option value="5579">ANTIOQUIA-PUERTO BERRIO</option>'+
					'<option value="5585">ANTIOQUIA-PUERTO NARE</option>'+
					'<option value="5591">ANTIOQUIA-PUERTO TRIUNFO</option>'+
					'<option value="5604">ANTIOQUIA-REMEDIOS</option>'+
					'<option value="5607">ANTIOQUIA-EL RETIRO</option>'+
					'<option value="5615">ANTIOQUIA-RIONEGRO</option>'+
					'<option value="5628">ANTIOQUIA-SABANALARGA</option>'+
					'<option value="5631">ANTIOQUIA-SABANETA</option>'+
					'<option value="5642">ANTIOQUIA-SALGAR</option>'+
					'<option value="5647">ANTIOQUIA-SAN ANDRES</option>'+
					'<option value="5649">ANTIOQUIA-SAN CARLOS</option>'+
					'<option value="5652">ANTIOQUIA-SAN FRANCISCO</option>'+
					'<option value="5656">ANTIOQUIA-SAN JERONIMO</option>'+
					'<option value="5658">ANTIOQUIA-SAN JOSE DE LA MONTAÃƒâ€˜A</option>'+
					'<option value="5659">ANTIOQUIA-SAN JUAN DE URABA</option>'+
					'<option value="5660">ANTIOQUIA-SAN LUIS</option>'+
					'<option value="5664">ANTIOQUIA-SAN PEDRO</option>'+
					'<option value="5665">ANTIOQUIA-SAN PEDRO DE URABA</option>'+
					'<option value="5667">ANTIOQUIA-SAN RAFAEL</option>'+
					'<option value="5670">ANTIOQUIA-SAN ROQUE</option>'+
					'<option value="5674">ANTIOQUIA-SAN VICENTE</option>'+
					'<option value="5679">ANTIOQUIA-SANTA BARBARA</option>'+
					'<option value="5686">ANTIOQUIA-SANTA ROSA DE OSOS</option>'+
					'<option value="5690">ANTIOQUIA-SANTO DOMINGO</option>'+
					'<option value="5697">ANTIOQUIA-SANTUARIO</option>'+
					'<option value="5736">ANTIOQUIA-SEGOVIA</option>'+
					'<option value="5756">ANTIOQUIA-SONSON</option>'+
					'<option value="5761">ANTIOQUIA-SOPETRAN</option>'+
					'<option value="5789">ANTIOQUIA-TAMESIS</option>'+
					'<option value="5790">ANTIOQUIA-TARAZA</option>'+
					'<option value="5792">ANTIOQUIA-TARSO</option>'+
					'<option value="5809">ANTIOQUIA-TITIRIBI</option>'+
					'<option value="5819">ANTIOQUIA-TOLEDO</option>'+
					'<option value="5837">ANTIOQUIA-TURBO</option>'+
					'<option value="5842">ANTIOQUIA-URAMITA</option>'+
					'<option value="5847">ANTIOQUIA-URRAO</option>'+
					'<option value="5854">ANTIOQUIA-VALDIVIA</option>'+
					'<option value="5856">ANTIOQUIA-VALPARAISO</option>'+
					'<option value="5858">ANTIOQUIA-VEGACHI</option>'+
					'<option value="5861">ANTIOQUIA-VENECIA</option>'+
					'<option value="5873">ANTIOQUIA-VIGIA DEL FUERTE</option>'+
					'<option value="5885">ANTIOQUIA-YALI</option>'+
					'<option value="5887">ANTIOQUIA-YARUMAL</option>'+
					'<option value="5890">ANTIOQUIA-YOLOMBO</option>'+
					'<option value="5893">ANTIOQUIA-YONDO</option>'+
					'<option value="5895">ANTIOQUIA-ZARAGOZA</option>'+
					'<option value="8001">ATLANTICO-BARRANQUILLA</option>'+
					'<option value="8078">ATLANTICO-BARANOA</option>'+
					'<option value="8137">ATLANTICO-CAMPO DE LA CRUZ</option>'+
					'<option value="8141">ATLANTICO-CANDELARIA</option>'+
					'<option value="8296">ATLANTICO-GALAPA</option>'+
					'<option value="8372">ATLANTICO-JUAN DE ACOSTA</option>'+
					'<option value="8421">ATLANTICO-LURUACO</option>'+
					'<option value="8433">ATLANTICO-MALAMBO</option>'+
					'<option value="8436">ATLANTICO-MANATI</option>'+
					'<option value="8520">ATLANTICO-PALMAR DE VARELA</option>'+
					'<option value="8549">ATLANTICO-PIOJO</option>'+
					'<option value="8558">ATLANTICO-POLONUEVO</option>'+
					'<option value="8560">ATLANTICO-PONEDERA</option>'+
					'<option value="8573">ATLANTICO-PUERTO COLOMBIA</option>'+
					'<option value="8606">ATLANTICO-REPELON</option>'+
					'<option value="8634">ATLANTICO-SABANAGRANDE</option>'+
					'<option value="8638">ATLANTICO-SABANALARGA</option>'+
					'<option value="8675">ATLANTICO-SANTA LUCIA</option>'+
					'<option value="8685">ATLANTICO-SANTO TOMAS</option>'+
					'<option value="8758">ATLANTICO-SOLEDAD</option>'+
					'<option value="8770">ATLANTICO-SUAN</option>'+
					'<option value="8832">ATLANTICO-TUBARA</option>'+
					'<option value="8849">ATLANTICO-USIACURI</option>'+
					'<option value="9999">OTRO-SIN INFORMACION</option>'+
					'<option value="11001">BOGOTA DC-SANTAFE DE BOGOTA</option>'+
					'<option value="13001">BOLIVAR-CARTAGENA</option>'+
					'<option value="13006">BOLIVAR-ACHI</option>'+
					'<option value="13030">BOLIVAR-ALTOS DEL ROSARIO</option>'+
					'<option value="13042">BOLIVAR-ARENAL</option>'+
					'<option value="13052">BOLIVAR-ARJONA</option>'+
					'<option value="13074">BOLIVAR-BARRANCO DE LOBA</option>'+
					'<option value="13140">BOLIVAR-CALAMAR</option>'+
					'<option value="13160">BOLIVAR-CANTAGALLO</option>'+
					'<option value="13188">BOLIVAR-CICUCO</option>'+
					'<option value="13212">BOLIVAR-CORDOBA</option>'+
					'<option value="13222">BOLIVAR-CLEMENCIA</option>'+
					'<option value="13244">BOLIVAR-EL CARMEN DE BOLIVAR</option>'+
					'<option value="13248">BOLIVAR-EL GUAMO</option>'+
					'<option value="13268">BOLIVAR-EL PEÃƒâ€˜ON</option>'+
					'<option value="13300">BOLIVAR-HATILLO DE LOBA</option>'+
					'<option value="13430">BOLIVAR-MAGANGUE</option>'+
					'<option value="13433">BOLIVAR-MAHATES</option>'+
					'<option value="13440">BOLIVAR-MARGARITA</option>'+
					'<option value="13442">BOLIVAR-MARIA LA BAJA</option>'+
					'<option value="13458">BOLIVAR-MONTECRISTO</option>'+
					'<option value="13468">BOLIVAR-MOMPOS</option>'+
					'<option value="13473">BOLIVAR-MORALES</option>'+
					'<option value="13549">BOLIVAR-PINILLOS</option>'+
					'<option value="13580">BOLIVAR-REGIDOR</option>'+
					'<option value="13600">BOLIVAR-RIO VIEJO</option>'+
					'<option value="13620">BOLIVAR-SAN CRISTOBAL</option>'+
					'<option value="13647">BOLIVAR-SAN ESTANISLAO</option>'+
					'<option value="13650">BOLIVAR-SAN FERNANDO</option>'+
					'<option value="13654">BOLIVAR-SAN JACINTO</option>'+
					'<option value="13657">BOLIVAR-SAN JUAN NEPOMUCENO</option>'+
					'<option value="13667">BOLIVAR-SAN MARTIN DE LOBA</option>'+
					'<option value="13670">BOLIVAR-SAN PABLO</option>'+
					'<option value="13673">BOLIVAR-SANTA CATALINA</option>'+
					'<option value="13683">BOLIVAR-SANTA ROSA</option>'+
					'<option value="13688">BOLIVAR-SANTA ROSA DEL SUR</option>'+
					'<option value="13744">BOLIVAR-SIMITI</option>'+
					'<option value="13760">BOLIVAR-SOPLAVIENTO</option>'+
					'<option value="13780">BOLIVAR-TALAIGUA NUEVO</option>'+
					'<option value="13810">BOLIVAR-TIQUISIO</option>'+
					'<option value="13836">BOLIVAR-TURBACO</option>'+
					'<option value="13838">BOLIVAR-TURBANA</option>'+
					'<option value="13873">BOLIVAR-VILLANUEVA</option>'+
					'<option value="13894">BOLIVAR-ZAMBRANO</option>'+
					'<option value="15001">BOYACA-TUNJA</option>'+
					'<option value="15022">BOYACA-ALMEIDA</option>'+
					'<option value="15047">BOYACA-AQUITANIA</option>'+
					'<option value="15051">BOYACA-ARCABUCO</option>'+
					'<option value="15087">BOYACA-BELEN</option>'+
					'<option value="15090">BOYACA-BERBEO</option>'+
					'<option value="15092">BOYACA-BETEITIVA</option>'+
					'<option value="15097">BOYACA-BOAVITA</option>'+
					'<option value="15104">BOYACA-BOYACA</option>'+
					'<option value="15106">BOYACA-BRICEÃƒâ€˜0</option>'+
					'<option value="15109">BOYACA-BUENAVISTA</option>'+
					'<option value="15114">BOYACA-BUSBANZA</option>'+
					'<option value="15131">BOYACA-CALDAS</option>'+
					'<option value="15135">BOYACA-CAMPOHERMOSO</option>'+
					'<option value="15162">BOYACA-CERINZA</option>'+
					'<option value="15172">BOYACA-CHINAVITA</option>'+
					'<option value="15176">BOYACA-CHIQUINQUIRA</option>'+
					'<option value="15180">BOYACA-CHISCAS</option>'+
					'<option value="15183">BOYACA-CHITA</option>'+
					'<option value="15185">BOYACA-CHITARAQUE</option>'+
					'<option value="15187">BOYACA-CHIVATA</option>'+
					'<option value="15189">BOYACA-CIENEGA</option>'+
					'<option value="15204">BOYACA-COMBITA</option>'+
					'<option value="15212">BOYACA-COPER</option>'+
					'<option value="15215">BOYACA-CORRALES</option>'+
					'<option value="15218">BOYACA-COVARACHIA</option>'+
					'<option value="15223">BOYACA-CUBARA</option>'+
					'<option value="15224">BOYACA-CUCAITA</option>'+
					'<option value="15226">BOYACA-CUITIVA</option>'+
					'<option value="15232">BOYACA-CHIQUIZA</option>'+
					'<option value="15236">BOYACA-CHIVOR</option>'+
					'<option value="15238">BOYACA-DUITAMA</option>'+
					'<option value="15244">BOYACA-EL COCUY</option>'+
					'<option value="15248">BOYACA-EL ESPINO</option>'+
					'<option value="15272">BOYACA-FIRAVITOBA</option>'+
					'<option value="15276">BOYACA-FLORESTA</option>'+
					'<option value="15293">BOYACA-GACHANTIVA</option>'+
					'<option value="15296">BOYACA-GAMEZA</option>'+
					'<option value="15299">BOYACA-GARAGOA</option>'+
					'<option value="15317">BOYACA-GUACAMAYAS</option>'+
					'<option value="15322">BOYACA-GUATEQUE</option>'+
					'<option value="15325">BOYACA-GUAYATA</option>'+
					'<option value="15332">BOYACA-GUICAN</option>'+
					'<option value="15362">BOYACA-IZA</option>'+
					'<option value="15367">BOYACA-JENESANO</option>'+
					'<option value="15368">BOYACA-JERICO</option>'+
					'<option value="15377">BOYACA-LABRANZAGRANDE</option>'+
					'<option value="15380">BOYACA-LA CAPILLA</option>'+
					'<option value="15401">BOYACA-LA VICTORIA</option>'+
					'<option value="15403">BOYACA-LA UVITA</option>'+
					'<option value="15407">BOYACA-VILLA DE LEIVA</option>'+
					'<option value="15425">BOYACA-MACANAL</option>'+
					'<option value="15442">BOYACA-MARIPI</option>'+
					'<option value="15455">BOYACA-MIRAFLORES</option>'+
					'<option value="15464">BOYACA-MONGUA</option>'+
					'<option value="15466">BOYACA-MONGUI</option>'+
					'<option value="15469">BOYACA-MONIQUIRA</option>'+
					'<option value="15476">BOYACA-MOTAVITA</option>'+
					'<option value="15480">BOYACA-MUZO</option>'+
					'<option value="15491">BOYACA-NOBSA</option>'+
					'<option value="15494">BOYACA-NUEVO COLON</option>'+
					'<option value="15500">BOYACA-OICATA</option>'+
					'<option value="15507">BOYACA-OTANCHE</option>'+
					'<option value="15511">BOYACA-PACHAVITA</option>'+
					'<option value="15514">BOYACA-PAEZ</option>'+
					'<option value="15516">BOYACA-PAIPA</option>'+
					'<option value="15518">BOYACA-PAJARITO</option>'+
					'<option value="15522">BOYACA-PANQUEBA</option>'+
					'<option value="15531">BOYACA-PAUNA</option>'+
					'<option value="15533">BOYACA-PAYA</option>'+
					'<option value="15537">BOYACA-PAZ DE RIO</option>'+
					'<option value="15542">BOYACA-PESCA</option>'+
					'<option value="15550">BOYACA-PISVA</option>'+
					'<option value="15572">BOYACA-PUERTO BOYACA</option>'+
					'<option value="15580">BOYACA-QUIPAMA</option>'+
					'<option value="15599">BOYACA-RAMIRIQUI</option>'+
					'<option value="15600">BOYACA-RAQUIRA</option>'+
					'<option value="15621">BOYACA-RONDON</option>'+
					'<option value="15632">BOYACA-SABOYA</option>'+
					'<option value="15638">BOYACA-SACHICA</option>'+
					'<option value="15646">BOYACA-SAMACA</option>'+
					'<option value="15660">BOYACA-SAN EDUARDO</option>'+
					'<option value="15664">BOYACA-SAN JOSE DE PARE</option>'+
					'<option value="15667">BOYACA-SAN LUIS DE GACENO</option>'+
					'<option value="15673">BOYACA-SAN MATEO</option>'+
					'<option value="15676">BOYACA-SAN MIGUEL DE SEMA</option>'+
					'<option value="15681">BOYACA-SAN PABLO DE BORBUR</option>'+
					'<option value="15686">BOYACA-SANTANA</option>'+
					'<option value="15690">BOYACA-SANTA MARIA</option>'+
					'<option value="15693">BOYACA-SANTA ROSA DE VITERBO</option>'+
					'<option value="15696">BOYACA-SANTA SOFIA</option>'+
					'<option value="15720">BOYACA-SATIVANORTE</option>'+
					'<option value="15723">BOYACA-SATIVASUR</option>'+
					'<option value="15740">BOYACA-SIACHOQUE</option>'+
					'<option value="15753">BOYACA-SOATA</option>'+
					'<option value="15755">BOYACA-SOCOTA</option>'+
					'<option value="15757">BOYACA-SOCHA</option>'+
					'<option value="15759">BOYACA-SOGAMOSO</option>'+
					'<option value="15761">BOYACA-SOMONDOCO</option>'+
					'<option value="15762">BOYACA-SORA</option>'+
					'<option value="15763">BOYACA-SOTAQUIRA</option>'+
					'<option value="15764">BOYACA-SORACA</option>'+
					'<option value="15774">BOYACA-SUSACON</option>'+
					'<option value="15776">BOYACA-SUTAMARCHAN</option>'+
					'<option value="15778">BOYACA-SUTATENZA</option>'+
					'<option value="15790">BOYACA-TASCO</option>'+
					'<option value="15798">BOYACA-TENZA</option>'+
					'<option value="15804">BOYACA-TIBANA</option>'+
					'<option value="15806">BOYACA-TIBASOSA</option>'+
					'<option value="15808">BOYACA-TINJACA</option>'+
					'<option value="15810">BOYACA-TIPACOQUE</option>'+
					'<option value="15814">BOYACA-TOCA</option>'+
					'<option value="15816">BOYACA-TOGUI</option>'+
					'<option value="15820">BOYACA-TOPAGA</option>'+
					'<option value="15822">BOYACA-TOTA</option>'+
					'<option value="15832">BOYACA-TUNUNGA</option>'+
					'<option value="15835">BOYACA-TURMEQUE</option>'+
					'<option value="15837">BOYACA-TUTA</option>'+
					'<option value="15839">BOYACA-TUTAZA</option>'+
					'<option value="15842">BOYACA-UMBITA</option>'+
					'<option value="15861">BOYACA-VENTAQUEMADA</option>'+
					'<option value="15879">BOYACA-VIRACACHA</option>'+
					'<option value="15897">BOYACA-ZETAQUIRA</option>'+
					'<option value="17001">CALDAS-MANIZALES</option>'+
					'<option value="17013">CALDAS-AGUADAS</option>'+
					'<option value="17042">CALDAS-ANSERMA</option>'+
					'<option value="17050">CALDAS-ARANZAZU</option>'+
					'<option value="17088">CALDAS-BELALCAZAR</option>'+
					'<option value="17174">CALDAS-CHINCHINA</option>'+
					'<option value="17272">CALDAS-FILADELFIA</option>'+
					'<option value="17380">CALDAS-LA DORADA</option>'+
					'<option value="17388">CALDAS-LA MERCED</option>'+
					'<option value="17433">CALDAS-MANZANARES</option>'+
					'<option value="17442">CALDAS-MARMATO</option>'+
					'<option value="17444">CALDAS-MARQUETALIA</option>'+
					'<option value="17446">CALDAS-MARULANDA</option>'+
					'<option value="17486">CALDAS-NEIRA</option>'+
					'<option value="17495">CALDAS-NORCASIA (CALDAS)</option>'+
					'<option value="17513">CALDAS-PACORA</option>'+
					'<option value="17524">CALDAS-PALESTINA</option>'+
					'<option value="17541">CALDAS-PENSILVANIA</option>'+
					'<option value="17614">CALDAS-RIOSUCIO</option>'+
					'<option value="17616">CALDAS-RISARALDA</option>'+
					'<option value="17653">CALDAS-SALAMINA</option>'+
					'<option value="17662">CALDAS-SAMANA</option>'+
					'<option value="17777">CALDAS-SUPIA</option>'+
					'<option value="17867">CALDAS-VICTORIA</option>'+
					'<option value="17873">CALDAS-VILLAMARIA</option>'+
					'<option value="17877">CALDAS-VITERBO</option>'+
					'<option value="18001">CAQUETA-FLORENCIA</option>'+
					'<option value="18029">CAQUETA-ALBANIA</option>'+
					'<option value="18094">CAQUETA-BELEN DE LOS ANDAQUIES</option>'+
					'<option value="18150">CAQUETA-CARTAGENA DEL CHAIRA</option>'+
					'<option value="18205">CAQUETA-CURILLO</option>'+
					'<option value="18247">CAQUETA-EL DONCELLO</option>'+
					'<option value="18256">CAQUETA-PAUJIL</option>'+
					'<option value="18410">CAQUETA-MONTANITA</option>'+
					'<option value="18460">CAQUETA-MILAN</option>'+
					'<option value="18479">CAQUETA-MORELIA</option>'+
					'<option value="18592">CAQUETA-PUERTO RICO</option>'+
					'<option value="18610">CAQUETA-SAN JOSE DEL FRAGUA</option>'+
					'<option value="18753">CAQUETA-SAN VICENTE DEL CAGUAN</option>'+
					'<option value="18756">CAQUETA-SOLANO</option>'+
					'<option value="18765">CAQUETA-SOLANO</option>'+
					'<option value="18785">CAQUETA-SOLITA</option>'+
					'<option value="18860">CAQUETA-VALPARAISO</option>'+
					'<option value="19001">CAUCA-POPAYAN</option>'+
					'<option value="19022">CAUCA-ALMAGUER</option>'+
					'<option value="19050">CAUCA-ARGELIA</option>'+
					'<option value="19075">CAUCA-BALBOA</option>'+
					'<option value="19100">CAUCA-BOLIVAR</option>'+
					'<option value="19110">CAUCA-BUENOS AIRES</option>'+
					'<option value="19130">CAUCA-CAJIBIO</option>'+
					'<option value="19137">CAUCA-CALDONO</option>'+
					'<option value="19142">CAUCA-CALOTO</option>'+
					'<option value="19212">CAUCA-CORINTO</option>'+
					'<option value="19256">CAUCA-EL TAMBO</option>'+
					'<option value="19290">CAUCA-FLORENCIA</option>'+
					'<option value="19318">CAUCA-GUAPI</option>'+
					'<option value="19355">CAUCA-INZA</option>'+
					'<option value="19364">CAUCA-JAMBALO</option>'+
					'<option value="19392">CAUCA-LA SIERRA</option>'+
					'<option value="19397">CAUCA-LA VEGA</option>'+
					'<option value="19418">CAUCA-LOPEZ</option>'+
					'<option value="19450">CAUCA-MERCADERES</option>'+
					'<option value="19455">CAUCA-MIRANDA</option>'+
					'<option value="19473">CAUCA-MORALES</option>'+
					'<option value="19513">CAUCA-PADILLA</option>'+
					'<option value="19517">CAUCA-PAEZ (BELALCAZAR)</option>'+
					'<option value="19532">CAUCA-PATIA (EL BORDO)</option>'+
					'<option value="19548">CAUCA-PIENDAMO</option>'+
					'<option value="19573">CAUCA-PUERTO TEJADA</option>'+
					'<option value="19585">CAUCA-PURACE (COCONUCO)</option>'+
					'<option value="19622">CAUCA-ROSAS</option>'+
					'<option value="19693">CAUCA-SAN SEBASTIAN</option>'+
					'<option value="19698">CAUCA-SANTANDER DE QUILICHAO</option>'+
					'<option value="19701">CAUCA-SANTA ROSA</option>'+
					'<option value="19743">CAUCA-SILVIA</option>'+
					'<option value="19760">CAUCA-SOTARA (PAISPAMBA)</option>'+
					'<option value="19780">CAUCA-SUAREZ</option>'+
					'<option value="19785">CAUCA-SUCRE (CAUCA)</option>'+
					'<option value="19807">CAUCA-TIMBIO</option>'+
					'<option value="19809">CAUCA-TIMBIQUI</option>'+
					'<option value="19821">CAUCA-TORIBIO</option>'+
					'<option value="19824">CAUCA-TOTORO</option>'+
					'<option value="20001">CESAR-VALLEDUPAR</option>'+
					'<option value="20011">CESAR-AGUACHICA</option>'+
					'<option value="20013">CESAR-AGUSTIN CODAZZI</option>'+
					'<option value="20032">CESAR-ASTREA</option>'+
					'<option value="20045">CESAR-BECERRIL</option>'+
					'<option value="20060">CESAR-BOSCONIA</option>'+
					'<option value="20175">CESAR-CHIMICHAGUA</option>'+
					'<option value="20178">CESAR-CHIRIGUANA</option>'+
					'<option value="20228">CESAR-CURUMANI</option>'+
					'<option value="20238">CESAR-EL COPEY</option>'+
					'<option value="20250">CESAR-EL PASO</option>'+
					'<option value="20295">CESAR-GAMARRA</option>'+
					'<option value="20310">CESAR-GONZALEZ</option>'+
					'<option value="20383">CESAR-LA GLORIA</option>'+
					'<option value="20400">CESAR-LA JAGUA DE IBIRICO</option>'+
					'<option value="20443">CESAR-MANAURE BALCON DEL CESAR</option>'+
					'<option value="20517">CESAR-PAILITAS</option>'+
					'<option value="20550">CESAR-PELAYA</option>'+
					'<option value="20614">CESAR-RIO DE ORO</option>'+
					'<option value="20621">CESAR-LA PAZ</option>'+
					'<option value="20710">CESAR-SAN ALBERTO</option>'+
					'<option value="20750">CESAR-SAN DIEGO</option>'+
					'<option value="20770">CESAR-SAN MARTIN</option>'+
					'<option value="20787">CESAR-TAMALAMEQUE</option>'+
					'<option value="23001">CORDOBA-MONTERIA</option>'+
					'<option value="23068">CORDOBA-AYAPEL</option>'+
					'<option value="23079">CORDOBA-BUENAVISTA</option>'+
					'<option value="23090">CORDOBA-CANALETE</option>'+
					'<option value="23162">CORDOBA-CERETE</option>'+
					'<option value="23168">CORDOBA-CHIMA</option>'+
					'<option value="23182">CORDOBA-CHINU</option>'+
					'<option value="23189">CORDOBA-CIENAGA DE ORO</option>'+
					'<option value="23300">CORDOBA-COTORRA</option>'+
					'<option value="23350">CORDOBA-LA APARTADA</option>'+
					'<option value="23417">CORDOBA-LORICA</option>'+
					'<option value="23419">CORDOBA-LOS CORDOBAS</option>'+
					'<option value="23464">CORDOBA-MOMIL</option>'+
					'<option value="23466">CORDOBA-MONTELIBANO</option>'+
					'<option value="23500">CORDOBA-MOÃƒâ€˜ITOS</option>'+
					'<option value="23555">CORDOBA-PLANETA RICA</option>'+
					'<option value="23570">CORDOBA-PUEBLO NUEVO</option>'+
					'<option value="23574">CORDOBA-PUERTO ESCONDIDO</option>'+
					'<option value="23580">CORDOBA-PUERTO LIBERTADOR</option>'+
					'<option value="23586">CORDOBA-PURISIMA</option>'+
					'<option value="23660">CORDOBA-SAHAGUN</option>'+
					'<option value="23670">CORDOBA-SAN ANDRES DE SOTAVENTO</option>'+
					'<option value="23672">CORDOBA-SAN ANTERO</option>'+
					'<option value="23675">CORDOBA-SAN BERNARDO DEL VIENTO</option>'+
					'<option value="23678">CORDOBA-SAN CARLOS</option>'+
					'<option value="23682">CORDOBA-SAN JOSE DE URE</option>'+
					'<option value="23686">CORDOBA-SAN PELAYO</option>'+
					'<option value="23807">CORDOBA-TIERRALTA</option>'+
					'<option value="23815">CORDOBA-TUCHÃƒÂN</option>'+
					'<option value="23855">CORDOBA-VALENCIA</option>'+
					'<option value="25001">CUNDINAMARCA-AGUA DE DIOS</option>'+
					'<option value="25019">CUNDINAMARCA-ALBAN</option>'+
					'<option value="25035">CUNDINAMARCA-ANAPOIMA</option>'+
					'<option value="25040">CUNDINAMARCA-ANOLAIMA</option>'+
					'<option value="25053">CUNDINAMARCA-ARBELAEZ</option>'+
					'<option value="25086">CUNDINAMARCA-BELTRAN</option>'+
					'<option value="25095">CUNDINAMARCA-BITUIMA</option>'+
					'<option value="25099">CUNDINAMARCA-BOJACA</option>'+
					'<option value="25120">CUNDINAMARCA-CABRERA</option>'+
					'<option value="25123">CUNDINAMARCA-CACHIPAY</option>'+
					'<option value="25126">CUNDINAMARCA-CAJICA</option>'+
					'<option value="25148">CUNDINAMARCA-CAPARRAPI</option>'+
					'<option value="25151">CUNDINAMARCA-CAQUEZA</option>'+
					'<option value="25154">CUNDINAMARCA-CARMEN DE CARUPA</option>'+
					'<option value="25168">CUNDINAMARCA-CHAGUANI</option>'+
					'<option value="25175">CUNDINAMARCA-CHIA</option>'+
					'<option value="25178">CUNDINAMARCA-CHIPAQUE</option>'+
					'<option value="25181">CUNDINAMARCA-CHOACHI</option>'+
					'<option value="25183">CUNDINAMARCA-CHOCONTA</option>'+
					'<option value="25200">CUNDINAMARCA-COGUA</option>'+
					'<option value="25214">CUNDINAMARCA-COTA</option>'+
					'<option value="25224">CUNDINAMARCA-CUCUNUBA</option>'+
					'<option value="25245">CUNDINAMARCA-EL COLEGIO</option>'+
					'<option value="25258">CUNDINAMARCA-EL PEÃƒâ€˜ON</option>'+
					'<option value="25260">CUNDINAMARCA-EL ROSAL</option>'+
					'<option value="25269">CUNDINAMARCA-FACATATIVA</option>'+
					'<option value="25279">CUNDINAMARCA-FOMEQUE</option>'+
					'<option value="25281">CUNDINAMARCA-FOSCA</option>'+
					'<option value="25286">CUNDINAMARCA-FUNZA</option>'+
					'<option value="25288">CUNDINAMARCA-FUQUENE</option>'+
					'<option value="25290">CUNDINAMARCA-FUSAGASUGA</option>'+
					'<option value="25293">CUNDINAMARCA-GACHALA</option>'+
					'<option value="25295">CUNDINAMARCA-GACHANCIPA</option>'+
					'<option value="25297">CUNDINAMARCA-GACHETA</option>'+
					'<option value="25299">CUNDINAMARCA-GAMA</option>'+
					'<option value="25307">CUNDINAMARCA-GIRARDOT</option>'+
					'<option value="25312">CUNDINAMARCA-GRANADA</option>'+
					'<option value="25317">CUNDINAMARCA-GUACHETA</option>'+
					'<option value="25320">CUNDINAMARCA-GUADUAS</option>'+
					'<option value="25322">CUNDINAMARCA-GUASCA</option>'+
					'<option value="25324">CUNDINAMARCA-GUATAQUI</option>'+
					'<option value="25326">CUNDINAMARCA-GUATAVITA</option>'+
					'<option value="25328">CUNDINAMARCA-GUAYABAL DE SIQUIMA</option>'+
					'<option value="25335">CUNDINAMARCA-GUAYABETAL</option>'+
					'<option value="25339">CUNDINAMARCA-GUTIERREZ</option>'+
					'<option value="25368">CUNDINAMARCA-JERUSALEN</option>'+
					'<option value="25372">CUNDINAMARCA-JUNIN</option>'+
					'<option value="25377">CUNDINAMARCA-LA CALERA</option>'+
					'<option value="25386">CUNDINAMARCA-LA MESA</option>'+
					'<option value="25394">CUNDINAMARCA-LA PALMA</option>'+
					'<option value="25398">CUNDINAMARCA-LA PEYA</option>'+
					'<option value="25402">CUNDINAMARCA-LA VEGA</option>'+
					'<option value="25407">CUNDINAMARCA-LENGUAZAQUE</option>'+
					'<option value="25426">CUNDINAMARCA-MACHETA</option>'+
					'<option value="25430">CUNDINAMARCA-MADRID</option>'+
					'<option value="25436">CUNDINAMARCA-MANTA</option>'+
					'<option value="25438">CUNDINAMARCA-MEDINA</option>'+
					'<option value="25473">CUNDINAMARCA-MOSQUERA</option>'+
					'<option value="25483">CUNDINAMARCA-NARIO</option>'+
					'<option value="25486">CUNDINAMARCA-NEMOCON</option>'+
					'<option value="25488">CUNDINAMARCA-NILO</option>'+
					'<option value="25489">CUNDINAMARCA-NIMAIMA</option>'+
					'<option value="25491">CUNDINAMARCA-NOCAIMA</option>'+
					'<option value="25506">CUNDINAMARCA-VENECIA</option>'+
					'<option value="25513">CUNDINAMARCA-PACHO</option>'+
					'<option value="25518">CUNDINAMARCA-PAIME</option>'+
					'<option value="25524">CUNDINAMARCA-PANDI</option>'+
					'<option value="25530">CUNDINAMARCA-PARATEBUENO</option>'+
					'<option value="25535">CUNDINAMARCA-PASCA</option>'+
					'<option value="25572">CUNDINAMARCA-PUERTO SALGAR</option>'+
					'<option value="25580">CUNDINAMARCA-PULI</option>'+
					'<option value="25592">CUNDINAMARCA-QUEBRADANEGRA</option>'+
					'<option value="25594">CUNDINAMARCA-QUETAME</option>'+
					'<option value="25596">CUNDINAMARCA-QUIPILE</option>'+
					'<option value="25599">CUNDINAMARCA-APULO</option>'+
					'<option value="25612">CUNDINAMARCA-RICAURTE</option>'+
					'<option value="25645">CUNDINAMARCA-SAN ANTONIO DEL TEQUENDAMA</option>'+
					'<option value="25649">CUNDINAMARCA-SAN BERNARDO</option>'+
					'<option value="25653">CUNDINAMARCA-SAN CAYETANO</option>'+
					'<option value="25658">CUNDINAMARCA-SAN FRANCISCO</option>'+
					'<option value="25662">CUNDINAMARCA-SAN JUAN DE RIOSECO</option>'+
					'<option value="25718">CUNDINAMARCA-SASAIMA</option>'+
					'<option value="25736">CUNDINAMARCA-SESQUILE</option>'+
					'<option value="25740">CUNDINAMARCA-SIBATE</option>'+
					'<option value="25743">CUNDINAMARCA-SILVANIA</option>'+
					'<option value="25745">CUNDINAMARCA-SIMIJACA</option>'+
					'<option value="25754">CUNDINAMARCA-SOACHA</option>'+
					'<option value="25758">CUNDINAMARCA-SOPO</option>'+
					'<option value="25769">CUNDINAMARCA-SUBACHOQUE</option>'+
					'<option value="25772">CUNDINAMARCA-SUESCA</option>'+
					'<option value="25777">CUNDINAMARCA-SUPATA</option>'+
					'<option value="25779">CUNDINAMARCA-SUSA</option>'+
					'<option value="25781">CUNDINAMARCA-SUTATAUSA</option>'+
					'<option value="25785">CUNDINAMARCA-TABIO</option>'+
					'<option value="25793">CUNDINAMARCA-TAUSA</option>'+
					'<option value="25797">CUNDINAMARCA-TENA</option>'+
					'<option value="25799">CUNDINAMARCA-TENJO</option>'+
					'<option value="25805">CUNDINAMARCA-TIBACUY</option>'+
					'<option value="25807">CUNDINAMARCA-TIBIRITA</option>'+
					'<option value="25815">CUNDINAMARCA-TOCAIMA</option>'+
					'<option value="25817">CUNDINAMARCA-TOCANCIPA</option>'+
					'<option value="25823">CUNDINAMARCA-TOPAIPI</option>'+
					'<option value="25839">CUNDINAMARCA-UBALA</option>'+
					'<option value="25841">CUNDINAMARCA-UBAQUE</option>'+
					'<option value="25843">CUNDINAMARCA-UBATE</option>'+
					'<option value="25845">CUNDINAMARCA-UNE</option>'+
					'<option value="25851">CUNDINAMARCA-UTICA</option>'+
					'<option value="25862">CUNDINAMARCA-VERGARA</option>'+
					'<option value="25867">CUNDINAMARCA-VIANI</option>'+
					'<option value="25871">CUNDINAMARCA-VILLAGOMEZ</option>'+
					'<option value="25873">CUNDINAMARCA-VILLAPINZON</option>'+
					'<option value="25875">CUNDINAMARCA-VILLETA</option>'+
					'<option value="25878">CUNDINAMARCA-VIOTA</option>'+
					'<option value="25885">CUNDINAMARCA-YACOPI</option>'+
					'<option value="25890">CUNDINAMARCA-ULALA</option>'+
					'<option value="25898">CUNDINAMARCA-ZIPACON</option>'+
					'<option value="25899">CUNDINAMARCA-ZIPAQUIRA</option>'+
					'<option value="27001">CHOCO-QUIBDO</option>'+
					'<option value="27006">CHOCO-ACANDI</option>'+
					'<option value="27025">CHOCO-ALTO BAUDO (PIE DE PATO)</option>'+
					'<option value="27050">CHOCO-ATRATO (CHOCO)</option>'+
					'<option value="27073">CHOCO-BAGADO</option>'+
					'<option value="27075">CHOCO-BAHIA SOLANO (MUTIS)</option>'+
					'<option value="27077">CHOCO-BAJO BAUDO (PIZARRO)</option>'+
					'<option value="27086">CHOCO-BLEN DE BAJIRA (CHOCO)</option>'+
					'<option value="27099">CHOCO-BOJAYA (BELLAVISTA)</option>'+
					'<option value="27135">CHOCO-EL CANTON DE SAN PABLO (MANAGRU)</option>'+
					'<option value="27150">CHOCO-CARMEN DEL DARIEN (CHOCO)</option>'+
					'<option value="27205">CHOCO-CONDOTO</option>'+
					'<option value="27245">CHOCO-EL CARMEN DE ATRATO</option>'+
					'<option value="27250">CHOCO-EL LITORAL DEL SAN JUAN (DOCORDO)</option>'+
					'<option value="27361">CHOCO-ISTMINA</option>'+
					'<option value="27372">CHOCO-JURADO</option>'+
					'<option value="27413">CHOCO-LLORO</option>'+
					'<option value="27491">CHOCO-NOVITA</option>'+
					'<option value="27495">CHOCO-NUQUI</option>'+
					'<option value="27580">CHOCO-RIO IRO (CHOCO)</option>'+
					'<option value="27615">CHOCO-RIOSUCIO</option>'+
					'<option value="27660">CHOCO-SAN JOSE DEL PALMAR</option>'+
					'<option value="27745">CHOCO-SIPI</option>'+
					'<option value="27787">CHOCO-TADO</option>'+
					'<option value="27800">CHOCO-UNGUIA</option>'+
					'<option value="41001">HUILA-NEIVA</option>'+
					'<option value="41006">HUILA-ACEVEDO</option>'+
					'<option value="41013">HUILA-AGRADO</option>'+
					'<option value="41016">HUILA-AIPE</option>'+
					'<option value="41020">HUILA-ALGECIRAS</option>'+
					'<option value="41026">HUILA-ALTAMIRA</option>'+
					'<option value="41078">HUILA-BARAYA</option>'+
					'<option value="41132">HUILA-CAMPOALEGRE</option>'+
					'<option value="41206">HUILA-COLOMBIA</option>'+
					'<option value="41244">HUILA-ELIAS</option>'+
					'<option value="41298">HUILA-GARZON</option>'+
					'<option value="41306">HUILA-GIGANTE</option>'+
					'<option value="41319">HUILA-GUADALUPE</option>'+
					'<option value="41349">HUILA-HOBO</option>'+
					'<option value="41357">HUILA-IQUIRA</option>'+
					'<option value="41359">HUILA-ISNOS</option>'+
					'<option value="41378">HUILA-LA ARGENTINA</option>'+
					'<option value="41396">HUILA-LA PLATA</option>'+
					'<option value="41483">HUILA-NATAGA</option>'+
					'<option value="41503">HUILA-OPORAPA</option>'+
					'<option value="41518">HUILA-PAICOL</option>'+
					'<option value="41524">HUILA-PALERMO</option>'+
					'<option value="41530">HUILA-PALESTINA</option>'+
					'<option value="41548">HUILA-PITAL</option>'+
					'<option value="41551">HUILA-PITALITO</option>'+
					'<option value="41615">HUILA-RIVERA</option>'+
					'<option value="41660">HUILA-SALADOBLANCO</option>'+
					'<option value="41668">HUILA-SAN AGUSTIN</option>'+
					'<option value="41676">HUILA-SANTA MARIA</option>'+
					'<option value="41770">HUILA-SUAZA</option>'+
					'<option value="41791">HUILA-TARQUI</option>'+
					'<option value="41797">HUILA-TESALIA</option>'+
					'<option value="41799">HUILA-TELLO</option>'+
					'<option value="41801">HUILA-TERUEL</option>'+
					'<option value="41807">HUILA-TIMANA</option>'+
					'<option value="41872">HUILA-VILLAVIEJA</option>'+
					'<option value="41885">HUILA-YAGUARA</option>'+
					'<option value="44001">GUAJIRA-RIOHACHA</option>'+
					'<option value="44035">GUAJIRA-ALBANIA (GUAJIRA)</option>'+
					'<option value="44078">GUAJIRA-BARRANCAS</option>'+
					'<option value="44090">GUAJIRA-DIBULLA</option>'+
					'<option value="44098">GUAJIRA-DISTRACCION</option>'+
					'<option value="44110">GUAJIRA-EL MOLINO</option>'+
					'<option value="44279">GUAJIRA-FONSECA</option>'+
					'<option value="44378">GUAJIRA-HATO NUEVO</option>'+
					'<option value="44430">GUAJIRA-MAICAO</option>'+
					'<option value="44560">GUAJIRA-MANAURE</option>'+
					'<option value="44650">GUAJIRA-SAN JUAN DEL CESAR</option>'+
					'<option value="44847">GUAJIRA-URIBIA</option>'+
					'<option value="44855">GUAJIRA-URUMITA</option>'+
					'<option value="44874">GUAJIRA-VILLANUEVA</option>'+
					'<option value="47001">MAGDALENA-SANTA MARTA</option>'+
					'<option value="47030">MAGDALENA-ALGARROBO (MAGDALENA)</option>'+
					'<option value="47053">MAGDALENA-ARACATACA</option>'+
					'<option value="47058">MAGDALENA-ARIGUANI (EL DIFICIL)</option>'+
					'<option value="47161">MAGDALENA-CERRO DE SAN ANTONIO</option>'+
					'<option value="47170">MAGDALENA-CHIVOLO</option>'+
					'<option value="47189">MAGDALENA-CIENAGA</option>'+
					'<option value="47245">MAGDALENA-EL BANCO</option>'+
					'<option value="47258">MAGDALENA-EL PINON</option>'+
					'<option value="47268">MAGDALENA-EL RETEN</option>'+
					'<option value="47288">MAGDALENA-FUNDACION</option>'+
					'<option value="47318">MAGDALENA-GUAMAL</option>'+
					'<option value="47460">MAGDALENA-NUEVA GRANADA (MAGDALENA)</option>'+
					'<option value="47541">MAGDALENA-PEDRAZA</option>'+
					'<option value="47545">MAGDALENA-PIJINO DEL CARMEN</option>'+
					'<option value="47551">MAGDALENA-PIVIJAY</option>'+
					'<option value="47555">MAGDALENA-PLATO</option>'+
					'<option value="47570">MAGDALENA-PUEBLOVIEJO</option>'+
					'<option value="47605">MAGDALENA-REMOLINO</option>'+
					'<option value="47675">MAGDALENA-SALAMINA</option>'+
					'<option value="47692">MAGDALENA-SAN SEBASTIAN DE BUENAVISTA</option>'+
					'<option value="47703">MAGDALENA-SAN ZENON</option>'+
					'<option value="47707">MAGDALENA-SANTA ANA</option>'+
					'<option value="47745">MAGDALENA-SITIONUEVO</option>'+
					'<option value="47798">MAGDALENA-TENERIFE</option>'+
					'<option value="47980">MAGDALENA-ZONA BANANERA (MAGDALENA)</option>'+
					'<option value="50001">META-VILLAVICENCIO</option>'+
					'<option value="50006">META-ACACIAS</option>'+
					'<option value="50110">META-BARRANCA DE UPIA</option>'+
					'<option value="50124">META-CABUYARO</option>'+
					'<option value="50150">META-CASTILLA LA NUEVA</option>'+
					'<option value="50223">META-CUBARRAL</option>'+
					'<option value="50226">META-CUMARAL</option>'+
					'<option value="50245">META-EL CALVARIO</option>'+
					'<option value="50251">META-EL CASTILLO</option>'+
					'<option value="50270">META-EL DORADO</option>'+
					'<option value="50287">META-FUENTE DE ORO</option>'+
					'<option value="50313">META-GRANADA</option>'+
					'<option value="50318">META-GUAMAL</option>'+
					'<option value="50325">META-MAPIRIPAN</option>'+
					'<option value="50330">META-MESETAS</option>'+
					'<option value="50350">META-LA MACARENA</option>'+
					'<option value="50370">META-URIBE</option>'+
					'<option value="50400">META-LEJANIAS</option>'+
					'<option value="50450">META-PUERTO CONCORDIA</option>'+
					'<option value="50568">META-PUERTO GAITAN</option>'+
					'<option value="50573">META-PUERTO LOPEZ</option>'+
					'<option value="50577">META-PUERTO LLERAS</option>'+
					'<option value="50590">META-PUERTO RICO</option>'+
					'<option value="50606">META-RESTREPO</option>'+
					'<option value="50680">META-SAN CARLOS DE GUAROA</option>'+
					'<option value="50683">META-SAN JUAN DE ARAMA</option>'+
					'<option value="50686">META-SAN JUANITO</option>'+
					'<option value="50689">META-SAN MARTIN</option>'+
					'<option value="50711">META-VISTAHERMOSA</option>'+
					'<option value="52001">NARINIO-PASTO</option>'+
					'<option value="52019">NARINIO-ALBAN (SAN JOSE)</option>'+
					'<option value="52022">NARINIO-ALDANA</option>'+
					'<option value="52036">NARINIO-ANCUYA</option>'+
					'<option value="52051">NARINIO-ARBOLEDA (BERRUECOS)</option>'+
					'<option value="52079">NARINIO-BARBACOAS</option>'+
					'<option value="52083">NARINIO-BELEN</option>'+
					'<option value="52110">NARINIO-BUESACO</option>'+
					'<option value="52203">NARINIO-COLON (GENOVA)</option>'+
					'<option value="52207">NARINIO-CONSACA</option>'+
					'<option value="52210">NARINIO-CONTADERO</option>'+
					'<option value="52215">NARINIO-CORDOBA</option>'+
					'<option value="52224">NARINIO-CUASPUD (CARLOSAMA)</option>'+
					'<option value="52227">NARINIO-CUMBAL</option>'+
					'<option value="52233">NARINIO-CUMBITARA</option>'+
					'<option value="52240">NARINIO-CHACHAGUI</option>'+
					'<option value="52250">NARINIO-EL CHARCO</option>'+
					'<option value="52256">NARINIO-EL ROSARIO</option>'+
					'<option value="52258">NARINIO-EL TABLON DE GOMEZ</option>'+
					'<option value="52260">NARINIO-EL TAMBO</option>'+
					'<option value="52287">NARINIO-FUNES</option>'+
					'<option value="52317">NARINIO-GUACHUCAL</option>'+
					'<option value="52320">NARINIO-GUAITARILLA</option>'+
					'<option value="52323">NARINIO-GUALMATAN</option>'+
					'<option value="52352">NARINIO-ILES</option>'+
					'<option value="52354">NARINIO-IMUES</option>'+
					'<option value="52356">NARINIO-IPIALES</option>'+
					'<option value="52378">NARINIO-LA CRUZ</option>'+
					'<option value="52381">NARINIO-LA FLORIDA</option>'+
					'<option value="52385">NARINIO-LA LLANADA</option>'+
					'<option value="52390">NARINIO-LA TOLA</option>'+
					'<option value="52399">NARINIO-LA UNION</option>'+
					'<option value="52405">NARINIO-LEIVA</option>'+
					'<option value="52411">NARINIO-LINARES</option>'+
					'<option value="52418">NARINIO-LOS ANDES (SOTOMAYOR)</option>'+
					'<option value="52427">NARINIO-MAGUI (PAYAN)</option>'+
					'<option value="52435">NARINIO-MALLAMA (PIEDRANCHA)</option>'+
					'<option value="52473">NARINIO-MOSQUERA</option>'+
					'<option value="52490">NARINIO-OLAYA HERRERA (BOCAS DE SATINGA)</option>'+
					'<option value="52506">NARINIO-OSPINA</option>'+
					'<option value="52520">NARINIO-FRANCISCO PIZARRO</option>'+
					'<option value="52540">NARINIO-POLICARPA</option>'+
					'<option value="52560">NARINIO-POTOSI</option>'+
					'<option value="52565">NARINIO-PROVIDENCIA</option>'+
					'<option value="52573">NARINIO-PUERRES</option>'+
					'<option value="52585">NARINIO-PUPIALES</option>'+
					'<option value="52612">NARINIO-RICAURTE</option>'+
					'<option value="52621">NARINIO-ROBERTO PAYAN (SAN JOSE)</option>'+
					'<option value="52678">NARINIO-SAMANIEGO</option>'+
					'<option value="52683">NARINIO-SANDONA</option>'+
					'<option value="52685">NARINIO-SAN BERNARDO</option>'+
					'<option value="52687">NARINIO-SAN LORENZO</option>'+
					'<option value="52693">NARINIO-SAN PABLO</option>'+
					'<option value="52694">NARINIO-SAN PEDRO DE CARTAGO (CARTAGO)</option>'+
					'<option value="52696">NARINIO-SANTA BARBARA (ISCUANDE)</option>'+
					'<option value="52699">NARINIO-SANTA CRUZ (GUACHAVEZ)</option>'+
					'<option value="52720">NARINIO-SAPUYES</option>'+
					'<option value="52786">NARINIO-TAMINANGO</option>'+
					'<option value="52788">NARINIO-TANGUA</option>'+
					'<option value="52835">NARINIO-TUMACO</option>'+
					'<option value="52838">NARINIO-TUQUERRES</option>'+
					'<option value="52885">NARINIO-YACUANQUER</option>'+
					'<option value="54001">NORTE DE SANTANDER-CUCUTA</option>'+
					'<option value="54003">NORTE DE SANTANDER-ABREGO</option>'+
					'<option value="54051">NORTE DE SANTANDER-ARBOLEDAS</option>'+
					'<option value="54099">NORTE DE SANTANDER-BOCHALEMA</option>'+
					'<option value="54109">NORTE DE SANTANDER-BUCARASICA</option>'+
					'<option value="54125">NORTE DE SANTANDER-CACOTA</option>'+
					'<option value="54128">NORTE DE SANTANDER-CACHIRA</option>'+
					'<option value="54172">NORTE DE SANTANDER-CHINACOTA</option>'+
					'<option value="54174">NORTE DE SANTANDER-CHITAGA</option>'+
					'<option value="54206">NORTE DE SANTANDER-CONVENCION</option>'+
					'<option value="54223">NORTE DE SANTANDER-CUCUTILLA</option>'+
					'<option value="54239">NORTE DE SANTANDER-DURANIA</option>'+
					'<option value="54245">NORTE DE SANTANDER-EL CARMEN</option>'+
					'<option value="54250">NORTE DE SANTANDER-EL TARRA</option>'+
					'<option value="54261">NORTE DE SANTANDER-EL ZULIA</option>'+
					'<option value="54313">NORTE DE SANTANDER-GRAMALOTE</option>'+
					'<option value="54344">NORTE DE SANTANDER-HACARI</option>'+
					'<option value="54347">NORTE DE SANTANDER-HERRAN</option>'+
					'<option value="54377">NORTE DE SANTANDER-LABATECA</option>'+
					'<option value="54385">NORTE DE SANTANDER-LA ESPERANZA</option>'+
					'<option value="54398">NORTE DE SANTANDER-LA PLAYA</option>'+
					'<option value="54405">NORTE DE SANTANDER-LOS PATIOS</option>'+
					'<option value="54418">NORTE DE SANTANDER-LOURDES</option>'+
					'<option value="54480">NORTE DE SANTANDER-MUTISCUA</option>'+
					'<option value="54498">NORTE DE SANTANDER-OCAÃƒâ€˜A</option>'+
					'<option value="54518">NORTE DE SANTANDER-PAMPLONA</option>'+
					'<option value="54520">NORTE DE SANTANDER-PAMPLONITA</option>'+
					'<option value="54553">NORTE DE SANTANDER-PUERTO SANTANDER</option>'+
					'<option value="54599">NORTE DE SANTANDER-RAGONVALIA</option>'+
					'<option value="54660">NORTE DE SANTANDER-SALAZAR</option>'+
					'<option value="54670">NORTE DE SANTANDER-SAN CALIXTO</option>'+
					'<option value="54673">NORTE DE SANTANDER-SAN CAYETANO</option>'+
					'<option value="54680">NORTE DE SANTANDER-SANTIAGO</option>'+
					'<option value="54720">NORTE DE SANTANDER-SARDINATA</option>'+
					'<option value="54743">NORTE DE SANTANDER-SILOS</option>'+
					'<option value="54800">NORTE DE SANTANDER-TEORAMA</option>'+
					'<option value="54810">NORTE DE SANTANDER-TIBU</option>'+
					'<option value="54820">NORTE DE SANTANDER-TOLEDO</option>'+
					'<option value="54871">NORTE DE SANTANDER-VILLACARO</option>'+
					'<option value="54874">NORTE DE SANTANDER-VILLA DEL ROSARIO</option>'+
					'<option value="63001">QUINDIO-ARMENIA</option>'+
					'<option value="63111">QUINDIO-BUENAVISTA</option>'+
					'<option value="63130">QUINDIO-CALARCA</option>'+
					'<option value="63190">QUINDIO-CIRCASIA</option>'+
					'<option value="63212">QUINDIO-CORDOBA</option>'+
					'<option value="63272">QUINDIO-FILANDIA</option>'+
					'<option value="63302">QUINDIO-GENOVA</option>'+
					'<option value="63401">QUINDIO-LA TEBAIDA</option>'+
					'<option value="63470">QUINDIO-MONTENEGRO</option>'+
					'<option value="63548">QUINDIO-PIJAO</option>'+
					'<option value="63594">QUINDIO-QUIMBAYA</option>'+
					'<option value="63690">QUINDIO-SALENTO</option>'+
					'<option value="65534">BOGOTA DC-ADUANAS ESPECIALES</option>'+
					'<option value="65535">BOGOTA DC-AEROPUERTO EL DORADO</option>'+
					'<option value="66001">RISARALDA-PEREIRA</option>'+
					'<option value="66045">RISARALDA-APIA</option>'+
					'<option value="66075">RISARALDA-BALBOA</option>'+
					'<option value="66088">RISARALDA-BELEN DE UMBRIA</option>'+
					'<option value="66170">RISARALDA-DOS QUEBRADAS</option>'+
					'<option value="66318">RISARALDA-GUATICA</option>'+
					'<option value="66383">RISARALDA-LA CELIA</option>'+
					'<option value="66400">RISARALDA-LA VIRGINIA</option>'+
					'<option value="66440">RISARALDA-MARSELLA</option>'+
					'<option value="66456">RISARALDA-MISTRATO</option>'+
					'<option value="66572">RISARALDA-PUEBLO RICO</option>'+
					'<option value="66594">RISARALDA-QUINCHIA</option>'+
					'<option value="66682">RISARALDA-SANTA ROSA DE CABAL</option>'+
					'<option value="66687">RISARALDA-SANTUARIO</option>'+
					'<option value="68001">SANTANDER-BUCARAMANGA</option>'+
					'<option value="68013">SANTANDER-AGUADA</option>'+
					'<option value="68020">SANTANDER-ALBANIA</option>'+
					'<option value="68051">SANTANDER-ARATOCA</option>'+
					'<option value="68077">SANTANDER-BARBOSA</option>'+
					'<option value="68079">SANTANDER-BARICHARA</option>'+
					'<option value="68081">SANTANDER-BARRANCABERMEJA</option>'+
					'<option value="68092">SANTANDER-BETULIA</option>'+
					'<option value="68101">SANTANDER-BOLIVAR</option>'+
					'<option value="68121">SANTANDER-CABRERA</option>'+
					'<option value="68132">SANTANDER-CALIFORNIA</option>'+
					'<option value="68147">SANTANDER-CAPITANEJO</option>'+
					'<option value="68152">SANTANDER-CARCASI</option>'+
					'<option value="68160">SANTANDER-CEPITA</option>'+
					'<option value="68162">SANTANDER-CERRITO</option>'+
					'<option value="68167">SANTANDER-CHARALA</option>'+
					'<option value="68169">SANTANDER-CHARTA</option>'+
					'<option value="68176">SANTANDER-CHIMA</option>'+
					'<option value="68179">SANTANDER-CHIPATA</option>'+
					'<option value="68190">SANTANDER-CIMITARRA</option>'+
					'<option value="68207">SANTANDER-CONCEPCION</option>'+
					'<option value="68209">SANTANDER-CONFINES</option>'+
					'<option value="68211">SANTANDER-CONTRATACION</option>'+
					'<option value="68217">SANTANDER-COROMORO</option>'+
					'<option value="68229">SANTANDER-CURITI</option>'+
					'<option value="68235">SANTANDER-EL CARMEN DE CHUCURI</option>'+
					'<option value="68245">SANTANDER-EL GUACAMAYO</option>'+
					'<option value="68250">SANTANDER-EL PEÃƒâ€˜ON</option>'+
					'<option value="68255">SANTANDER-EL PLAYON</option>'+
					'<option value="68264">SANTANDER-ENCINO</option>'+
					'<option value="68266">SANTANDER-ENCISO</option>'+
					'<option value="68271">SANTANDER-FLORIAN</option>'+
					'<option value="68276">SANTANDER-FLORIDABLANCA</option>'+
					'<option value="68296">SANTANDER-GALAN</option>'+
					'<option value="68298">SANTANDER-GAMBITA</option>'+
					'<option value="68307">SANTANDER-GIRON</option>'+
					'<option value="68318">SANTANDER-GUACA</option>'+
					'<option value="68320">SANTANDER-GUADALUPE</option>'+
					'<option value="68322">SANTANDER-GUAPOTA</option>'+
					'<option value="68324">SANTANDER-GUAVATA</option>'+
					'<option value="68327">SANTANDER-GUEPSA</option>'+
					'<option value="68344">SANTANDER-HATO</option>'+
					'<option value="68368">SANTANDER-JESUS MARIA</option>'+
					'<option value="68370">SANTANDER-JORDAN</option>'+
					'<option value="68377">SANTANDER-LA BELLEZA</option>'+
					'<option value="68385">SANTANDER-LANDAZURI</option>'+
					'<option value="68397">SANTANDER-LA PAZ</option>'+
					'<option value="68406">SANTANDER-LEBRIJA</option>'+
					'<option value="68418">SANTANDER-LOS SANTOS</option>'+
					'<option value="68425">SANTANDER-MARACAVITA</option>'+
					'<option value="68432">SANTANDER-MALAGA</option>'+
					'<option value="68444">SANTANDER-MATANZA</option>'+
					'<option value="68464">SANTANDER-MOGOTES</option>'+
					'<option value="68468">SANTANDER-MOLAGAVITA</option>'+
					'<option value="68498">SANTANDER-OCAMONTE</option>'+
					'<option value="68500">SANTANDER-OIBA</option>'+
					'<option value="68502">SANTANDER-ONZAGA</option>'+
					'<option value="68522">SANTANDER-PALMAR</option>'+
					'<option value="68524">SANTANDER-PALMAS DEL SOCORRO</option>'+
					'<option value="68533">SANTANDER-PARAMO</option>'+
					'<option value="68547">SANTANDER-PIEDECUESTA</option>'+
					'<option value="68549">SANTANDER-PINCHOTE</option>'+
					'<option value="68572">SANTANDER-PUENTE NACIONAL</option>'+
					'<option value="68573">SANTANDER-PUERTO PARRA</option>'+
					'<option value="68575">SANTANDER-PUERTO WILCHES</option>'+
					'<option value="68615">SANTANDER-RIONEGRO</option>'+
					'<option value="68655">SANTANDER-SABANA DE TORRES</option>'+
					'<option value="68669">SANTANDER-SAN ANDRES</option>'+
					'<option value="68673">SANTANDER-SAN BENITO</option>'+
					'<option value="68679">SANTANDER-SAN GIL</option>'+
					'<option value="68682">SANTANDER-SAN JOAQUIN</option>'+
					'<option value="68684">SANTANDER-SAN JOSE DE MIRANDA</option>'+
					'<option value="68686">SANTANDER-SAN MIGUEL</option>'+
					'<option value="68689">SANTANDER-SAN VICENTE DEL CHUCURI</option>'+
					'<option value="68705">SANTANDER-SANTA BARBARA</option>'+
					'<option value="68720">SANTANDER-SANTA HELENA DEL OPON</option>'+
					'<option value="68745">SANTANDER-SIMACOTA</option>'+
					'<option value="68755">SANTANDER-SOCORRO</option>'+
					'<option value="68770">SANTANDER-SUAITA</option>'+
					'<option value="68773">SANTANDER-SUCRE</option>'+
					'<option value="68780">SANTANDER-SURATA</option>'+
					'<option value="68820">SANTANDER-TONA</option>'+
					'<option value="68855">SANTANDER-VALLE DE SAN JOSE</option>'+
					'<option value="68861">SANTANDER-VELEZ</option>'+
					'<option value="68867">SANTANDER-VETAS</option>'+
					'<option value="68872">SANTANDER-VILLANUEVA</option>'+
					'<option value="68895">SANTANDER-ZAPATOCA</option>'+
					'<option value="70110">SUCRE-BUENAVISTA</option>'+
					'<option value="70124">SUCRE-CAIMITO</option>'+
					'<option value="70204">SUCRE-COLOSO</option>'+
					'<option value="70215">SUCRE-COROZAL</option>'+
					'<option value="70221">SUCRE-COVEAS (SUCRE)</option>'+
					'<option value="70230">SUCRE-CHALAN</option>'+
					'<option value="70235">SUCRE-GALERAS</option>'+
					'<option value="70265">SUCRE-GUARANDA</option>'+
					'<option value="70400">SUCRE-LA UNION</option>'+
					'<option value="70418">SUCRE-LOS PALMITOS</option>'+
					'<option value="70429">SUCRE-MAJAGUAL</option>'+
					'<option value="70473">SUCRE-MORROA</option>'+
					'<option value="70508">SUCRE-OVEJAS</option>'+
					'<option value="70523">SUCRE-PALMITO</option>'+
					'<option value="70670">SUCRE-SAMPUES</option>'+
					'<option value="70678">SUCRE-SAN BENITO ABAD</option>'+
					'<option value="70702">SUCRE-SAN JUAN DE BETULIA</option>'+
					'<option value="70708">SUCRE-SAN MARCOS</option>'+
					'<option value="70713">SUCRE-SAN ONOFRE</option>'+
					'<option value="70717">SUCRE-SAN PEDRO</option>'+
					'<option value="81001">ARAUCA-ARAUCA</option>'+
					'<option value="81065">ARAUCA-ARAUQUITA</option>'+
					'<option value="81220">ARAUCA-CRAVO NORTE</option>'+
					'<option value="81300">ARAUCA-FORTUL</option>'+
					'<option value="81591">ARAUCA-PUERTO RONDON</option>'+
					'<option value="81736">ARAUCA-SARAVENA</option>'+
					'<option value="81794">ARAUCA-TAME</option>'+
					'<option value="85001">CASANARE-YOPAL</option>'+
					'<option value="85010">CASANARE-AGUAZUL</option>'+
					'<option value="85015">CASANARE-CHAMEZA</option>'+
					'<option value="85125">CASANARE-HATO COROZAL</option>'+
					'<option value="85136">CASANARE-LA SALINA</option>'+
					'<option value="85139">CASANARE-MANI</option>'+
					'<option value="85162">CASANARE-MONTERREY</option>'+
					'<option value="85225">CASANARE-NUNCHIA</option>'+
					'<option value="85230">CASANARE-OROCUE</option>'+
					'<option value="85250">CASANARE-PAZ DE ARIPORO</option>'+
					'<option value="85263">CASANARE-PORE</option>'+
					'<option value="85279">CASANARE-RECETOR</option>'+
					'<option value="85300">CASANARE-SABANALARGA</option>'+
					'<option value="85315">CASANARE-SACAMA</option>'+
					'<option value="85325">CASANARE-SAN LUIS DE PALENQUE</option>'+
					'<option value="85400">CASANARE-TAMARA</option>'+
					'<option value="85410">CASANARE-TAURAMENA</option>'+
					'<option value="85430">CASANARE-TRINIDAD</option>'+
					'<option value="85440">CASANARE-VILLANUEVA</option>'+
					'<option value="86001">PUTUMAYO-MOCOA</option>'+
					'<option value="86219">PUTUMAYO-COLON</option>'+
					'<option value="86320">PUTUMAYO-ORITO</option>'+
					'<option value="86568">PUTUMAYO-PUERTO ASIS</option>'+
					'<option value="86569">PUTUMAYO-PUERTO CAICEDO</option>'+
					'<option value="86571">PUTUMAYO-PUERTO GUZMAN</option>'+
					'<option value="86573">PUTUMAYO-PUERTO LEGUIZAMO</option>'+
					'<option value="86749">PUTUMAYO-SIBUNDOY</option>'+
					'<option value="86755">PUTUMAYO-SAN FRANCISCO</option>'+
					'<option value="86757">PUTUMAYO-SAN MIGUEL (LA DORADA)</option>'+
					'<option value="86760">PUTUMAYO-SANTIAGO</option>'+
					'<option value="86865">PUTUMAYO-VALLE DEL GUAMUEZ (LA HORMIGA)</option>'+
					'<option value="86885">PUTUMAYO-VILLAGARZON</option>'+
					'<option value="88001">SAN ANDRES Y PROVIDENCIA-SAN ANDRES</option>'+
					'<option value="88564">SAN ANDRES-PROVIDENCIA Y SANTA CATALINA</option>'+
					'<option value="91001">AMAZONAS-LETICIA</option>'+
					'<option value="91263">AMAZONAS-EL ENCANTO</option>'+
					'<option value="91405">AMAZONAS-LA CHORRERA</option>'+
					'<option value="91407">AMAZONAS-LA PEDRERA</option>'+
					'<option value="91430">AMAZONAS-LA VICTORIA (AMAZONAS)</option>'+
					'<option value="91460">AMAZONAS-MARITI PARANA</option>'+
					'<option value="91540">AMAZONAS-PUERTO NARIÃƒâ€˜O</option>'+
					'<option value="91669">AMAZONAS-PTO SANTANDER</option>'+
					'<option value="91798">AMAZONAS-TARAPACA</option>'+
					'<option value="94001">GUAINIA-INIRIDA</option>'+
					'<option value="94343">GUAINIA-BARRANCO MINA (CD)</option>'+
					'<option value="94883">GUAINIA-SAN FELIPE (CD)</option>'+
					'<option value="94884">GUAINIA-PUERTO COLOMBIA (CD)</option>'+
					'<option value="94885">GUAINIA-LA GUADALUPE (CD)</option>'+
					'<option value="94886">GUAINIA-CACAHUAL (CD)</option>'+
					'<option value="94887">GUAINIA-PANA-PANA (CD)</option>'+
					'<option value="94888">GUAINIA-MORICHAL NUEVO (CD)</option>'+
					'<option value="95001">GUAVIARE-SAN JOSE DEL GUAVIARE</option>'+
					'<option value="95015">GUAVIARE-CALAMAR</option>'+
					'<option value="95025">GUAVIARE-EL RETORNO</option>'+
					'<option value="95200">GUAVIARE-MIRAFLORES</option>'+
			'</select></td>'+
			'<td align="right"><input type="button" value="-" class="clsEliminarFila"></td>'+
		'</tr>';
				
		/*obtenemos el padre del boton presionado (en este caso queremos la tabla, por eso
		utilizamos get(3)
			table -> padre 3
				tfoot -> padre 2
					tr -> padre 1
						td -> padre 0
		nosotros queremos utilizar el padre 3 para agregarle en la etiqueta
		tbody una nueva fila*/
		var objTabla=$(this).parents().get(3);
				
		//agregamos la nueva fila a la tabla
		$(objTabla).find('tbody').append(strNueva_Fila);
				
		//si el cuerpo la tabla esta oculto (al agregar una nueva fila) lo mostramos
		if(!$(objTabla).find('tbody').is(':visible')){
			//le hacemos clic al titulo de la tabla, para mostrar el contenido
			$(objTabla).find('caption').click();
		}
	});
	
	//cuando se haga clic en cualquier clase .clsEliminarFila se dispara el evento
	$(document).on('click','.clsEliminarFila',function(){
		/*obtener el cuerpo de la tabla; contamos cuantas filas (tr) tiene
		si queda solamente una fila le preguntamos al usuario si desea eliminarla*/
		var objCuerpo=$(this).parents().get(2);
		//alert(objCuerpo);
			if($(objCuerpo).find('tr').length==1){
				if(!confirm('Esta es el única fila de la lista ¿Desea eliminarla?')){
					return;
				}
			}
					
		/*obtenemos el padre (tr) del td que contiene a nuestro boton de eliminar
		que quede claro: estamos obteniendo dos padres
					
		el asunto de los padres e hijos funciona exactamente como en la vida real
		es una jergarquia. imagine un arbol genealogico y tendra todo claro ;)
				
			tr	--> padre del td que contiene el boton
				td	--> hijo de tr y padre del boton
					boton --> hijo directo de td (y nieto de tr? si!)
		*/
		var objFila=$(this).parents().get(1);
		var borrada=$(objFila).attr("id");
		//alert('esta es la borrada '+borrada);
		var numlinea=borrada.substring(5);
		
		//Se guarda el id del proveedor a borrar -------------------------------/
		var borrar=document.getElementById('idpr'+numlinea).value;
		
		if(borrar!=''){
			document.getElementById('Idborrar').value=document.getElementById('Idborrar').value+","+borrar;
		}
		
		anterior=document.getElementById('cantidad2').value;
		document.getElementById('cantidad2').value=anterior-1;
		
		anterior2=document.getElementById('cantidad').value;
		document.getElementById('cantidad').value=anterior2-1;
		
			/*eliminamos el tr que contiene los datos del contacto (se elimina todo el
			contenido (en este caso los td, los text y logicamente, el boton */
			$(objFila).remove();
	});
	
	//evento que se produce al hacer clic en el boton que elimina una tabla completamente
	$(document).on('click','.clsEliminarTabla',function(){
		var objTabla=$(this).parents().get(3);
			//bajamos la opacidad de la tabla hasta estar invisible
			$(objTabla).animate({'opacity':0},500,function(){
				//eliminar la tabla
				$(this).remove();
			});
			
			
	});
	
	//boton para clonar cualquiera de las tablas
	$(document).on('click','.clsClonarTabla',function(){
		var objTabla=$(this).parents().get(4);
			//agregamos un clon de la tabla a la capa contenedora
			$('#divContenedor').append($(objTabla).clone());
	});
	
			
});



		
		