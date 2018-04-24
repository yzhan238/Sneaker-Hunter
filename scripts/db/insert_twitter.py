import sys
import parser
import json
import MySQLdb

if(len(sys.argv) < 3):
    print('input usr&password')

db = MySQLdb.connect("localhost", sys.argv[1], sys.argv[2], "gslproject_basic")

cs = db.cursor()

#fname = 'sneakers.json'

#data = None
#with open(fname, 'r') as fin:
#	js = fin.read()
#	data = json.loads(js)



insert = (
  "INSERT INTO `Twitter` (`sid`,`user`,`followers`,`price`,`link`) "
  "VALUES (%s, %s, %s, %s, %s)"
)

#s = set()
with open('prices.txt', 'r') as file:
	for line in file:
		temp = (line.split("\t")[0], line.split("\t")[1], line.split("\t")[2],line.split("\t")[3],line.split("\t")[4])
		cs.execute(insert, temp)

db.commit()

#print('{} records inserted from: {}'.format(len(s), fname))
