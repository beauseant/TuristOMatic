import sys
sys.path.append('lib/')
from DBConsultas import DB

import argparse
import os

'''

    Este programilla es una pequenno apanno porque las categorias que se entregaron
    en un principio no estaban divididas en categorias.

        Es decir tenemos movilidad en destino, agenda, ranking etc
        Y ahora tenemos que 
            1.  Información sobre el destino
	            1.1 INFORMACIÓN PRÁCTICA
                    Movilidad en destino
                    Accesibilidad en destino etc etc

    Esa nueva categorizacion la hacemos a mano porque no tenemos un CSV de partida.

'''


if __name__ == '__main__':

    parser = argparse.ArgumentParser(description='consultas')
    parser.add_argument('host', help='el host al que nos conectamos')
    parser.add_argument('database', help='la base de datos de conexion')
    parser.add_argument('user', help='el usuario de la bd')
    parser.add_argument('pwd', help='la contrasenna de conexion')
    args = parser.parse_args()

    consultas =  DB (dbName=args.database, host=args.host, user=args.user, pwd=args.pwd)

    #Todo lo que sea menor de 178 se le pone tipo de busqueda, lo que sea menor de 173 perfil de viajero..
    #Es importante el orden de la lista, ya que primero ponemos a todos como tipo de busqueda y luego vamos
    #poniendo el resto. Como digo, no es muy elegante esta solucion.
    lista = [
            [182,'Tipo de búsqueda'],
            [173,'Perfil de viajero y tipo de turismo'],
            [154,'Plataformas'],
            [145,'Servicios y actividades'],
            [39,'Información sobre el destino'],                                                   
    ]

    for cat in lista:
        id = cat[0]
        catPrinc = cat[1]

        consultas.grabarLibroCodigos ( id, catPrinc , tipo='principal', multi=True )	


