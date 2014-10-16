# Download PIP - http://pip.readthedocs.org/en/latest/installing.html
# Tutorial taken from - http://docs.python-guide.org/en/latest/scenarios/scrape/ 
# Necessary lxml for windows - https://pypi.python.org/pypi/lxml/3.3.3 

from classes.webdata import webdata
from lxml import html
import requests

web_page_data = ""

def main():
    global web_page_data
    w = webdata()
    w.web_url = 'http://www.tiobe.com/index.php/content/paperinfo/tpci/index.html'
    web_page_data = w.get_web_data()
    scrape_web_data()
    
def scrape_web_data():
    global web_page_data
    result_tree = html.fromstring(web_page_data)
    site_heading    = result_tree.xpath('//title/text()')
    print 'Test' #site_heading
       
    
if __name__ == '__main__':
      main()       