#!/usr/bin/env python 3
"""
@autor : Diana Carrillo
@creado: 2022-10-16
@version: 1.0
"""

import calculadora_indices as calc

def ejecutar_consumo_calorias_recomendado_para_adelgazar()->None:

    try:
        peso=float(input("Ingrese el peso de la persona (en Kilogramos):"))
        altura=float(input("Ingrese la altura de la persona (en centimetros):"))
        edad=int(input("Ingrese la edad de la persona (en años):"))
        valor_genero=float(input("Ingrese el valor del genero teniendo en cuenta 5 Hombre, y -161 Mujer:"))        

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
        
        cal_recom_adelgazar = calc.consumo_calorias_recomendado_para_adelgazar(peso,altura,edad,valor_genero)
        
        print(cal_recom_adelgazar)
    
    except:
        print("Se ha generado un error, porfavor verifique los valores ingresados") 

def iniciar_aplicacion()->None:
    print("En esta función se va a calcular el rango de calorias que una persona debe consumir para adelgazar, porfavor ingrese los valores solicitados.")
    ejecutar_consumo_calorias_recomendado_para_adelgazar()


iniciar_aplicacion()