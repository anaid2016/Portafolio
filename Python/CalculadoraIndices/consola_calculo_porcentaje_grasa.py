#!/usr/bin/env python 3
"""
@autor : Diana Carrillo
@creado: 2022-10-16
@version: 1.0
"""

import calculadora_indices as calc


def ejecutar_calcular_porcentaje_grasa()->None:
    try:
        peso=float(input("Ingrese el peso de la persona (en Kilogramos):"))
        altura=float(input("Ingrese la altura de la persona (en metros):"))
        edad=int(input("Ingrese la edad de la persona (en años):"))
        valor_genero=float(input("Ingrese el valor del genero teniendo en cuenta 10.8 Hombre, y 0 Mujer:"))        

        if(peso<=0):
            print("Error el peso de la persona no puede ser igual o menor que 0 [kg]")
            return

        if(altura<=0):
            print("Error la altura de la persona no puede ser igual o menor que 0 [m] ")
            return

        if(edad<=0):
            print("Error la edad de la persona no puede se igual a 0")
            return    

        if(valor_genero!=10.8 and valor_genero!=0):
            print("Error, los valores para genero solo pueden ser 10.8 o 0")  
            return  

        cal_por_grasa = calc.calcular_porcentaje_grasa(peso,altura,edad,valor_genero)
        cal_por_grasa_dec = round(cal_por_grasa,2)

        print(str(cal_por_grasa_dec)+"%")

    except:
        print("Se ha generado un error, porfavor verifique los valores ingresados")    



def iniciar_aplicacion()->None:
    print("En esta función se va a calcular el Porcentaje de Grasa de una persona, por favor ingrese los datos solicitados.")
    ejecutar_calcular_porcentaje_grasa()


iniciar_aplicacion()



