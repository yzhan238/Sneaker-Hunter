import pickle
import sys
import parser
import json
import MySQLdb

if(len(sys.argv) < 3):
    print('input usr&password')

db = MySQLdb.connect("localhost", sys.argv[1], sys.argv[2], "gslproject_basic")

cs = db.cursor()

fname = 'main_images.pkl'

with open(fname, 'rb') as f:
	dic = pickle.load(f)

update = (
  "UPDATE `Sneakers`"
  "SET `image` = %s"
  "WHERE `Sneakers`.`sid` = %s"
)

for k,v in dic.items():
	cs.execute(update, (v, k))

db.commit()
