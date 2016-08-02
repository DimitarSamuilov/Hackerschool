import os.path
import subprocess
import os.path
class ResponseHelper:
    def __init__(self,http='HTTP/1.0',contentType='text/html',path='',method='GET',action='None'):
        self.http=http
        
        self.contentType=contentType
        self.path=path
        self.response=''
        self.method=method
        self.action=action
        if action=='Sum in the name of ODIN':
            self.responseCode='200 OK'
        elif 'upload_odin' in self.action:
            self.responseCode='200 OK'
        elif action=='None':
            self.responseCode='200 OK'
        elif 'run_scripts_ODIN|' in self.action:
            self.responseCode='200 OK'
        elif 'upload_odin' in self.action:
            self.responseCode='200 OK'
        else:
            self.responseCode='404 NOT FOUND'
        
    def script_type(self):
        if self.path.split('.')[-1]=='py':
            return 'python'
        else:
            return 'file_error'
    def read_file(self):
        try:
            myfile=open (self.path,'rb')
        except Exception , e:
            self.error='file__error'
            print e
        else:
            result=myfile.read()
            myfile.close()
            return result
    def run_script(self,type):
        if type!='file_error':
            try:
                #args=self.prepart_script_args()
                components=[type,self.path,self.action.split('|')[1]]
                return subprocess.check_output(components)
            except Exception ,e :
                print e
                return 'Error occured while running script'+self.path
        else:
            return 'Servercannot read'+self.path
    def createResponse_GET(self):
        if self.action=='INVALID_REQUEST':
            info= self.getFileErrorResponse('INVALID_REQUEST')
        elif self.method!='GET' and self.method!='POST':
            info= self.getFileErrorResponse('NOT_GET')
        elif os.path.isfile(self.path)==False and self.action!='Sum in the name of ODIN':
            info= self.getFileErrorResponse('file__error')
            self.responseCode='404 NOT FOUND'
        elif self.action=='Sum in the name of ODIN|':
            info=self.sum_function()
        elif self.action.split('|')[0]=='run_scripts_ODIN':
            info=self.run_script(self.script_type())
        elif self.action.split('|')[0]=='upload_odin' :
            self.upload_file_form()
            info='file uploading'
            self.contentType='text/html'
        else:
            info=self.read_file()
        response="""%s %s
Content-Type: %s
Content-length: %s\n\n%s"""%(self.http,self.responseCode,self.contentType,len(info),info)
        return response
    def upload_file_form(self):
        directory='test/'+self.path
        try:
            myfile=open(directory,'wb+')
        except:
            self.error='file__error'
        else:
            toFile=self.get_upload_param()
            myfile.write(toFile)
            myfile.close()
    def get_upload_param(self):
        temp=self.action
        return temp[12:]
    def sum_function(self):
        info=self.path
        temp1_num1=info.index('=')
        temp2_num1=info.index('&')
        temp1_num2=info.index('=',temp2_num1)
        temp2_num2=info.index('&',temp1_num2)
        num1=info[temp1_num1+1:temp2_num1]
        num2=info[temp1_num2+1:temp2_num2]
        return str(int(num1)+int(num2))
        
    def getFileErrorResponse(self,message):
        res='error'
        if message=='INVALID_REQUEST':
            res='Invalid request erro'
        elif message=='file__error':
            res='No such file'
        elif message=='NOT_GET':
            res='Only GET and POST methods supported'
        else:
            res='error'
        info="""
         <!DOCTYPE html>
<html>
<head>
<title>File Error</title>
</head>
<body>
<p>%s</p>
</body>
</html> 
        """%(res)
        return info
        
if __name__=='__main__':
    test=ResponseHelper('HTTP/1.0', 'text/html','server_scripts/test.py','GET','run_scripts_ODIN|&num1=1&num2=3&sdsadasd=12&sometext')
    #print(test.createResponse())
    print test.prepart_script_args()
