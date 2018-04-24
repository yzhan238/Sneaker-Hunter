import scrapy 
import json

class SneakersSpider(scrapy.Spider):
	name = "sneakers"
	api_url = 'https://stockx.com/api/browse?sort=most-active&time=1523581693430&order=DESC&productCategory=sneakers&page={}'
	start_urls = [api_url.format(1)]

	def parse(self, response):
		data = json.loads(response.text)
		for sneaker in data['Products']:
			yield{
				'sid': sneaker['title'],
				'releaseDate': sneaker['releaseDate'],
				'sales': sneaker['market']['deadstockSold'],
				'retailPrice': sneaker['retailPrice'],
				'brand': sneaker['brand'],
				'category': sneaker['category'],
				'average_resell_price': sneaker['market']['averageDeadstockPrice'],
				'number_of_asks': sneaker['market']['numberOfAsks'],
				'number_of_bids': sneaker['market']['numberOfBids'],
				'urlKey': sneaker['urlKey']
			}
		if data['Pagination']['page'] < data['Pagination']['lastPage']:
			next_page = data['Pagination']['page'] + 1
			yield scrapy.Request(url = self.api_url.format(next_page), callback = self.parse)