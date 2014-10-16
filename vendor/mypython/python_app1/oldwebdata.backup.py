#
# This Model is used to get web data as xml or json
#

import urllib2
import json

class oldwebdata():
    json_url = ''
    xml_url  = ''
    web_url  = ''
            
    def get_json_data(self):
        web_url  = urllib2.urlopen(self.json_url)       
        if (web_url.getcode() == 200):
            data = web_url.read()
            self.printJSONResults(data)
        else:
            print 'Server error, can not receive results ' + web_url.getcode()
        
    def get_xml_data(self):
        print 'xml-data';     

    def get_web_page(self):
        web_url  = urllib2.urlopen(self.web_url)
        #web_data = web_url.read()
        print web_url 
        
    def printJSONResults(self,data):
        theJSON = json.loads(data)
        if 'title' in theJSON['metadata']:
            print theJSON['metadata']['title']
        count = theJSON['metadata']['count'];
        s = 's' if (count > 1) else ''
        print str(count) + ' event'+ s + ' recorded'
        #    
        for i in theJSON['features']:
            print i['properties']['place']
        #
#         for i in theJSON['features']:
#             if i['properties']['mag'] >= 4.0:
#                 print "%2.1f" % i['properties']['mag'], i['properties']['place'] 
                
        for i in theJSON['features']:
            feltReports = i['properties']['felt']
            if (feltReports != None) & (feltReports > 0):
                print "%2.1f" % i['properties']['mag'], i['properties']['place'], " reported" + str(feltReports) + " times"                  
                