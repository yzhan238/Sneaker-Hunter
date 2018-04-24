import requests
import pickle

d={}
with open('stockx_images.pkl', 'rb') as f:
	d=pickle.load(f)

for n,v in d.items():
	img = v[0]
	if len(img) == 0:
		continue
	img_data = requests.get(img[-1]).content
	with open('images/' + str(v[1]) + '.jpg', 'wb') as t:
		t.write(img_data)