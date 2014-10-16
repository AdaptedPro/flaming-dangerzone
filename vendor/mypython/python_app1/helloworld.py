def fileToStr(fileName): # NEW
    """Return a string containing the contents of the named file."""
    fin = open(fileName); 
    contents = fin.read();  
    fin.close() 
    return contents

def main():
    person = input('Enter a name: ')  
    contents = fileToStr('pageTemplate.html').format(**locals())   # NEW
    browseLocal(contents) 
    
main()    