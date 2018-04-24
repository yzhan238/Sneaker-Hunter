import cv2
import sys
import numpy as np
from sklearn.cluster import KMeans
import pickle
from tqdm import tqdm
from scipy import stats

def compute_hist(img):
	hist = cv2.calcHist([img], [0, 1, 2], None, [6,6,6], [0,256, 0, 256, 0, 256])
	return hist

ll = [str(i) + '.jpg' for i in range(982)]
lll = []
for k in tqdm(ll):
	imgg = cv2.imread('shape/' + k, cv2.IMREAD_GRAYSCALE)
	lll.append(compute_hist(imgg))

with open('hist.pkl', 'wb') as f:
	pickle.dump(lll, f)