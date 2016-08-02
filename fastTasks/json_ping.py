import subprocess
import sys 
import json
if len(sys.argv)!=2:
    print 'invalid arguments'
else:
    print sys.argv
    
ip=sys.argv[1].split(':')
getInfo=subprocess.check_output(['ping',ip[1],'-c','5'])
print ('from python please')
temp=getInfo
print 
loss=getInfo[temp.index('received,')+9:temp.index(', time')]
d={}
temp={}
temp["{name}"]=ip[0]
temp["{IPADDRES}"]=ip[1]
temp["{VALUE}"]=loss
d['data']=temp
printer=json.dumps(d)
print printer
myFile=open("ping.txt","a")
myFile.write(printer)
