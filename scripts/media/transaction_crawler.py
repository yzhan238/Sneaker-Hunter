from selenium import webdriver
import time
import json

with open("sneakers.json", 'r') as f:
	data = json.load(f)

option = webdriver.ChromeOptions()
option.add_argument("--incognito")

for i in range(0, len(data)):
	#if '"' not in data[i]['sid']:
		driver = webdriver.Chrome(executable_path='/Users/xiaomazi/Downloads/chromedriver', chrome_options=option)
		driver.get("https://stockx.com/" + data[i]['urlKey'])
		time.sleep(1)
		
		# load more 
		"""if i > 39:
			for k in range(0, int(i/40)):
				driver.find_element_by_xpath("//div[@class='browse-load-more']").click()
				time.sleep(2)

		#name_escape = data[i]['sid'].replace('"', '\"')
		quote_name = '"'+ data[i]['sid'] + '"'
		driver.find_element_by_xpath('//a[@id={}]'.format(quote_name)).click()
		time.sleep(3)
		"""
		driver.find_element_by_xpath("//div[@id='market-summary']//div[@class='last-sale-block']//a[@class='all']").click()
		time.sleep(1)

		elem = driver.find_element_by_xpath("//*")
		source_code = elem.get_attribute("outerHTML")

		idx = source_code.find('Sale Price</th></tr></thead><tbody><tr><td>')
		idx += len('Sale Price</th></tr></thead><tbody><tr><td>')
		res = []
		while True:
			temp = source_code.find('</td>', idx + 1)
			res.append(source_code[idx : temp])
			idx = source_code.find('<td>', temp)
			if idx < 0:
				break
			idx += 4

		driver.close()

		with open("{}.txt".format(i), "w") as file:
			file.write(data[i]['sid'] + "\n")
			for j in range(0, int(len(res)/4)):
				file.write(res[4*j] + "\t" + res[4*j+1] + "\t" + res[4*j+2] + "\t" + res[4*j+3] + "\n")

