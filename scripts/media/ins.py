import requests
import json
import concurrent.futures
import time

import pickle 

dicOut = 'dict'

BASE_URL = 'https://www.instagram.com/'
SEARCH_URL = BASE_URL + 'web/search/topsearch/?context=blended&query={0}'

sneakers = None
with open('sneakers.json', 'r') as f:
	text = f.read()
	sneakers = json.loads(text)
fout = open('tags.tsv', 'w')

with open(dicOut+'.pkl', 'rb') as dd:
	dic = pickle.load(dd)

def work(shoesname):
	if '%' in shoesname:
		return ('NOTAG', 0)

	sname = shoesname.split(' ')
	shoesnames = reversed(["".join(sname[:i]) for i in range(len(sname))])

	for x in shoesnames:
		if x in dic:
			if dic[x][1] == 0:
				continue
			else:
				return dic[x]
		res = requests.get(SEARCH_URL.format(x))
		res = json.loads(res.text)
		tag = res['hashtags']
		# tags.append(tag)
		if len(tag) == 0:
			dic[x] = ('', 0)
		elif tag[0]['hashtag']['media_count'] > 50:
			dic[x] = (tag[0]['hashtag']['name'], tag[0]['hashtag']['media_count'])
			return (tag[0]['hashtag']['name'], tag[0]['hashtag']['media_count'])
		else:
			dic[x] = ('', 0)
	
	return ('NOTAG', 0)

for i in range(10):
	ss = sneakers[i*100:(i+1)*100]
	with concurrent.futures.ThreadPoolExecutor(max_workers=8) as executor:
		future_to_url = {executor.submit(work, sneaker['sid']): sneaker['sid'] for sneaker in ss}
		for future in concurrent.futures.as_completed(future_to_url):
			shoesname = future_to_url[future]
			try:
				tag, count = future.result()
			except Exception as exc:
				print('%r generated an exception: %s' % (shoesname, exc))
				with open(dicOut+'.pkl', 'wb') as dd:
					pickle.dump(dic, dd)
				exit()
			else:
				fout.write('{}\t{}\t{}\n'.format(shoesname, tag, count))
with open(dicOut+'.pkl', 'wb') as dd:
	pickle.dump(dic, dd)

fout.close()