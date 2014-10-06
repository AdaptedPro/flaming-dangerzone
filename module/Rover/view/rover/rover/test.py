#!/usr/bin/env python

from datetime import datetime
from datetime import time

welcome_message = ""

def main():
    global welcome_message
    global request_heading
    welcome_message = get_welcome_heading()
    
def get_welcome_heading():
    name         = "Joe"
    today        = datetime.now()
    month        = today.month
    day          = today.day
    t            = datetime.now().strftime("%A, %B %d, %Y - %I:%M %p")
    
    seasonal_msg = ""    
    if month == 10:
        seasonal_msg = "Get your costume ready for Halloween!" if day < 31 else  "Trick or treat!"
    elif month == 11:
        seasonal_msg = "Get your turkey and ham ready for Thanksgiving!"
    elif month == 12:
        if day < 25:
            seasonal_msg = "Get ready for Merry Christmas" 
        elif day == 25: 
            seasonal_msg = "Merry Christmas!" 
        elif day > 25:
            seasonal_msg = "Have a Happy New Year!"       
        
    welcome_heading = "Hello " + name + "! <br>" +  t  + "<br>" + seasonal_msg
    return "<p>" + welcome_heading + "</p>"    
        
main()
print welcome_message     