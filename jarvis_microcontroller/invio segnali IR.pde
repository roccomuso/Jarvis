// Documentazione aggiuntiva e altre info: http://www.righto.com/2009/08/multi-protocol-infrared-remote-library.html
// Altra documentazione: http://www.pjrc.com/teensy/td_libs_IRremote.html

#include <IRremote.h> // La libreria usata per la comunicazione infrarossa

IRsend irsend; //di default la libreria utilizza per l'invio il pin 3. Quindi il led infrarosso emettitore va collegato con il polo positivo (stanghetta più' lunga) in serie con una resistenza da 2.2 kOhm che va al pin 3.

void setup()
{
Serial.begin(9600);
}


void loop() 
{

        if (Serial.available() > 0) {
                // read the incoming byte:
                int incomingByte = Serial.read();

                // say what you got:
                Serial.print("I received: ");
                Serial.println(incomingByte, DEC);
				
		    if (incomingByte == 103){ //codice ascii per il carattere "g"
			
			    // NB. in invio diversi protocolli richiedono che un segnale venga inviato 3 volte prima di essere interpretato dal ricevitore.
			    for (int i = 0; i < 3; i++) 
				{
				//primo parametro del metodo e' il codice del segnale, il secondo il numero di bits, variano a seconda del protocollo.
				irsend.sendNEC(0xF7C03F,32); // metodo sendNEC, (ma esistono anche altri metodi sendSONY() etc. a seconda del protocollo usato dall'apparecchiatura IR)
				delay(100);
				}
			
			}else if (incomingByte == 115){ //carattere "s"
			
			    for (int i = 0; i < 3; i++) 
				{
				irsend.sendNEC(0xF740BF,32); 
				delay(100);
				}
			
			}
		
        }

}