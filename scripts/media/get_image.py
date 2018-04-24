import instagram_explore as ie
import pickle

d = {}
with open('tag_ids.pkl', 'rb') as dd:
	d = pickle.load(dd)

print(len(d))

for k,v in d.items():
	if(len(v) == 0):
		try:
			images = ie.tag_images(k).data[:5]
		except Exception as exc:
			print('%r generated an exception: %s' % (k, exc))
			with open('tag_ids.pkl', 'wb') as f:
				pickle.dump(d, f)
			i=0
			for k1,v1 in d.items():
				if len(v1) > 0:
					i += 1
			print(i)
			exit()
		else:
			d[k] = images

with open('tag_ids.pkl', 'wb') as f:
	pickle.dump(d, f)