/************************************************************
 * SISTEM INKUBATOR TELUR IoT
 * Board  : ESP8266 NodeMCU
 * Sensor : DHT22
 * LCD    : I2C 16x2
 * Relay  : 4 Channel Active LOW
 *
 * CHANGELOG:
 * - FIX: heater & motor dikirim sebagai "ON"/"OFF" (bukan 0/1)
 *        agar timeline motor di web dapat mendeteksi perubahan status
 * - FIX: interval & durasi motor dibaca dari server (/api/kontrol)
 *        sehingga setting jadwal motor di web berpengaruh ke ESP8266
 ************************************************************/

#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClientSecure.h>
#include <ArduinoJson.h>

#include <Wire.h>
#include <LiquidCrystal_I2C.h>

#include <DHT.h>

// ==========================================
// KREDENSIAL WIFI & URL SERVER
// ==========================================
const char* ssid       = "cacha";
const char* password   = "12345678";
const char* serverName = "https://iotemp.ruangprojek.cloud";

String apiKontrolGET = "/api/kontrol";
String apiSensorPOST = "/api/sensor";

// ==========================================
// KONFIGURASI PIN HARDWARE (NOMOR GPIO ASLI)
// ==========================================
#define DHTPIN      2   // D4 (GPIO 2)
#define DHTTYPE     DHT22

#define RELAY_LAMPU 14  // D5 (GPIO 14) -> HEATER
#define RELAY_MOTOR 12  // D6 (GPIO 12) -> MOTOR PUTAR TELUR
#define RELAY_KIPAS 15  // D8 (GPIO 15) -> KIPAS
#define BUZZER      13  // D7 (GPIO 13) -> ALARM

DHT dht(DHTPIN, DHTTYPE);
LiquidCrystal_I2C lcd(0x27, 16, 2);

// ==========================================
// VARIABEL SISTEM
// ==========================================

// Sensor
float suhu = 0.0;
float hum  = 0.0;

// Mode
bool autoMode = true;

// Set Point
float targetSuhu        = 38.0;
int   targetKelembapan  = 60;

// Status Manual dari Website
bool heaterManual = false;
bool motorManual  = false;
bool kipasManual  = false;

// Status Relay Aktual
bool heaterStatus = false;
bool motorStatus  = false;
bool kipasStatus  = false;

// ==========================================
// TIMER MOTOR
// FIX: Jadwal motor dibaca dari server (/api/kontrol)
//      field: motor_interval_jam & motor_durasi_menit
//      Default sesuai nilai server: 3 jam & 5 menit
// ==========================================
unsigned long waktuMotor       = 0;
unsigned long waktuMulaiMotor  = 0;

unsigned long intervalMotorMs  = 10800000UL; // default 3 jam   (3 * 3600 * 1000)
unsigned long durasiMotorMs    = 300000UL;   // default 5 menit (5 * 60 * 1000)

bool motorAktif = false;

// Timer komunikasi
unsigned long lastSend     = 0;
unsigned long lastFetch    = 0;
unsigned long lastLogLocal = 0;

// ==========================================
// FORWARD DECLARATIONS
// ==========================================
void bacaSensor();
void kontrolOtomatis();
void kontrolManual();
void updateLCD();

// ==========================================
// KONEKSI WIFI
// ==========================================
void connectWiFi() {
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  Serial.print("Menghubungkan WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nWiFi Terhubung Berhasil!");
}

// ==========================================
// AMBIL STATUS KONTROL DARI SERVER
// ==========================================
void ambilStatusKontrol() {

  if (WiFi.status() != WL_CONNECTED) return;

  std::unique_ptr<WiFiClientSecure> client(new WiFiClientSecure);
  client->setInsecure();

  HTTPClient http;
  String url = String(serverName) + apiKontrolGET;

  if (http.begin(*client, url)) {

    http.setFollowRedirects(HTTPC_STRICT_FOLLOW_REDIRECTS);

    int httpCode = http.GET();

    if (httpCode == 200) {

      String payload = http.getString();

      Serial.print("[GET API] Payload : ");
      Serial.println(payload);

      DynamicJsonDocument doc(1024);
      DeserializationError error = deserializeJson(doc, payload);

      if (!error) {

        //=========================
        // MODE
        //=========================
        if (doc.containsKey("mode")) {
          String mode = doc["mode"].as<String>();
          autoMode = !mode.equalsIgnoreCase("Manual");
        }

        //=========================
        // TARGET
        //=========================
        if (doc.containsKey("target_suhu"))
          targetSuhu = doc["target_suhu"].as<float>();

        if (doc.containsKey("target_kelembapan"))
          targetKelembapan = doc["target_kelembapan"].as<int>();

        //=========================
        // HEATER
        //=========================
        if (doc.containsKey("heater")) {
          String heater = doc["heater"].as<String>();
          heaterManual = heater.equalsIgnoreCase("ON");
        }

        //=========================
        // MOTOR
        //=========================
        if (doc.containsKey("motor")) {
          String motor = doc["motor"].as<String>();
          motorManual  = motor.equalsIgnoreCase("ON") || motor == "1";
        }

        //=========================
        // KIPAS
        //=========================
        if (doc.containsKey("kipas")) {
          String kipas = doc["kipas"].as<String>();
          kipasManual  = kipas.equalsIgnoreCase("ON");
        }

        //=========================
        // FIX: JADWAL MOTOR DARI SERVER
        // Baca motor_interval_jam & motor_durasi_menit
        // agar setting di halaman web berpengaruh ke ESP8266
        //=========================
        if (doc.containsKey("motor_interval_jam")) {
          unsigned long jamVal = doc["motor_interval_jam"].as<unsigned long>();
          if (jamVal >= 1 && jamVal <= 12) {
            intervalMotorMs = jamVal * 3600000UL;
            Serial.print("[JADWAL] Interval motor: ");
            Serial.print(jamVal);
            Serial.println(" jam");
          }
        }

        if (doc.containsKey("motor_durasi_menit")) {
          unsigned long menitVal = doc["motor_durasi_menit"].as<unsigned long>();
          if (menitVal >= 1 && menitVal <= 60) {
            durasiMotorMs = menitVal * 60000UL;
            Serial.print("[JADWAL] Durasi motor: ");
            Serial.print(menitVal);
            Serial.println(" menit");
          }
        }

      }

    }

    http.end();
  }

}

// ==========================================
// KIRIM DATA SENSOR KE SERVER
// ==========================================
void kirimDataSensor() {

  if (WiFi.status() != WL_CONNECTED) return;

  float kirimSuhu = isnan(suhu) ? 0 : suhu;
  float kirimHum  = isnan(hum)  ? 0 : hum;

  std::unique_ptr<WiFiClientSecure> client(new WiFiClientSecure);
  client->setInsecure();

  HTTPClient http;
  String url = String(serverName) + apiSensorPOST;

  if (http.begin(*client, url)) {

    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // FIX: heater & motor dikirim sebagai "ON"/"OFF" (bukan 0/1)
    // Server membandingkan dengan === 'ON' / === 'OFF' untuk timeline motor
    String data =
      "suhu="        + String(kirimSuhu) +
      "&kelembapan=" + String(kirimHum) +
      "&heater="     + String(heaterStatus ? "ON" : "OFF") +
      "&motor="      + String(motorStatus  ? "ON" : "OFF") +
      "&kipas="      + String(kipasStatus  ? "ON" : "OFF") +
      "&mode="       + String(autoMode ? "AUTO" : "MANUAL");

    int httpCode = http.POST(data);

    Serial.print("[POST] ");
    Serial.print(data);
    Serial.print(" | HTTP: ");
    Serial.println(httpCode);

    http.end();
  }

}

// ==========================================
// SETUP
// ==========================================
void setup() {

  Serial.begin(115200);
  delay(1000);

  Serial.println();
  Serial.println("==================================");
  Serial.println(" SISTEM INKUBATOR IoT START ");
  Serial.println("==================================");

  pinMode(RELAY_LAMPU, OUTPUT);
  pinMode(RELAY_MOTOR, OUTPUT);
  pinMode(RELAY_KIPAS, OUTPUT);
  pinMode(BUZZER, OUTPUT);

  // Relay OFF dulu (Active LOW → HIGH = OFF)
  digitalWrite(RELAY_LAMPU, HIGH);
  digitalWrite(RELAY_MOTOR, HIGH);
  digitalWrite(RELAY_KIPAS, HIGH);
  digitalWrite(BUZZER, LOW);

  dht.begin();

  lcd.begin(16, 2);
  lcd.backlight();

  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Inkubator IoT");
  lcd.setCursor(0, 1);
  lcd.print("Starting...");

  waktuMotor = millis();

  connectWiFi();
}

// ==========================================
// LOOP
// ==========================================
void loop() {

  //==========================
  // Pastikan WiFi tersambung
  //==========================
  if (WiFi.status() != WL_CONNECTED) {
    connectWiFi();
  }

  //==========================
  // Ambil data dari website (termasuk jadwal motor)
  //==========================
  if (millis() - lastFetch >= 3000) {
    ambilStatusKontrol();
    lastFetch = millis();
  }

  //==========================
  // Baca sensor
  //==========================
  bacaSensor();

  //==========================
  // Tampilkan ke Serial Monitor
  //==========================
  if (millis() - lastLogLocal >= 2000) {

    if (!isnan(suhu)) {
      Serial.print("[SENSOR] ");
      Serial.print(suhu);
      Serial.print(" C | ");
      Serial.print(hum);
      Serial.print(" % | MODE: ");
      Serial.print(autoMode ? "AUTO" : "MANUAL");
      Serial.print(" | Interval: ");
      Serial.print(intervalMotorMs / 3600000UL);
      Serial.print("j | Durasi: ");
      Serial.print(durasiMotorMs / 60000UL);
      Serial.println("m");
    }

    lastLogLocal = millis();
  }

  //==========================
  // MODE AUTO / MANUAL
  //==========================
  if (autoMode) {
    kontrolOtomatis();
  } else {
    kontrolManual();
  }

  //==========================
  // LCD
  //==========================
  updateLCD();

  //==========================
  // Kirim data sensor ke server
  //==========================
  if (millis() - lastSend >= 10000) {
    kirimDataSensor();
    lastSend = millis();
  }

  delay(50);
}

// ==========================================
// BACA SENSOR DHT22
// ==========================================
void bacaSensor() {
  suhu = dht.readTemperature();
  hum  = dht.readHumidity();

  if (isnan(suhu) || isnan(hum)) {
    Serial.println("[SENSOR] DHT gagal dibaca");
    return;
  }
}

// ==========================================
// KONTROL OTOMATIS
// ==========================================
void kontrolOtomatis() {

  // ==========================
  // KONTROL HEATER
  // ==========================
  if (suhu < targetSuhu) {
    heaterStatus = true;
    digitalWrite(RELAY_LAMPU, LOW);   // Active LOW → ON
  } else {
    heaterStatus = false;
    digitalWrite(RELAY_LAMPU, HIGH);  // OFF
  }

  // ==========================
  // KONTROL KIPAS
  // ==========================
  if (suhu > (targetSuhu + 0.5)) {
    kipasStatus = true;
    digitalWrite(RELAY_KIPAS, LOW);   // ON
  } else {
    kipasStatus = false;
    digitalWrite(RELAY_KIPAS, HIGH);  // OFF
  }

  // ==========================
  // FIX: TIMER PUTAR TELUR
  // Gunakan intervalMotorMs & durasiMotorMs yang dibaca dari server
  // ==========================
  if (!motorAktif && millis() - waktuMotor >= intervalMotorMs) {

    motorAktif    = true;
    waktuMulaiMotor = millis();
    motorStatus   = true;

    digitalWrite(RELAY_MOTOR, LOW);   // ON
    digitalWrite(BUZZER, HIGH);       // Buzzer ON

    Serial.println("[MOTOR] Motor mulai berputar...");
  }

  if (motorAktif && millis() - waktuMulaiMotor >= durasiMotorMs) {

    motorAktif  = false;
    waktuMotor  = millis();
    motorStatus = false;

    digitalWrite(RELAY_MOTOR, HIGH);  // OFF
    digitalWrite(BUZZER, LOW);        // Buzzer OFF

    Serial.println("[MOTOR] Motor selesai berputar.");
  }
}

// ==========================================
// KONTROL MANUAL
// ==========================================
void kontrolManual() {

  // ==========================
  // HEATER
  // ==========================
  heaterStatus = heaterManual;

  if (heaterStatus) {
    digitalWrite(RELAY_LAMPU, LOW);   // ON
  } else {
    digitalWrite(RELAY_LAMPU, HIGH);  // OFF
  }

  // ==========================
  // MOTOR
  // ==========================
  motorStatus = motorManual;

  if (motorStatus) {
    digitalWrite(RELAY_MOTOR, LOW);   // ON
    digitalWrite(BUZZER, HIGH);       // Buzzer ikut ON
  } else {
    digitalWrite(RELAY_MOTOR, HIGH);  // OFF
    digitalWrite(BUZZER, LOW);
  }

  // ==========================
  // KIPAS
  // ==========================
  kipasStatus = kipasManual;

  if (kipasStatus) {
    digitalWrite(RELAY_KIPAS, LOW);   // ON
  } else {
    digitalWrite(RELAY_KIPAS, HIGH);  // OFF
  }

  // ==========================
  // Reset timer motor agar tidak langsung jalan saat kembali ke AUTO
  // ==========================
  motorAktif = false;
  waktuMotor = millis();
}

// ==========================================
// UPDATE LCD
// ==========================================
void updateLCD() {

  lcd.clear();

  //=========================
  // BARIS PERTAMA: Suhu & Kelembapan
  //=========================
  lcd.setCursor(0, 0);

  if (isnan(suhu) || isnan(hum)) {
    lcd.print("Sensor Error    ");
  } else {
    lcd.print("T:");
    lcd.print(suhu, 1);
    lcd.print((char)223);  // Simbol derajat °
    lcd.print("C ");
    lcd.print("H:");
    lcd.print((int)hum);
    lcd.print("%  ");
  }

  //=========================
  // BARIS KEDUA: Mode & Status Aktuator
  //=========================
  lcd.setCursor(0, 1);

  if (autoMode) {
    lcd.print("AUTO ");

    if (heaterStatus)
      lcd.print("HTR ");
    else
      lcd.print("    ");

    if (kipasStatus)
      lcd.print("FAN ");
    else
      lcd.print("    ");

    if (motorStatus)
      lcd.print("MTR");

  } else {
    lcd.print("MAN  ");

    if (heaterStatus)
      lcd.print("HTR ");
    else
      lcd.print("    ");

    if (motorStatus)
      lcd.print("MTR");
    else if (kipasStatus)
      lcd.print("FAN");
  }

}
