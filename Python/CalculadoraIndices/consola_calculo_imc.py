#!/usr/bin/env python 3
"""
@autor : Diana Carrillo
@creado: 2022-10-16
@version: 1.0
"""

import calculadora_indices as calc


def ejecutar_calcular_IMC(peso:float,altura:float)->None:

    if(peso<=0):
        print("Error el peso de la persona no puede ser igual o menor que 0 [kg]")
        return

    if(altura<=0):
        print("Error la altura de la persona no puede ser igual o menor que 0 [m] ")
        return

    calculoimc = calc.calcular_IMC(peso,altura)
    imc2decimales = round(calculoimc,2)
    print(str(imc2decimales)) 

def iniciar_aplicacion()->None:
    print("En esta función se va a calcular el Indice de Masa Corporal denominado IMC.")
    peso=float(input("Ingrese el peso de la persona (en Kilogramos):"))
    altura=float(input("Ingrese la altura de la persona (en metros):"))
    ejecutar_calcular_IMC(peso,altura)


iniciar_aplicacion()
