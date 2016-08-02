import socket ,time
from responseHelper import ResponseHelper
from requestHelper import RequestHelper
def recv_timeout(client_connection,timeout=1):
    client_connection.setblocking(0)
    total_data=[]
    data=''
    begin=time.time()
    while 1:
        if total_data and time.time()-begin>timeout:
            break
        elif time.time()-begin>timeout*2:
            break
        try:
            data=client_connection.recv(8191)
            if data:
                total_data.append(data)
                begin=time.time()
            else:
                time.sleep(0.1)
        except:
            pass
    return ''.join(total_data)
def recv_marker(client_connection):
    end_marker='\r\n\r\n'
    chunk=''
    fragments=[]
    while True:
        chunk=client_connection.recv(1024)
        if end_marker in chunk:
            fragments.append(chunk[:chunk.find(end_marker)])
            break
        fragments.append(chunk)
        if len(fragments)>1:
            last_pair=fragments[-2]+fragments[-1]
            if end_marker in last_pair:
                fragments[-2]=last_pair[:last_pair.find(end_marker)]
                fragments.pop()
                break
    request="".join(fragments)
    return request
HOST,PORT='',8888
listen_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
listen_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
listen_socket.bind((HOST, PORT))
listen_socket.listen(1)
print 'Serving HTTP on port %s ...' % PORT
while True:
    client_connection, client_address = listen_socket.accept()
    request=recv_timeout(client_connection)
    request_helper=RequestHelper(request)
    print 
    print (request)
    request_data=request_helper.give_request_info()
    response_helper=ResponseHelper('HTTP/1.0',request_data[1],request_data[2],request_data[3],request_data[4])
    client_connection.sendall(response_helper.createResponse_GET())
    client_connection.close()
