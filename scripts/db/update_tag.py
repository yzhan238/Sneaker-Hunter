import pickle
import sys
import parser
import json
import MySQLdb

if(len(sys.argv) < 3):
    print('input usr&password')

db = MySQLdb.connect("localhost", sys.argv[1], sys.argv[2], "gslproject_basic")

cs = db.cursor()

fname = 'tags.tsv'

dic = {}
with open(fname, 'r') as f:
	for line in f:
		temp = line.strip().split('\t')
		dic[temp[0]] = temp[1] if temp[1] != 'NOTAG' else None

update = (
  "UPDATE `Sneakers` SET `hashtag` = %s WHERE `Sneakers`.`sid` = %s"
)

for k,v in dic.items():
	cs.execute(update, (v, k))

db.commit()