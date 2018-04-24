import sys
import parser
import json
import pickle
import MySQLdb

if(len(sys.argv) < 3):
    print('input usr&password')

db = MySQLdb.connect("localhost", sys.argv[1], sys.argv[2], "gslproject_basic")

cs = db.cursor()

fname = 'recom.pkl'

recom = {}
with open(fname, 'rb') as fin:
	recom = pickle.load(fin)

insert = (
  "INSERT INTO `Recom` (`sid`, `sid2`) "
  "VALUES (%s, %s)"
)

for k,v in recom.items():
	for vv in v:
		cs.execute(insert, (k, vv))
db.commit()
