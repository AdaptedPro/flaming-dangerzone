from classes.webdata import webdata

def main():
    get_data()
    
def get_data():
    w = webdata()
    w.json_url = 'http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/all_hour.geojson'
    w.get_json_data()  

if __name__ == '__main__':
     main()    