
d = {'January':'01', 
	 'February':'02',  
	 'March':'03',  
	 'April':'04',  
	 'May':'05',  
	 'June':'06',  
	 'July':'07',  
	 'August':'08',  
	 'September':'09',  
	 'October':'10',  
	 'November':'11',  
	 'December':'12', }

def getData(file):
	res = []

	dic = {}

	with open(file, 'r') as f:
		sid = f.readline().strip()
		p = 0
		count = 1
		for line in f:
			line = line.strip().split('\t')
			tmp = line[0].split(', ')
			ttmp = tmp[1].split(' ')
			rres = []
			rres.append(sid)
			rres.append(tmp[2]+'-'+d[ttmp[0]]+ ('-0' if len(ttmp[1]) == 1 else '-') + ttmp[1])
			tmp = line[1].split(' ')
			ttmp = tmp[0].split(':')
			rres.append(get_hour(ttmp[0], tmp[1]) + ':' + ttmp[1] + ':00')
			rres.append(clear_size(line[2]))
			rres.append(line[3][1:].replace(',',''))
			if tuple(rres[:4]) not in dic:
				dic[tuple(rres[:4])] = (int(rres[-1]), 1)
			else:
				tmp = dic[tuple(rres[:4])]
				dic[tuple(rres[:4])] = (int(rres[-1]) + tmp[0], tmp[1] + 1)

	for k, v in dic.items():
		res.append(k + (str(int(v[0] / v[1])),))

	return res

def clear_size(s):
	if s[-1].isalpha():
		return s[:-1]
	else:
		return s

def get_hour(s1, s2):
	n = int(s1)
	if n == 12:
		if s2 == 'PM': 
			return '12'
		else:
			return '00'
	else:
		if s2 == 'PM':
			return str(n+12)
		elif n < 10:
			return '0' + str(n)
		else:
			return str(n)