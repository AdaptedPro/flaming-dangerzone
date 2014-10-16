from datetime import datetime
from datetime import time

welcome_message = ""
request_heading = ""

def main():
    global welcome_message
    global request_heading
    welcome_message = get_welcome_heading()
    request_heading = get_requested_results_heading('Oct',3,2014)   
    
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
        
    welcome_heading = "Hello " + name + "! \n" +  t  + "\n" + seasonal_msg
    return welcome_heading
    
def get_requested_results_heading(req_month,req_day,req_year):    
    req_heading = "Results for " + req_month + " " + str(req_day) + ", " + str(req_year)
    return req_heading

def clear_requested_results_heading():
    global request_heading
    request_heading = ""
    
def get_total_points(*points):
    output = 0;
    for p in points:
        output = output + p
    return "You scored " + str(output) + " total points"

def get_comparison():    
    output = ""
    x,y = 1000,100
    if(x < y):
        output = "x is less than y"
    elif(x > y):
        output = "y is less than x"
    else: 
        output = "all things equal"
    return output

def get_all():
    #Within rang
    for x in range(5,10):
        #if (x==7):break
        #if (x%2):continue
        print x
    
    #Go through array    
    days = ["Mon","Tue","Wed","Thu","Fri","Sat","Sun"]    
#     for d in days:
#         print d
    
    for i,d in enumerate(days):
        print i,d    
        
    
#Start application    
if __name__ == "__main__":
     main()    

#
print welcome_message
# print get_total_points(15,16,20,30)
# print get_comparison()
# print get_all()