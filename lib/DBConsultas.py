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
	__collectionCategorias 			= None
	__collectionConsultas 			= None
	__collectionUsers 				= None
	__collectionDestinos 			= None
	__collectionBusquedas 			= None
	__collectionDestinos 			= None
	__collectionDestinosExpandidos  = None
	__collectionLog					= None
	__conn = None


	__categoriesList = None
	__dictCats = {}
	
	__querysTotales = None

	__dictNormalizado = {'á': 'a', 'é': 'e','ó':'o','ú':'u','í':'i','à':'a','è':'e','ì':'i','ò':'o','ù':'u'}

	def connect( self ):
		'''
			mongodb creates databases and collections automatically for you if they don't exist already. 
		'''		
		try:
			client = MongoClient( self.__host )
			client[ self.__dbName ].authenticate ( self.__user, self.__pwd )
			self.__db = client[ self.__dbName ]

			self.__collectionCategorias 			= self.__db [ 'categoria' ]
			self.__collectionConsultas 				= self.__db [ 'consulta' ]
			self.__collectionBusquedas 				= self.__db [ 'busqueda' ]
			self.__collectionDestinos 				= self.__db [ 'destino' ]
			self.__collectionDestinosExpandidos 	= self.__db [ 'destinoExpandido' ]
			self.__collectionLog					= self.__db [ 'log' ]
		
			self.__collectionCategorias.create_index( [('idcategoria', pymongo.TEXT)], name='categoria_index', default_language='english')
			self.__collectionConsultas.create_index( [('idconsulta', pymongo.TEXT)], name='consulta_index', default_language='english')
			self.__collectionBusquedas.create_index( [('ID', pymongo.TEXT)], name='busqueda_index', default_language='english')
			self.__collectionDestinos.create_index( [('iddestino', pymongo.TEXT)], name='busqueda_index', default_language='english')
			self.__collectionDestinosExpandidos.create_index( [('iddestino', pymongo.TEXT)], name='busqueda_index', default_language='english')

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
			
	#codec='WINDOWS-1252 DE'
	#ISO-8859-2 FR
	def cargarConsultas ( self, fich, codec='ISO-8859-2',delimiter=','):


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



	def cargarDestinosExpandidos (self):
		destinosExpand 	= self.__collectionDestinosExpandidos.find ({})

		salida = {}
		for destino in destinosExpand:
			salida.update ( {destino['consultaexpandida']:[destino['iddestino'],destino['idconsulta']]})

		return salida



	def normalizar (self, line):
		return (line.lower().translate(str.maketrans( self.__dictNormalizado )))

	def cargarDestinos ( self, fich ):
		print ('loading {}'.format (fich))

		self.__collectionDestinos.remove({})

		lines = [{'iddestino':posicion, 'destino':line.rstrip('\n'), 'destino_normalizado':self.normalizar (line.rstrip('\n'))} for posicion, line in enumerate (open( fich ))]

		self.__collectionDestinos.insert (lines)


	def expandirDestinos ( self ):

		self.__collectionDestinosExpandidos.remove({})

		destinos 	= self.__collectionDestinos.find ({},{'iddestino':1,'destino_normalizado':1})
		consultas 	= self.__collectionConsultas.find ({},{'idconsulta':1,'consulta':1})

		destinosExpand = []
		
		#tenemos que recorrerlo una vez por cada consulta, si no lo pasamos a una lista
		#al ser un cursor deberíamos volver a cargarlo porque lo agotamos:
		destinos = list(destinos)


		for c in consultas:						
			for d in destinos:
				#print ('{} - {}'.format (c['idconsulta'], d['iddestino']))
				salida = {'iddestino':d['iddestino'],'idconsulta':c['idconsulta'],'consultaexpandida':c['consulta'].replace ('XXX',d['destino_normalizado'])}
				destinosExpand.append (salida)


		self.__collectionDestinosExpandidos.insert ( destinosExpand )


	def borrarColeccionBusq (self ):
		self.__collectionBusquedas.remove({})

	def cargarBusquedas ( self, fich, codec='utf-8',delimiter=','):
		print ('loading {}'.format (fich))

		

		codec = str (codec)
		delimiter = str(delimiter)


		with open (fich, encoding= codec ) as fichBusq:			

			busquedasList = fichBusq.readlines()
		
		header = [b.replace ('"','').replace('\n','') for b in busquedasList.pop(0).split ( delimiter )]


		#testing:
		#busquedasList = busquedasList [:20]

		idAnterior = -1

		salida = []
		pos = 0

		#adjuntamos a cada busqueda el id del destino al que se refiere y la consulta:
		de = self.cargarDestinosExpandidos ()

		#guardamos los destinos no encontrados como fallo:
		fallos = []

		correctos = 0

		for busqueda in busquedasList:
			listaB = busqueda.replace('\n','').replace('"','').split ( delimiter )
			
			dato = {}
			for i,unheader in enumerate (header):
				dato [unheader] = listaB[i]
			dato['ID'] = int (dato['ID'])

			try:
				dato['iddestino'] = de[dato['Query']][0]
				dato['idconsulta'] = de[dato['Query']][1]
				correctos += 1
			except Exception as E:
				fallos.append ({'idbusqueda':dato['ID'],'Query':dato['Query']})

			salida.append (dato)

		self.__collectionLog.insert ( fallos )
		self.__collectionBusquedas.insert ( salida )
		

	def borrarLog (self):
		self.__collectionLog.remove ()