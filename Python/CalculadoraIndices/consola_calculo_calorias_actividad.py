#!/usr/bin/env python 3
"""
@autor : Diana Carrillo
@creado: 2022-10-16
@version: 1.0
"""

import calculadora_indices as calc


def ejecutar_calcular_calorias_en_actividad()->None:

    try:

        stractividad = "Seleccione el valor actividad teniendo en cuenta:\n" 
        stractividad += "1.2 si hace poco o ningún ejercicio\n"   
        stractividad += "1.375: ejercicio ligero (1 a 3 días a la semana)\n"
        stractividad += "1.55: ejercicio moderado (3 a 5 días a la semana)\n"
        stractividad += "1.725: deportista (6 -7 días a la semana)\n"
        stractividad += "1.9: atleta (entrenamientos mañana y tarde),\n "
        stractividad += "Ingrese su valor: "

        peso=float(input("Ingrese el peso de la persona (en Kilogramos):"))
        altura=float(input("Ingrese la altura de la persona (en centimetros):"))
        edad=int(input("Ingrese la edad de la persona (en años):"))
        valor_genero=float(input("Ingrese el valor del genero teniendo en cuenta 5 Hombre, y -161 Mujer:"))        
        valor_actividad=float(input(stractividad))

        if(peso<=0):
            print("Error el peso de la persona no puede ser igual o menor que 0 [kg]")
            return

        if(altura<=0):
            print("Error la altura de la persona no puede ser igual o menor que 0 [cm] ")
            return

        if(edad<=0):
            print("Error la edad de la persona no puede se igual a 0")
            return    

        if(valor_genero!=5 and valor_genero!=-161):
            print("Error, los valores para genero solo pueden ser 5 o -161")  
            return  
        
        arrayactividades = [1.2,1.375,1.55,1.725,1.9]
        if valor_actividad not in arrayactividades:
            print("Error el valor de la actividad no se encuentra definido, seleccione uno de los valores definidos Ej: 1.2")
            return


        calc_calorias_actividad = calc.calcular_calorias_en_actividad(peso,altura,edad,valor_genero,valor_actividad)
        calc_calorias_actividad_dec = round(calc_calorias_actividad,2) 

        print(str(calc_calorias_actividad_dec)+" cal") 
    except:
        print("Se ha generado un error, porfavor verifique los valores ingresados") 


def iniciar_aplicacion()->None:
    print("En esta función se va a calcular las calorias que una persona quema realizando algun tipo de actividad fisica, porfavor ingrese los valores solicitados.")
    ejecutar_calcular_calorias_en_actividad()


iniciar_aplicacion()
            
