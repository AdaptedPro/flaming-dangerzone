import urllib2
import json

class webdata():
    
    web_url  = ''  

    def get_web_data(self):
        web_url  = urllib2.urlopen(self.web_url)
        web_data = web_url.read()
        return web_data     
                