import cv2
import sys
import numpy as np
from sklearn.cluster import KMeans
import pickle
from tqdm import tqdm

ll = [str(i) + '.jpg' for i in range(982)]
sift = cv2.xfeatures2d.SIFT_create()
sf = []
for k in tqdm(ll):
	img = cv2.resize(cv2.imread('resize/' + k, cv2.IMREAD_GRAYSCALE), (640, 640))
	kp, d = sift.detectAndCompute(img, None)
	sf.append(d)

with open('sift.pkl', 'wb') as f:
	pickle.dump(sf, f)