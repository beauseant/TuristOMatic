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
			self.__collectionUser = self.__db [ 'user' ]

		except Exception as E:
			print ('fail to connect mongodb @ %s:%d, %s', self.__host, self.__port, str (E) )
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
			

	def cargarCSV ( self, fich, codec='ISO-8859-1',delimiter=','):


		print ('loading {}'.format (fich))
		codec = str (codec)
		delimiter = str(delimiter)


		df = pd.read_csv(fich,  encoding = codec )
		df.set_index('Unnamed: 0')  

		for column in  df.columns:
			print (column.split('_'))
		
		for index, row in df.iterrows():
			print (row)
			lista = [i for i, e in enumerate(row) if e != 0][1:]
			import ipdb ; ipdb.set_trace()

		import ipdb ; ipdb.set_trace()
		exit()
		with open(fich) as f:
			#reader = csv.reader(f, delimiter=(delimiter), dialect=csv.excel_tab)
			#columns = list(zip(*reader))

			df = pd.read_csv(fich)
			names = df.columns.values() 
			import ipdb ; ipdb.set_trace()

			#headers = d_reader.fieldnames
			import ipdb ; ipdb.set_trace()
			catTotales = []
			contador = 0
			for col in columns:
				princ = col[0].decode(codec).encode('utf8') 
				for data in col[1:]:
					if not (data==''):
						data = data.decode(codec).encode('utf8') 
						catTotales.append ({'categoria':data,'familia':princ,'catid':contador})
						contador += 1

			#self.__collectionCategorias.insert ( catTotales )

			#import ipdb ; ipdb.set_trace()

