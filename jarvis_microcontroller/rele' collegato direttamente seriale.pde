
int val;
int pin = 8;

void setup()
{
pinMode(8, OUTPUT);
Serial.begin(9600);

}

void loop()
{
if (Serial.available())
{
val = Serial.read();
Serial.println(val);
if (val == 110) // n = 110 in dec
{
 digitalWrite(pin, LOW);
}
else if (val == 109) //109 = m in dec
{

  digitalWrite(pin, HIGH);
}
}}