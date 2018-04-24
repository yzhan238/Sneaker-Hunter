import sys
import parser
import json
import MySQLdb

if(len(sys.argv) < 3):
    print('input usr&password')

db = MySQLdb.connect("localhost", sys.argv[1], sys.argv[2], "gslproject_basic")

cs = db.cursor()

fname = 'sneakers.json'

data = None
with open(fname, 'r') as fin:
	js = fin.read()
	data = json.loads(js)

tags = {}
with open('tags.tsv', 'r') as fin:
	for line in fin:
		temp = line.strip().split('\t')
		tags[temp[0]] = temp[1] if temp[1] != 'NOTAG' else None

insert = (
  "INSERT INTO `Sneakers` (`sid`, `releaseDate`, `sales`, `retailPrice`, `brand`, `category`, `hashtag`) "
  "VALUES (%s, %s, %s, %s, %s, %s, %s)"
)

s = set()

for d in data:
	if d['sid'] in s:
		continue
	else:
		s.add(d['sid'])
	day = d['releaseDate']
	if day is not None:
		day = day.split(' ')[0]
	temp = (d['sid'], day, d['sales'], d['retailPrice'], d['brand'], d['category'], tags[d['sid']])
	cs.execute(insert, temp)
db.commit()

print('{} records inserted from: {}'.format(len(s), fname))
