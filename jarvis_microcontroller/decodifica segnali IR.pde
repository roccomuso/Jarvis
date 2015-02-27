// Altre referenze e approfondimenti su: http://www.pjrc.com/teensy/td_libs_IRremote.html

#include <IRremote.h> // la libreria usata, va installata nell'IDE di arduino

const int RECV_PIN = 7; //pin cui e' connesso il ricevitore IR

IRrecv irrecv(RECV_PIN);

decode_results results;

void setup()
{
  Serial.begin(9600);
  irrecv.enableIRIn(); // Start the receiver
  irrecv.blink13(true); //pin 13 lampeggia ad ogni segnale ricevuto
  
}

void loop() {
  if (irrecv.decode(&results)) { //se abbiamo ricevuto un segnale IR
    //vari tipi di protocollo IR:
    if (results.decode_type == NEC) {
      Serial.print("NEC: ");
    } else if (results.decode_type == SONY) {
      Serial.print("SONY: ");
    } else if (results.decode_type == RC5) {
      Serial.print("RC5: ");
    } else if (results.decode_type == RC6) {
      Serial.print("RC6: ");
    } else if (results.decode_type == UNKNOWN) {
      Serial.print("UNKNOWN: ");
    }
    Serial.println(results.value, HEX); //il valore in esadecimale, quando lo inviamo bisogna mettere sempre il 0x davanti. ex: irsend.sendNEC(0xF7C03F,32); [vedi file: invio segnali IR.pde]
    Serial.println(results.value); //il valore in decimale
    
	//se riceviamo il valore esadecimale FFFFFF sta a indicare la pressione continua del tasto.
    //il valore decimale del segnale puo' essere usato per fare un controllo sul comando appena ricevuto e reagire di conseguenza, esempio:
	if (results.value == 16236607) digitalWrite(12, HIGH);
    else if (results.value == 16203967) digitalWrite(12, LOW);
	
    irrecv.resume(); // Receive the next value
  }
}