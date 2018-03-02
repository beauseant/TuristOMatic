# -*- coding: utf-8 -*-

import pandas as pd
from pymongo import MongoClient
import pymongo



class DB (object):


	__host = 'localhost'
	__port = 2701

	__dbName = ''

	__pwd  = ''
	__user = ''
	__db = None
	__collectionCategorias = None
	__collectionConsultas = None
	__collectionUsers = None
	__conn = None


	__categoriesList = None
	__dictCats = {}
	
	__querysTotales = None

	def connect( self ):
		'''
			mongodb creates databases and collections automatically for you if they don't exist already. 
		'''		
		try:
			client = MongoClient( self.__host )
			client[ self.__dbName ].authenticate ( self.__user, self.__pwd )
			self.__db = client[ self.__dbName ]

			self.__collectionCategorias = self.__db [ 'categoria' ]
			self.__collectionConsultas = self.__db [ 'consulta' ]
			self.__collectionBusquedas = self.__db [ 'busqueda' ]
		
			self.__collectionCategorias.create_index( [('idcategoria', pymongo.TEXT)], name='categoria_index', default_language='english')
			self.__collectionConsultas.create_index( [('idconsulta', pymongo.TEXT)], name='consulta_index', default_language='english')
			self.__collectionBusquedas.create_index( [('ID', pymongo.TEXT)], name='busqueda_index', default_language='english')
			

		except Exception as E:
			print ('fail to connect mongodb @ %s:%d, %s', self.__host, self.__port, str (E) )
			print (str(E))
			return -1

		print ("connected to mongodb @ %s:[%s]", self.__host, self.__port)


	def __init__ ( self, dbName, host, user, pwd ):
		self.__dbName = dbName
		self.__pwd = pwd
		self.__user = user
		self.__host = host

		if self.connect () == -1:
			raise NameError('DBConnectError')
		else:
			#self.createIndex ()
			pass
			

	def cargarConsultas ( self, fich, codec='WINDOWS-1252',delimiter=','):


		print ('loading {}'.format (fich))

		self.__collectionCategorias.remove({})
		self.__collectionConsultas.remove({})

		codec = str (codec)
		delimiter = str(delimiter)


		df = pd.read_csv(fich,  encoding = codec )
		df.set_index('Unnamed: 0')  

		categoriasList = []

		for column in  df.columns:
			data =  (column.split('_'))
			if (data[0] != 'Unnamed: 0'):				
				categoriasList.append ({'idcategoria':int(data[0]),'consulta':data[1]})

		self.__collectionCategorias.insert (categoriasList)

		consultasList = []
		for index, row in df.iterrows():
			
			lista = [i-1 for i, e in enumerate(row) if e != 0][1:]
			listaText = [categoriasList [i]['consulta'] for i in lista]
			
			consulta = row.tolist()[0].split('_')

			consultasList.append ({'idconsulta':int(consulta[0]),'consulta':consulta[1],'categorias':lista,'categoriasText':listaText})
		
		self.__collectionConsultas.insert (consultasList)



	def borrarColeccionBusq (self ):
		self.__collectionBusquedas.remove({})

	def cargarBusquedas ( self, fich, codec='utf-8',delimiter=','):
		print ('loading {}'.format (fich))

		

		codec = str (codec)
		delimiter = str(delimiter)


		with open (fich, encoding= codec ) as fichBusq:			

			busquedasList = fichBusq.readlines()
		
		header = [b.replace ('"','').replace('\n','') for b in busquedasList.pop(0).split (',')]


		#testing:
		#busquedasList = busquedasList [:20]

		idAnterior = -1

		salida = []
		pos = 0

		for busqueda in busquedasList:
			listaB = busqueda.replace('\n','').replace('"','').split (',')
			
			dato = {}
			for i,unheader in enumerate (header):
				dato [unheader] = listaB[i]
			dato['ID'] = int (dato['ID'])

			salida.append (dato)
		
		self.__collectionBusquedas.insert ( salida )
		

