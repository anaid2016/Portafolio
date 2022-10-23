#!/usr/bin/env python 3
"""
@autor : Diana Carrillo
@creado: 2022-10-16
@version: 1.0
"""


def calcular_IMC(peso:float,altura:float)->float:
    """Calcula el indice de masa corporal de una persona a partir de la ecuación definida
    Parametros:
        peso: flotante, peso de la persona en kilogramos
        altura: altura de la persona en metros 
    Retorna:
        Indice de masa coporal flotante IMC= (peso)/(altura al cuadrado)"""
    
    numerador = peso
    denominador = altura**2
    imc = numerador / denominador
    return imc

def calcular_porcentaje_grasa(peso:float,altura:float,edad:int,valor_genero:float)->float:
    """Calcula el porcentaje de grasa de una persona a partir de la ecuación:
        %GC = 1.2 * IMC + 0.23 * edad(años) - 5.4 - valor_genero 
    Parametros:
        peso: flotante, peso de la persona en kilogramos
        altura: flotante, altura de la persona en metros
        edad: int edad de la persona en años
        valor_genero: valor que varia segun el genero de la persona, Hombre: 10.8 o Mujer:0
    Retorna:
        El porcentaje de grasa que la persona tiene en el cuerpo"""

    imc = calcular_IMC(peso,altura)
    ap_imc = 1.2 * imc
    ap_edad = 0.23 * edad

    por_gc = ap_imc + ap_edad - 5.4 - valor_genero

    return por_gc


def calcular_calorias_en_reposo(peso:float,altura:float,edad:int,valor_genero:int)->float:
    """Calcula la cantidad de calorías que una persona quema estando en reposo
(esto es, su tasa metabólica basal),a partir de la ecuacion:
        TMB = (10 * peso (kg)) + (6.25 * altura(cm)) - (5 * edad(años)) + valor_genero
    Parametros:
        peso: flotante, peso de la persona en kilogramos
        altura: flotante, altura de la persona en centimetros
        edad: entero, edad de la persona en años
        valor_genero: entero, valor segun genero Hombres: 5 y Mujeres: -161
    Retorna:
       La cantidad de calorias que la persona quema en reposo 
    """

    ap_peso = 10*peso
    ap_altura = 6.25*altura
    ap_edad = 5*edad
    tmb = ap_peso + ap_altura - ap_edad + valor_genero

    return tmb

def calcular_calorias_en_actividad(peso:float,altura:float,edad:int,valor_genero:float,valor_actividad:float)->float:
    """Calcula la cantidad de calorías que una persona quema al realizar algún tipo
de actividad física (esto es, su tasa metabólica basal según actividad física),
a partir de la ecuacion:
        TMBactividafisica  = TMB * valor_actividad
    Parametros:
        peso: flotante, peso de la persona en kilogramos
        altura: flotante, altura de la persona en centimetros
        edad: entero, edad de la persona en años
        valor_genero: entero, valor segun genero Hombres: 5 y Mujeres: -161
        valor_actividad: Depende de la actividad fisica semanal 
            1.2: poco o ningún ejercicio
            1.375: ejercicio ligero (1 a 3 días a la semana)
            1.55: ejercicio moderado (3 a 5 días a la semana)
            1.725: deportista (6 -7 días a la semana)
            1.9: atleta (entrenamientos mañana y tarde)
    Retorna:
        La cantidad de calorias que una persona quema al relaizar ejercicio semanalmente.
    """

    tmb = calcular_calorias_en_reposo(peso,altura,edad,valor_genero)
    tmb_act_fisica = tmb * valor_actividad

    return tmb_act_fisica


def consumo_calorias_recomendado_para_adelgazar(peso:float,altura:float,edad:float,valor_genero:float)->str:

    """Calcula el rango de calorías recomendado, que debe consumir una persona
diariamente en caso de que desee adelgazar, a partir de la ecuacion:
        CaloriasAdelgazar = 0.8 * TMB
     peso: flotante, peso de la persona en kilogramos
        altura: flotante, altura de la persona en centimetros
        edad: entero, edad de la persona en años
        valor_genero: entero, valor segun genero Hombres: 5 y Mujeres: -161
    Retorna:
       El rango para adelgazar menor y mayor
    """

    tmb = calcular_calorias_en_reposo(peso,altura,edad,valor_genero)
    rangomenor = tmb * 0.8
    rangomayor = tmb * 0.85

    rangomenor_dec = round(rangomenor,2)
    rangomayor_dec = round(rangomayor,2)

    return "Para adelgazar es recomendado que consumas entre: "+str(rangomenor_dec)+ " y "+str(rangomayor_dec)+" calorías al día."













    