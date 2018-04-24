from bs4 import BeautifulSoup
from bs4.element import Comment
import urllib.request
import re
import requests
import concurrent.futures
import pickle
import tweepy
from tweepy import OAuthHandler
import json
import operator
import emoji

# functions used to crawl visible texts from webs
def tag_visible(element):
    if element.parent.name in ['style', 'script', 'head', 'title', 'meta', '[document]']:
        return False
    if isinstance(element, Comment):
        return False
    return True


def text_from_html(body):
    soup = BeautifulSoup(body, 'html.parser')
    texts = soup.findAll(text=True)
    visible_texts = filter(tag_visible, texts)  
    return u" ".join(t.strip() for t in visible_texts)


def text_has_emoji(text):
    for character in text:
        if character in emoji.UNICODE_EMOJI:
            return True
    return False


# connect twitter
consumer_key = 'CONSUMER_KEY'
consumer_secret = 'CONSUMER_KEY'
access_token = 'ACCESS_TOKEN'
access_secret = 'ACCESS_SECRET'
 
auth = OAuthHandler(consumer_key, consumer_secret)
auth.set_access_token(access_token, access_secret)
 
api = tweepy.API(auth, wait_on_rate_limit=True)

sneakers = []
retail_prices = []
with open('sneakers.json', 'r') as f:
	data = json.load(f)
	for sneaker in data:
		sneakers.append(sneaker['sid'])
		retail_prices.append(sneaker['retailPrice'])


for index in range(0,1000):

	# read in the sneaker name and retail price here
	sid = sneakers[index]
	sneaker_name = sid.lower()
	retail_price = retail_prices[index]
	sneaker_name_split = sneaker_name.split()


	# scrape tweets
	with open('tweets.json', 'w') as f:
		results = []
		last = None
		for i in range(10):
			if last is None:
				res = api.search(sneaker_name, lang='en', count=100)
			else:
				res = api.search(sneaker_name, lang='en', count=100, max_id=last-1)
			if len(res) == 0: break
			last = res[-1]._json['id']
			results.extend(res)

		s = set()
		for r in results:
			s.add(r._json['id'])
			f.write(json.dumps(r._json))
			f.write('\n')


	# find urls in tweets 
	tweets = []
	for line in open("tweets.json", 'r'):
		tweets.append(json.loads(line))

	urls = []
	#users = []

	for tweet in tweets:
		if len(tweet['entities']['urls']) != 0:
			urls.append(tweet['entities']['urls'][0]['expanded_url'])
			#users.append(tweet['user']['name'])

	#urls_users = list(set([(i,j) for i,j in zip(urls, users)]))

	urls = list(set(urls))

	print("number of tweets: {}".format(len(tweets)))
	print("number of urls: {}".format(len(urls)))
	#print("number of urls_users: {}".format(len(urls_users)))

	if len(urls) > 20:
		urls = urls[:20]


	# find the price of the sneaker in the given url 
	def work(url, t):
		# print('processing ' + url)	
		html = requests.get(url, timeout=3).content
		html_text = text_from_html(html).lower()

		# ensure the web is relevant with the sneaker
		if all(part in html_text for part in sneaker_name_split):
			# filter out sold-out and listing-end items on ebay
			if 'we have selected another similar item below.' not in html_text:
				last_index = max([html_text.find(word) for word in sneaker_name_split])
				html_text = html_text[last_index:]
				# get the price
				if re.search('\$[ ]*[1-9][0-9]*,?[0-9]*\.?[0-9]*', html_text):
					ret = re.search('\$[ ]*[1-9][0-9]*,?[0-9]*\.?[0-9]*', html_text).group()
					ret = ret.replace(',', '')
					ret = round(float(re.search("\d+\.?[\d]*", ret).group()),2)
					# filter out release information
					if (ret != retail_price) or ('release date' not in html_text): 
						return ret

		return ''



	ret = {}

	# parallel programing
	with concurrent.futures.ThreadPoolExecutor(max_workers=8) as executor:
		# Start the load operations and mark each future with its URL
		future_to_url = {executor.submit(work, url, 3): url for url in urls}
		for future in concurrent.futures.as_completed(future_to_url):
			url = future_to_url[future]
			try:
				price = future.result()
			except Exception as exc:
				print('%r generated an exception: %s' % (url, exc))
			else:
				if price != '':
					ret[url] = price

	sorted_ret = sorted(ret.items(), key=operator.itemgetter(1))
	sorted_ret = [[i[0],i[1]] for i in sorted_ret]

	#with open('prices.pkl', 'wb') as fout:
		#pickle.dump(sorted_ret, fout)


	for i in sorted_ret:
		for tweet in tweets:
			if len(tweet['entities']['urls']) != 0:
				if i[0] == tweet['entities']['urls'][0]['expanded_url']:
					if text_has_emoji(tweet['user']['name']):
						i.append('emoji')
					else:
						i.append(tweet['user']['name'])
					i.append(tweet['user']['followers_count'])


	with open('prices.txt', 'a') as file:
		for i in sorted_ret:
			file.write(sid + "\t{}\t{}\t${}\t{}\n".format(i[2],i[3],str(i[1]), i[0]))


	print("done"+str(index))















