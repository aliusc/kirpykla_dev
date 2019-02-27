# kirpykla_dev
NFQ akademija - atranka

Paprasta kirpyklos registracijos sistema skirta padėti tvarkyti užsakymus tiek 
kirpėjoms, tiek ir jų klientams. Kirpykla yra skirta vienai ar daugiau kirpėjų (skaičius neribotas) 
bei neribotam skaičiui klientų.

Kirpyklos rezervavimo sistemą sudaro dvi dalys:
* Kirpėjų zona
* Klientų zona

## Kirpėjų zona
Kirpyklos darbuotojai užsukę į šią zoną pagal išvysta rezervacijų filtrus ir esamus 
užsakymus, galimybę rezervuoti naujus ar atšaukti esamus užsakymus.

### Rezervacijų peržiūros langas
Sąraše pagal nutylėjimą rodomi esamos dienos visi likę užsakymai surikiuoti nuo daugiausiai 
kartų apsilankiusio kliento iki mažiausiai apsilankiusio. Apsilankymas skaičiuojamas tik tuomet, kai kliento
rezervacijos data jau praėjo ir užsakymas nebuvo atšauktas. Naudojantis filtrais galima pasirinkti kitą datą iš 
kalendoriaus kurios užsakymus norite peržiūrėti ir paspausti mygtuką ***Rodyti***; Greitesniam darbui yra dvi nuorodos 
***Šiandien*** ir ***Rytoj*** kurios automatiškai kalendoriuje parenka atitinkamą datą. Peržiūrai reikia paspausti ***Rodyti***. Norint rasti 
tam tikrą klientą reikia įrašyti jo vardą į ***Klientas*** laukelį ir atlikus paiešką bus paliekami tik tie įrašai 
kurie priklauso ieškomam klientui. Laukelius ***Data*** ir ***Klientas*** galima naudoti juos kombinuojant arba pildant 
tik aktualų laukelį. 

Lentelėje rodomą informaciją galima surikiuoti pagal ten esančius stulpelius:
* pagal laiką nuo naujausio iki seniausio
* pagal kirpėjo vardą alfabeto tvarka
* pagal kliento vardą alfabeto tvarka
* paga; apsilankymų skaičių nuo didžiausio iki mažiausio (pradinis rodymas)

Apsilankymų skaičiaus stulpelyje kuomet klientui tai jau 5-10-15 ar kt. vizitas bus rodomas raudonas tekstas "nuolaida!".
Paskutiniame stulpelyje paspaudus šiukšlių dėžės ikoną leis rezervaciją atšaukti. 

Lentelėje rodomi ne daugiau kaip 5 įrašai. Jeigu įrašų skaičius lentelėje yra didesnis tuomet per puslapius galima 
vaikščioti
spaudant po lentele esančias nuorodas ***Pirmyn*** ir ***Atgal***.

## Nauja rezervacija
Šis skyrius leidžia užregistruoti kliento vizitą jam užsukus gyvai ar paskambinus telefonu. Kad sukurti naują 
rezervaciją reikia užpildyti tokius laukus:
* Pasirinkti datą iš kalendoriaus
* Vizito laikas (nuo 10:00 iki 20:00, kas 15min.)
* Kirpėjo vardą iš sąrašo
* Kliento vardą - įrašant klaviatūra

Paspaudus mygtuką ***Registruoti*** atliekamas duomenų tikrinimas:
* Ar užpildyti visi laukai
* Ar pasirinktas laikas nėra praeityje
* Ar pasirinktu metu kirpėjas yra laisvas
* Ar šis klientas neturi ateityje jo vardu esančių registracijų (gali būti tik 1 aktyvi registracija)

Esant klaidai bus parodytas pranešimas su atitinkamu tekstu.

## Klientų zona
Kliento zona leidžia klientui pačiam užsirezervuoti vizito į kirpyklą laiką. 

### Užimtumo lentelės peržiūra ir rezervavimas
Užsukus į šią zoną rodomas vienintelis filtras - ***Datos*** pasirinkimas. Pagal nutylėjimą rodomi šiuos dienos *dar likę* 
laikai, t.y. esantys vėliau nei dabartinis laikas. Jeigu klientas pasirinks kitą ateities datą iš kalendoriaus ir
paspaus ***Rodyti***, tuomet bus rodomi visi visų kirpėjų darbo laikai nuo 10:00 iki 20:00. Laiko eilutės ir kirpėjo 
stulpelio susikirtime raudoname fone rodoma *rezervuota* jeigu tas laikas jau užimtas. Laisvi laikai rodomi kaip žalias
fonas. Norint rezervuoti norimą laiką pas norimą kirpėją reikia paspausti jų susikirtime esantį žalią foną ir pasirodys
dialogas prašantis įvesti ***Kliento vardą***. Patvirtinus vėl atliekami tikrinimai (žr. kirpėjo skiltį *Nauja rezervacija*).
Registracijai pavykus langas perpiešiamas ir ši celė turi būti rodoma kaip rezervuota. 

###Rezervacijos priminimas

Pavykus registracijai virš filtro geltoname fone rodomas priminimas apie galiojančia rezervaciją. Jame rašoma ir data, 
laikas bei kirpėjas pas kurį yra rezervuotas vizitas. Jeigu dėl vizito persigalvosite - šalia teksto yra ikona "šiukšlių 
dėžė" kurią paspaudus rezervaciją galima atšaukti. **Dėmesio**: jeigu atlikote keletą rezervacijų skirtingais vardais 
piminime bus rodoma paskutinės rezervacijos informacija.