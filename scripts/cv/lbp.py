import cv2
import sys
import numpy as np
from sklearn.cluster import KMeans
import pickle
from tqdm import tqdm
from skimage.feature import local_binary_pattern
from scipy.spatial.distance import euclidean as l2

def lbp(image):
	image = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
	lbp = local_binary_pattern(image, 16, 2)
	n_bins = int(lbp.max()+1)
	return np.histogram(lbp, normed=True, bins=n_bins, range=(0, n_bins))[0]

ll = [str(i) + '.jpg' for i in range(982)]
sf = []
for k in tqdm(ll):
	img = cv2.resize(cv2.imread('resize/' + k), (640, 640))
	img = img[240:400, 240:400]
	sf.append(lbp(img))

print(len(sf))

with open('lbp.pkl', 'wb') as f:
	pickle.dump(sf, f)