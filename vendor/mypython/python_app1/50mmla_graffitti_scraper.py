# Download PIP - http://pip.readthedocs.org/en/latest/installing.html
# Tutorial taken from - http://docs.python-guide.org/en/latest/scenarios/scrape/ 
# Necessary lxml for windows - https://pypi.python.org/pypi/lxml/3.3.3 

from classes.webdata import webdata
from lxml import html
import requests

la_taggers = "";
la_taggers_page = ""

def main():
    page = requests.get('http://www.50mmlosangeles.com/artist.php?artistId=0&pgnum=3')
    result_tree     = html.fromstring(page.text)
    tag_thumb_url   = result_tree.xpath('//div[@class="title"]/table/tr/td/a/img/@src')
    print "Thumbnails: " , tag_thumb_url
       
#Get the names of each tagger       
def mmla_graffitti_scraper():
    global la_taggers
    global la_taggers_page
    
    page = requests.get('http://www.50mmlosangeles.com/gallery.php')
    result_tree     = html.fromstring(page.text)
    la_taggers      = result_tree.xpath('//div/a[@class="galleryLink"]/text()')
    la_taggers_page = result_tree.xpath('//div/a[@class="galleryLink"]/@href')
    
    if (len(la_taggers) == len(la_taggers_page)):
        get_thumbnails()  

def get_thumbnails():
    global la_taggers_page
    for obj in len(la_taggers_page):
        page = requests.get('http://www.50mmlosangeles.com/',obj)
        result_tree     = html.fromstring(page.text)
        tag_thumb_url   = result_tree.xpath('//div[@class="title"]/table/tr/td/a/img/@src')

        
def make_thumbnail_directory(dirname):
#     if not os.path.exists(directory):
#         os.makedirs(directory)
    try:
        fp = open(dirname)
    except IOError as e:
            if e.errno == errno.EACCES:
                return "Can not create folder: ", dirname
            # Not a permission error.
            raise
    else:
        with fp:
            return fp.read()    
            

make_thumbnail_directory('testdir')

#For each tagger with a page get thumb nails

#mmla_graffitti_scraper()    
# if __name__ == '__main__':
#       main()       