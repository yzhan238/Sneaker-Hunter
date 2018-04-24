import json
import pickle
import requests
import concurrent.futures

with open("sneakers.json", 'r') as f:
	data = json.load(f)

def work(key):
	
	source_code = requests.get("https://stockx.com/" + key).text

	start = source_code.find('class="image-container">')

	if start == -1:
		start = source_code.find('product-media')
		start = source_code.find('src="', start)
		start += len('src="')
		temp = source_code.find('.jpg', start)
		ttemp = source_code.find('"', start)
		if source_code[start] != 'h':
			# print(source_code[start:temp+4])
			return []
		if temp == -1 or temp > ttemp:
			temp = source_code.find('.png', start)
			if temp > ttemp or temp == -1:
				temp = source_code.find('.jpeg', start)
				if temp > ttemp:
					return []
		# print(source_code[start:temp+4])
		return [source_code[start:temp+4]]
	print(key)
	start = source_code.find('src="', start)
	end = source_code.find('</div>', start)

	ret = []

	while start < end:
		start += len('src="')
		temp = source_code.find('.jpg', start)
		ret.append(source_code[start:temp+4])
		start = source_code.find('src="', temp)
	return ret

dic = {}
with open('stockx_images.pkl', 'rb') as f:
	dic = pickle.load(f)

d = {}
for i in data:
	if len(dic[i['sid']]) == 0:
		d[i['sid']] = i['urlKey']
print(len(d))

with concurrent.futures.ThreadPoolExecutor(max_workers=8) as executor:
	future_to_url = {executor.submit(work, v): k for k,v in d.items()}# if len(dic[k])==0}
	for future in concurrent.futures.as_completed(future_to_url):
		sid = future_to_url[future]
		try:
			res = future.result()
		except Exception as exc:
			print('%r generated an exception: %s' % (sid, exc))
			# with open('stockx_images.pkl', 'wb') as dd:
			# 	pickle.dump(dic, dd)
			exit()
		else:
			dic[sid] = res
count=0
for k,v in dic.items():
	if len(v) == 0:
		count += 1
print(count)

with open('stockx_images.pkl', 'wb') as f:
	pickle.dump(dic, f)