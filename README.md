# ~ The Dream Hotel ~
### Haris Imamović (16896)


### Šta je urađeno:
- - - -

####Spirala 1:
- [x] Skice svih podstranica (5 podstranica - 5 skica)
- [x] Sve stranice su responzivne i imaju grid layout
- [x] Iskorišteni su media query za prilagođavanje izgleda za razlicite velicine ekrana
- [x] Implementirane 3 HTML forme (Rezervacija soba, Rezervacija stola u restoranu, Slanje upita)
- [x] Implementiran show/hide menu koji je vidljiv na svim podstranicama.
- [x] Stranica nema glitcheva u okviru Google Chrome-a

####Spirala 2:
- [x] Galerija sa opcijom da slike gledaju u full screen modu (u okviru stranice "Galerija")
- [x] Učitavanje podstranica bez refreh-a korištenjem AJAX-a
- [x] Dropdown menu vidjiv na svim podstranicama koji predstavlja glavnu navigaciju
- [x] Validacija svih formi

####Spirala 3:
- [x] Kompletan CRUD sistem za podatke o sobama.
- [x] Omogućen download podataka o sobama u obliku csv datoteke
- [x] Omogućeno generisanje izvještaja u pdf formatu
- [x] Pretraga
- [x] Deployment: http://dream-hotel-dream-hotel.44fs.preview.openshiftapps.com 

####Spirala 4:
- [x] Kreirana MySQL baza podatala sa 3 tabele (users, rooms i images)
- [x] Kreirana php skripta koja omogućava migraciju podatak iz XML datoteke u bazu podataka
- [x] Generisanje CSV i PDF datoteke prepravljeno tako da radi direktno sa bazom
- [x] Pretraga kupi podatke iz baze
- [x] Implementirana GET metoda REST web servisa
- [x] Testiranje web servisa pomoću POSTMAN aplikacije

### Šta nije urađeno: 
- - - -
1. error 404 unfinished work not found


### Pronađeni bug-ovi:
- - - -
Mozzila Firefox ne podržava neke HTML5 i CSS3 elemente koji su korišteni npr. datetime-local, animation, @keyframes i sl.
Ostatak stranice se ponaša kako je očekivano.

Mozzila Firefox ne podržava datetime i datetime-local tipove inputa tako da validacija u tom browseru ne radi za ta polja.
Potrebno je samo modificirati javascript funkciju za validaciju tih polja. Razlika ce biti samo u formatu stringa
dobivenog kao vrijednost input-a. 

Prilikom pretrage "live search" vraca maksimalno 2 rezultata, na nakon sto se klikne enter ili dugme "Traži" prikažu se svi rezultati. Ovo je urađeno radi lakšeg testiranja no nije ispravljeno na 10 vracenih rezultata kako je trazeno u postavci. Izmjena se sastoji u promjeni vrijednosti varijable 'max' u searchScript.js

Prilikom promjene podataka o sobi, ako dođe do neke greške pri ispravljanju unosa potrebno je ponovno uploadovati sve tri slike.

### Sadržaj:
- - - -
* Folder fpdf1.181 - Folder u kojem se nalazi biblioteka za kreiranje PDF dokumenata i svi propratni fajlovi

* Folder SpiraleBackup
	* TheDreamHotel - Spirala 1	- Kod predat u sklopu spirale 1
	* TheDreamHotel - Spirala 2	- Kod predat u sklopu spirale 2
	* TheDreamHotel - Spirala 3 - Kod predat u sklopu spirale 3
	* TheDreamHotel - Spirala 4 - Kod spirale 4 koji radi na localhost

* Folder Design	- Sadrži sve skice dizajna stranice

* Folder POSTMAN - Sadrži screenshot-e testiranja web servisa

* Folder css
	* reset.css 		- CSS kod za poništavanje UAS.
	* style.css			- CSS za oblikovanje svih stranica za DreamHotel
	* roomCrudStyle.css - CSS za stranice kojima pristupa samo Admin

* Folder img
	* Folder hotel
	* Folder icons

* Folder js¸
	* folder validation
		* crudValidation.js - JS kod za validaciju kompletnog CRUD sistema za hotelske sobe
		* loginValidation.js - JS kod za validaciju prijavljivanja na sistem		* formValidation.js - JS kod za validaciju svih formi u sklopu stranice
	* ajaxScript.js         - JS kod za učitavanje podstranica u admin panel-u
	* searchScript.js       - JS dio pretrage soba
	* dreamScripts.js	    - Pozadinski JS kod za sve funkcionalnosti stranice (galerija, dropdown menu, home page slider)

* Folder private
	* Folder xml
		* hotelRooms.xml  - XML spisak svih podataka o sobama 
		* registeredUSers - XML spisak svih korisnika sistema (trenutno samo Administrator)

* Folder Database
	* thedreambase.sql 	- Dump kreirane baze podataka

* README.md	
* aditionalScripts.php	- Sadrži sve pomocne php funkcije (za validaciju, citanje iz XML-la i sl.)
* admin_panel.php		- Stranica u koja predstavlaj osnovu admin panela, u ovu stranicu učitavamo sve ostale podstranice za CRUD i sl.
* booking.html			- Stranica sa formom za rezervaciju sobe
* contact.html			- Stranica sa kontakt podatcima
* download_subpage.php	- Podstranica sa odgovarajućom PHP skriptom koja omogucava download podataka u csv. formatu
* gallery.html 			- Stranica na kojoj je implementirana galerija
* index.html			- Home page na kojoj je implementiran glavni slider 
* login.php				- Stranica sa odgovarajucom PHP skriptom za prijavu administratora na stranicu
* migrateXML.php 		- PHP skripta koja omogućava učitavanje podataka iz XML datoteke u bazu podataka
* restaurant.html		- Stranica sa prikazom hotelskih restorana
* roomCrud.php			- Posebna stranica sa formom na kojoj je omogucen kompletan CRUD nad sobama
* rooms.php				- Stranica na kojoj se prikazuju sve registrovane sobe, ovu stranicu mogu vidjeti svi posjetioci
* rooms_subpage.php	  	- Podstranica sa prikazom liste svih registrovanih soba, prikazuje se u okviru admin panela
* searchEngine.php		- PHP skripta koja odgovara na AJAX zahtjev za dostavljanje traženih podataka preko search box-a
* search_subpage.php	- Stranica koja se ucitava u admin panel, sadrži search box
* summary_subpage.php  	- Stranica sa odgovarajucom PHP skriptom koja omogucava kreiranje PDF izvjestaja 
* thedreamrest.php 		- PHP skripta u kojoj je implementiran web servis


### Napomena:
- - - -
Web servis implementiran je tako da mu se pristupa sa ".../thedreamrest.php". Ukoliko se ne navedu dodatni parametri servis vraća json niz svih soba registrovanih u hotelu. Opcionalno se još može dodati parametar "name='dio-naziva-sobe'". U ovom slučaju servis će vratiti samo one sobe koje u nazivu sadrže substring koji je dat kao parametar.

Priliko pokušaja deploymenta na Openshift, verzija projekta koja je radila sa bazom na localhost serveru je spašena u backup folderm, a u root folder je stavljen kod spreman za deployment. Tako da se dump baze sada nalazi u folderu /SpiraleBackup/TheDreamHotel - Spirala 04/Database/thedreambase.sql. 

S obzirom da je dodan password hash, pa se podaci više ne mogu tek tako pročitati iz registeredUsers.xml, pristupni podaci za admin panel su:
Username: admin
Password: admin
