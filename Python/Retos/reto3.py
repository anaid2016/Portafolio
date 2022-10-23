
#!/usr/bin/env python 3
"""
@autor : Diana Carrillo
@creado: 2022-10-16
@version: 1.0
"""


def es_divisible(n:int,d:int)->int:
    """Function for identificate if number n is divisible for 2d
    Into: n Interger and d Interger
    Output: If n is divisible on 2d return 2, If n is divisble on d return 1, if not is divisible return 0"""

    if d == 0:
        return 0
    else:      
        r = n%(2*d)
        if r == 0:
            return 2
        else:
            r = n % d
            if r == 0:
                return 1
            else:
                return 0

print(es_divisible(0,5))