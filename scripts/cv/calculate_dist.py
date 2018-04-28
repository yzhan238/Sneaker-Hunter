import cv2
import sys
import numpy as np
from sklearn.cluster import KMeans
import pickle
from tqdm import tqdm
import numpy.linalg as npla
from scipy.spatial.distance import euclidean as l2

def load_pickle(f):
	b = None
	with open(f, 'rb') as bf:
		b = pickle.load(bf)
	return b

def to_gray(img):
	return cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)

def binary_map(img):
	lookUp = np.empty(256)
	lookUp.fill(255)
	lookUp[-10:] = 0
	return cv2.LUT(img, lookUp)

def filter_1(img):
	kernel = np.ones((5,5),np.float32)/25
	return cv2.filter2D(img,-1,kernel)

def filter_2(img):
    return cv2.GaussianBlur(img,(5,5),0)

def filter_3(img):
	return cv2.medianBlur(img,5)

def momnt(img):
	return cv2.moments(img)

def hu(img):
	return cv2.HuMoments(img).flatten()

def contour(img):
	gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
	ret, binary = cv2.threshold(gray,127,255,cv2.THRESH_BINARY)  
	_, contours, hierarchy = cv2.findContours(binary,cv2.RETR_TREE,cv2.CHAIN_APPROX_SIMPLE)  
	cv2.drawContours(img,contours,-1,(0,0,255),3)  
	cv2.imshow("img", img)
	cv2.waitKey(-1)

def compute_hist(img):
	hist = cv2.calcHist([img], [0, 1, 2], None, [6,6,6], [0,256, 0, 256, 0, 256])
	return hist

def compare_hist(h1, h2):
	return cv2.compareHist(h1, h2, cv2.HISTCMP_BHATTACHARYYA)

def sift_similarity(d1, d2):
	bf = cv2.BFMatcher()
	match = bf.knnMatch(d1, d2, k=2)
	sim = 0
	for i,j in match:
		if i.distance < 0.5 * j.distance:
			sim += 1
	if sim == len(match):
		return 1.
	elif sim > 1:
		return 1. - 1./sim
	elif sim == 1:
		return 0.1
	else:
		return 0.

import numpy as np

def retrieve(pid, mat, k=50):
	sift, lbp, color = mat
	sifts = np.argpartition(sift[pid], k)
	lbps = np.argpartition(lbp[pid], k)
	colors = np.argpartition(color[pid], k)
	sifts = [x for x in enumerate(sifts)]
	lbps = [x for x in enumerate(lbps)]
	colors = [x for x in enumerate(colors)]

hist = None
with open('hist.pkl', 'rb') as f:
	hist = pickle.load(f)

sf = None
with open('sift.pkl', 'rb') as f:
	sf = pickle.load(f)

lbp = None
with open('lbp.pkl', 'rb') as f:
	lbp = pickle.load(f)

h = np.zeros((dim, dim))
s = np.zeros((dim, dim))
llbp = np.zeros((dim, dim))
for i in tqdm(range(dim)):
	h[i][i] = 0
	s[i][i] = 1
	llbp[i][i] = 0
	for j in range(i+1, dim):
		h[i][j] = compare_hist(hist[i], hist[j])
		h[j][i] = h[i][j]
		s[i][j] = sift_similarity(sf[i], sf[j])
		s[j][i] = s[i][j]
		llbp[i][j] = l2(lbp[i], lbp[j])
		llbp[j][i] = llbp[i][j]

with open('hist_dis.pkl', 'wb') as f:
	pickle.dump(h, f)
with open('sift_sim.pkl', 'wb') as f:
	pickle.dump(s, f)
with open('lbp_dis.pkl', 'wb') as f:
	pickle.dump(llbp, f)

# h = None
# with open('hist_dis.pkl', 'rb') as f:
# 	h = pickle.load(f)

# s = None
# with open('sift_sim.pkl', 'rb') as f:
# 	s = pickle.load(f)

# llbp = None
# with open('lbp_dis.pkl', 'rb') as f:
# 	llbp = pickle.load(f)

dic ={}
with open('stockx_images.pkl', 'rb') as f:
	dic=pickle.load(f)

lookup = {}
for k,v in dic.items():
	lookup[v[1]] = k

dim = 982
result = {}
for k in range(dim):
	hh = sorted([i for i in range(dim) if i != k], key=lambda x:h[k][x])
	ss = sorted([i for i in range(dim) if i != k], key=lambda x:s[k][x], reverse = True)
	ll = sorted([i for i in range(dim) if i != k], key=lambda x:llbp[k][x])
	r = None
	idx = None
	for i in range(1,180):
		r = set(hh[:i*5]).intersection(set(ll[:i*10])).intersection(set(ss[:i*10]))
		if len(r) > 5:
			idx = i
			break
	mrr = {rr:0. for rr in r}
	for i in range(idx*10):
		if hh[i] in mrr:
			mrr[hh[i]] += 1. / (i + 1)
		if ss[i] in mrr:
			mrr[ss[i]] += 1. / (i + 1)
		if ll[i] in mrr:
			mrr[ll[i]] += 1. / (i + 1)
	mrrr = sorted([k for k,v in mrr.items()], key = lambda x: mrr[x], reverse = True)
	result[lookup[k]] = [(lookup[mrrr[i]], i) for i in range(len(mrrr))]
with open('recom_rank.pkl', 'wb') as f:
	pickle.dump(result, f)