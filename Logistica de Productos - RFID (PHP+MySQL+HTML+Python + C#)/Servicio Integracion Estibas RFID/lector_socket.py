#####################################################################
#Servicio de Escucha para solicitud cada n segundos de historial de Captura RFID en router impinj
#Ip del router: 192.168.1.142 puerto 14150
######################################################################

import time
import sys
import os
import socket
import binascii
import MySQLdb

# Definiendo variables de conexion.

TCP_IP = '192.168.1.143'		#143
TCP_PORT = 14150
BUFFER_SIZE = 1024
Path='D:\datos.txt'
db_host = 'localhost'
usuario = 'root'
clave = ''
base_de_datos = 'bodega'
base_de_datos2= 'punto_venta'


#  Definiendo mensaje de envio.
#MESSAGE="MASIVO"

try:
	print("Abriendo el puerto.")
	# Creacion del socket.
	s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
	kmysqlduplicateentry = 1062
	
	
	
	# Definicion de timeout de recepcion y tamano del socket.
	s.setblocking(0)
	s.settimeout(None)
	
	# Conexion con el socket.
	s.connect((TCP_IP, TCP_PORT))
	print("Puerto abierto...")
	
	#s.send(MESSAGE)
	#time.sleep(1)
	
	# Recepcion continua de informacion de consumos, almacenamiento en un archivo de texto plano.
	data = s.recv(BUFFER_SIZE)
	Fsave=open(Path,"a")
	Fsave.write(data)	
	sumar=1
	
	# NOTA: La cantidad de datos recibidos supera los 1024 bytes, por lo tanto el comando de recepcion de 
	# trama deber ser recursivo.
	while(data.find("H")==-1):
		data = s.recv(BUFFER_SIZE)
		Fsave.write(data)
		
		#print data	
		words = data.split()
			
		antena = words[0]
		tag = words[1]
		sumar=sumar+1
		tag=tag.lstrip('+-0')
		cantstr=len(tag)
		

		if cantstr>20 and int(antena)<=4:
				
			tag_ref=tag.decode('hex');
			
			pedidos = tag_ref.split("P");
			for val in pedidos:
			
				val.strip()
				
				#INGRESANDOLO EN LA BASE DE DATOS=========================================================================
				sql="INSERT INTO tags (antena,tag,tipo,movimiento) VALUES ('"+antena+"','"+val+"','2','1') "
				db = MySQLdb.connect("127.0.0.1","root","","bodega" )
				try:
					cursor = db.cursor()
					cursor.execute(sql)
					db.commit()
				except MySQLdb.IntegrityError, message:
					errorcode = message[0]	# get MySQL error code
					if errorcode == kmysqlduplicateentry :	# if duplicate
						print "duplicado 1"
					else:
						print "aqui no accede"
				
				db.close()
		
		else:
	
			#IDENTIFICANDO LA ATENA PARA ACCESO A LA BASE DE DATOS=============================================================================
			if int(antena)<=4:
			
				tag=tag.lstrip('+-0')
				sql="INSERT INTO tags (antena,tag,tipo,movimiento) VALUES ('"+antena+"','"+tag+"','1','1') "
				db = MySQLdb.connect("127.0.0.1","root","","bodega" )
				try:
					cursor = db.cursor()
					cursor.execute(sql)
					db.commit()
					Fsave.write(sql)
				except MySQLdb.IntegrityError, message:
					errorcode = message[0]	# get MySQL error code
					if errorcode == kmysqlduplicateentry :	# if duplicate
						print "duplicado 2"
					else:							
						print "error 1"
				
				db.close()
				
			elif int(antena)<=8:

				tag=tag.lstrip('+-0')
				sql="UPDATE tags SET antena2='"+antena+"',estado=2,movimiento='2' WHERE tag='"+tag+"' "
				db = MySQLdb.connect("127.0.0.1","root","","bodega" )
				print tag+"::"+antena
				try:
					cursor = db.cursor()
					cursor.execute(sql)
					db.commit()
					#print "2"+tag
				except MySQLdb.IntegrityError, message:
					errorcode = message[0]	# get MySQL error code
					if errorcode == kmysqlduplicateentry :	# if duplicate
						print "duplicado 3"
					else:
						print "error 2"
				
				db.close()
			
			elif int(antena)<=12:		#Ingreso al Inventario del Punto de Venta
				
				tag=tag.lstrip('+-0')
				tag2 = int(tag, 16)
				tag2 = str(tag2)

				sql="UPDATE pv_movimientoproducto SET cajonera='"+antena+"' WHERE RFID='"+tag2+"' "
				db = MySQLdb.connect("127.0.0.1","root","","punto_venta" )
				
				try:
					cursor = db.cursor()
					cursor.execute(sql)
					db.commit()
				except MySQLdb.IntegrityError, message:
					errorcode = message[0]	# get MySQL error code
					if errorcode == kmysqlduplicateentry :	# if duplicate
						print "duplicado 4"
					else:
						print "error 3"
				
				db.close()
			elif int(antena)<=13:
				tag=tag.lstrip('+-0')
				tag2 = int(tag, 16)
				tag2 = str(tag2)
				
				
				sql="INSERT INTO caja1 SET RFID='"+tag2+"' "
				print "caja1"+tag2
				db = MySQLdb.connect("127.0.0.1","root","","punto_venta" )
				
				try:
					cursor = db.cursor()
					cursor.execute(sql)
					db.commit()
				except MySQLdb.IntegrityError, message:
					errorcode = message[0]	# get MySQL error code
					if errorcode == kmysqlduplicateentry :	# if duplicate
						print "duplicado 5"
					else:
						print "error 4"
				
				db.close()
			
			else:	
				print antena+"::"+tag			
	Fsave.close()
	s.close()
	print("Termino")

except Exception,e:
	data=-1
	s.close()
	print("error-- "+str(e))
