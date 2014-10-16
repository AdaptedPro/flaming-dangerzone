# Person Class 

class person():
    def method1(self):
        print "person method1"
        
    def method2(self, string):
        print 'person method2:' + string

class user(person):
    def method2(self):
        print 'new method 2 for user'
        
    def method1(self):
        person.method1(self);
        print "hello world method1"
        
def main():
    p = person()
    p.method1()
    p.method2('Sample text')    
    u = user()
    u.method1()
    u.method2()
    
if __name__ == '__main__':
    main()    