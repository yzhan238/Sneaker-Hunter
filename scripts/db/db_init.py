import MySQLdb
import sys
import parser

if(len(sys.argv) < 3):
    print('input usr&password')

fname = input('')

db = MySQLdb.connect("localhost", sys.argv[1], sys.argv[2], "gslproject_basic")

cs = db.cursor()

data = parser.getData(fname)

insert = (
  "INSERT INTO `Transactions` (`sid`, `date`, `time`, `size`, `price`) "
  "VALUES (%s, %s, %s, %s, %s)"
)

for d in data:
	cs.execute(insert, d)
	#print(d)
#print(cs.execute("SELECT * FROM Transactions"))
db.commit()

print('{} records inserted from: {}'.format(len(data), fname))
