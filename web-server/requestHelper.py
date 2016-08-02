import re
class RequestHelper:    
    def __init__(self,request,action='None'):
        self.request=request
        self.action=action
        self.param=''
    def is_valid_request(self):
        temp=self.request.splitlines()[0]
        parts=temp.split(' ')
        if parts[0]!='GET' and parts[0]!='POST':
            self.action ='INVALID_REQUEST'
        if parts[1][0]!='/':
            self.action ='INVALID_REQUEST'
        if 'HTTP/' not in parts[2]:
            self.action= 'INVALID_REQUEST' 
        return parts
    def show_full_request(self):
        print(self.request)
    def find_request(self):
        return self.request.splitlines()[0]
    def find_method(self):
        temp=self.request.splitlines()
        method =temp[0].split(' ')
        return method[0]
    def find_param_POST(self):
        lines=self.request.split('\r\n\r\n')
        return lines[1]
    def find_upload_param(self):
        temp=self.request.split('\r\n\r\n')[2].split('----')[0].split('----')[0][:-2]
        return temp
    def find_path_POST(self):
        path=self.request.splitlines()[0].split(' ')[1][1:]
        return path
    def find_path_GET(self):
        path=self.request.splitlines()[0].split(' ')[1][1:]
        if '?' in path:
            result= path.split('?')
            self.param=result[1]
            return result[0]
        else:
            return path
    def find_http(self):
        temp=self.request.splitlines()
        http=temp[0].split(' ')
        return http[2]
    def find_content_type(self):
        temp= self.find_path_GET().split('.')[-1]
        if temp=='png':
            return 'image/png'
        elif temp=='py':
            return 'text/html'
        elif temp=='jpg':
            return 'image/jpg'
        elif temp=='html':
            return 'text/html'
        elif temp=='txt':
            return 'text/plain'
        elif temp=='mov':
            return 'video/quicktime'
        elif temp=='mp4':
            return 'video/quicktime'
        elif temp=='mp3':
            return 'audio/mpeg'
        else:
            return 'text/html'
    def get_script_path(self):
        temp=self.path[1:]
        if '?' in temp:
            return temp.split('?')[0]
        else:
            return temp
        return temp    
    def is_script_file(self):
        temp=self.find_path_GET()
        if 'server_scripts' in temp:
            return True
        else: 
            return False 
    def give_request_info(self):
        p_path=''
        a_action=''
        if self.find_method()=='GET':
            p_path=self.find_path_GET()
        else:
            p_path=self.find_path_POST()
        m_method=self.find_method()
        if self.is_sum()==True:
            a_action="Sum in the name of ODIN"
        elif self.is_script_file()==True:
            if m_method=='GET':
                a_action="run_scripts_ODIN|"+self.param
            elif m_method=='POST':
                a_action="run_scripts_ODIN|"+self.find_param_POST()
        elif self.is_upload()==True:
            a_action='upload_odin|'+self.find_upload_param()
            result[1]=self.find_upload_type()
            result[2]=self.find_upload_file_name()
        self.action=a_action
        result=[]
        result.append(self.find_http())
        result.append(self.find_content_type())
        result.append(p_path)
        result.append(m_method)
        result.append(self.action)
        return result
    def is_upload(self):
        temp=self.find_path_POST()
        if temp=='upload_Odin' and self.find_method()=='POST':
            return True
        else:
            return False
    def is_sum(self):
        temp=self.find_path_GET()
        if ("sum?number1" in temp)and("&number2" in temp)and("&sum-nums=Subscribe" in temp):
            return True
        else:
            return False
    def find_upload_file_name(self):
        temp=self.request
        first=temp.index('Content-Disposition:')+20
        second=temp.index('filename',first)+9
        third=temp.index('\r\n',second)
        return temp[second:third][1:-1]
    def find_upload_type(self):
        temp=self.request
        first=temp.index('Content-Type:')+13
        second=temp.index('Content-Type',first)+14
        third=temp.index('\r\n',second)
        return temp[second:third]
if __name__=='__main__':
    s="""POST /upload_Odin HTTP/1.1\r\nHost: localhost:8888\r\nUser-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:47.0) Gecko/20100101 Firefox/47.0\r\nAccept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\nAccept-Language: en-US,en;q=0.5\r\nAccept-Encoding: gzip, deflate\r\nReferer: http://localhost:8888/index.html\r\nCookie: __utma=111872281.1485430477.1469690059.1469690059.1469690059.1; __utmz=111872281.1469690059.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)\r\nConnection: keep-alive\r\nContent-Type: multipart/form-data; boundary=---------------------------116247788114713055421338783861\r\nContent-Length: 330\r\n\r\n-----------------------------116247788114713055421338783861\r\nContent-Disposition: form-data; name="myfile"; filename="file.txt"\r\nContent-Type: text/plain\r\n\r\nthis file contains test information for web server \n\n\n++++++++++++++++++++++++++++++++++++++++++++++++++++++\r\n-----------------------------116247788114713055421338783861--\r\n"""
    helper=RequestHelper(s)
    #helper.show_full_request()
    #print helper.give_request_info()
    #print helper.find_path()
    #print helper.is_sum()
    #print helper.find_path_POST()
    #print helper.is_script_file()
    #print helper.find_param_POST()
    #print helper.is_upload()
    print repr(helper.find_upload_param())
    #helper.find_upload_type()
    #print helper.find_upload_file_name()
