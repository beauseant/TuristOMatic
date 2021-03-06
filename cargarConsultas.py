import sys
sys.path.append('lib/')
from DBConsultas import DB

import argparse
import os




if __name__ == '__main__':


	parser = argparse.ArgumentParser(description='consultas')
	parser.add_argument('host', help='el host al que nos conectamos')
	parser.add_argument('database', help='la base de datos de conexion')
	parser.add_argument('user', help='el usuario de la bd')
	parser.add_argument('pwd', help='la contrasenna de conexion')
	parser.add_argument('csv', help='fichero con el csv con las categorias')
	parser.add_argument('encode', help='codificacion del fichero utf8, windows1512...')
	args = parser.parse_args()




	#	print args.pwd
	consultas =  DB (dbName=args.database, host=args.host, user=args.user, pwd=args.pwd)


	consultas.cargarConsultas ( args.csv, codec=args.encode )	

	#lo dejamos preparado para cargar las busquedas con las tablas vacias.
	consultas.borrarColeccionBusq ()	
	consultas.borrarLog ()
