import sys
sys.path.append('lib/')
from DBConsultas import DB

import configparser
import argparse
import os




if __name__ == '__main__':

	parser = argparse.ArgumentParser(description='consultas')
	parser.add_argument('host', help='el host al que nos conectamos')
	parser.add_argument('database', help='la base de datos de conexion')
	parser.add_argument('user', help='el usuario de la bd')
	parser.add_argument('pwd', help='la contrasenna de conexion')
	parser.add_argument('csv', help='fichero con el csv con las busquedas')
	args = parser.parse_args()

	config = configparser.ConfigParser()
	config.read('consultas.cfg')


	#	print args.pwd
	consultas =  DB (dbName=args.database, host=args.host, user=args.user, pwd=args.pwd)

	
	consultas.cargarBusquedas ( args.csv )		
