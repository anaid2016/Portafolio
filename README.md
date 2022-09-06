# Portafolio
Historial de Desarrollo

Desarrollos realizados organizados por fecha de entrega, bajo los lenguajes de programación PHP, Python, C#, Java y Javascript con diseño de frontend basico para visualizar utilidad en HTML,CSS.

**Indicadores (Mapa OpenStreet + JS)** (Clic aqui para visualizar Demo)

Objetivo:  Integrar un mapa al framework Yii2 que permita visualizar los indicadores de una empresa con varias sucursales.



**Gestor de Energia Usuario Residencial** (Clic aqui para visualizar Demo)

Objetivo

	- Adquisición de Data en sitio de un equipo de medida de energia eléctrica Modbus y envio por MQTT.
	- REST-API para el ingreso de lecturas de usuarios desde el punto de medida (POSTGRESQL).
	- Interfaz para presentar los datos de consumo de Energia al cliente Final.
	
GetDataSite

	Lenguajes
		* Python 2.7.9 
		* Pao MQTT (https://pypi.org/project/paho-mqtt/)
		
	Hardware
		* Raspberri Pi 4 + Tarjeta de Adquisición de datos para RS485
		* Equipo de Medida de Energía Electrica con Comunicación Modbus
		
	SO
		* Linux Ubuntu 18
		
		
	Esquema General de Arquitectura

	
	
Backend
	
	Framework
		* Yii2 Basic
		
	Bases de Datos
		* PostgreSQL 12
		
		
	REST-API
		* Insert Data (POST) con Autenticación Baren Token
		* Select Data (GET)
		
			


Frontend 

	Framework
		* Vue
		
	
	

			
	
	

**BLE (Android Studio)** (Video Funcionalidad)




**Inventario RFID Textiles:**
  
  Objetivo:  Estructurar y desarrollo un sistema para el control de kardex (entrada,salida) para la industria textil que permita validar la eficiencia y eficacia de los protocolos de movimiento de producto por unidades (rollos) y partes de unidad (metros y cm), para la puesta en marcha de las prácticas dentro del laboratorio de logistica.

![ArquitecturaMacro](https://github.com/anaid2016/Portafolio/blob/main/Logistica%20de%20Productos%20-%20RFID%20(PHP+MySQL+HTML+Python%20+%20C%23)/imagenes/macroproceso.jpg?raw=true)


    Modulos Desarrolados (Lenguajes):
      * APP Proveedor (PHP 5.6+HTML+CSS+JS)
      * APP BODEGA (PHP 5.6+HTML+CSS+JS)
      * APP PUNTO DE VENTA (PHP 5.6+HTML+CSS+JS)
      * APP Terminal Portatial Alistamiento y Gestión de Inventarios (C#)
      
      
   Servicios
      * Servicio de Captura para RFID (Python 2.6)
      * Servicio para Instalación de Sistema General
      * Servicio para Reinicio Sistema General      
      
    Motor Base de Datos: 
      * MySQL InnoDB
      
    SO:
      * Windows (XAMPP - Apache,Mysql) + (Python)
    
    Conexión: 
      * Editor: Visual Studio + Notepad++
      * SDK Hardware:  SDK suministrado por el proveedor de equipos RFID.
    
    Hardware Integrado:
    
      * Lector Terminar ALH-900x/901x RFID 
      * Antenas RFID Estibas portal Salida.
      * Antenas Caja Punto de Venta RFID.
      * Reader Impinj RFID.
      * Impresora ZEBRA RFID.   




























