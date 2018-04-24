import sys
import parser
import json
import pickle
import MySQLdb

if(len(sys.argv) < 3):
    print('input usr&password')

db = MySQLdb.connect("localhost", sys.argv[1], sys.argv[2], "gslproject_basic")

cs = db.cursor()

fname = 'tag_ids.pkl'

tags = {}
with open(fname, 'rb') as fin:
	tags = pickle.load(fin)

insert = (
  "INSERT INTO `Images` (`tag`, `image`) "
  "VALUES (%s, %s)"
)

for k,v in tags.items():
	for vv in v:
		cs.execute(insert, (k, vv))
db.commit()