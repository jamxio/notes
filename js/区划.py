#!python
# -*- coding: utf-8 -*-
import os
#os.chdir('D:/360安全浏览器下载')
lines = open('./区县级行政区划清单V35.csv').readlines()
json = dict()
for line in lines[1:]:
	st = line.strip('\n')
	starr = st.split(',')
	json[starr[1][0:2]] = json.get(starr[1][0:2],dict())
	json[starr[1][0:2]]['pro'] = starr[0]
	json[starr[1][0:2]]['children'] = json[starr[1][0:2]].get('children',dict())
	json[starr[1][0:2]]['children'][starr[3][2:4]] = json[starr[1][0:2]]['children'].get(starr[3][2:4],dict())
	json[starr[1][0:2]]['children'][starr[3][2:4]]['city'] = starr[2]
	json[starr[1][0:2]]['children'][starr[3][2:4]]['children'] = json[starr[1][0:2]]['children'][starr[3][2:4]].get('children',dict())
	json[starr[1][0:2]]['children'][starr[3][2:4]]['children'][starr[5][-2:]] = {'county':starr[4]}
import json as jsonlib
open('区划.json','w',encoding='utf-8').write(jsonlib.dumps(json))
print(len(json))
