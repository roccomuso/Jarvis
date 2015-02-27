from xml.dom.minidom import parseString #import easy to use xml parser called minidom

# preleviamo alcuni settaggi base dal file configurazione.xml

file = open(r'C:\xampp\htdocs\JARVIS\jarvis_pc\configurazione.xml','r') #open the xml file for reading | la r di fronte alla stringa significa di usare una stringa "raw"
data = file.read() #convert to string
file.close() #close file because we dont need it anymore
dom = parseString(data) #parse the xml you got from the file
