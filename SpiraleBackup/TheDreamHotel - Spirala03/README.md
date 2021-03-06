﻿## ~ The Dream Hotel ~
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

### Sadržaj:
- - - -
* Folder fpdf1.181 - Folder u kojem se nalazi biblioteka za kreiranje PDF dokumenata i svi propratni fajlovi

* Folder SpiraleBackup
	* Design			- Dizajn stranice
	* TheDreamHotel - Spirala 1	- Kod Predat u sklopu spirale 1
	* TheDreamHotel - Spirala 2	- Kod Predat u sklopu spirale 2

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

* README.md	
* aditionalScripts.php	- Sadrži sve pomocne php funkcije (za validaciju, citanje iz XML-la i sl.)
* admin_panel.php		- Stranica u koja predstavlaj osnovu admin panela, u ovu stranicu učitavamo sve ostale podstranice za CRUD i sl.
* booking.html			- Stranica sa formom za rezervaciju sobe
* contact.html			- Stranica sa kontakt podatcima
* download_subpage.php	- Podstranica sa odgovarajućom PHP skriptom koja omogucava download podataka u csv. formatu
* gallery.html 			- Stranica na kojoj je implementirana galerija
* index.html			- Home page na kojoj je implementiran glavni slider 
* login.php				- Stranica sa odgovarajucom PHP skriptom za prijavu administratora na stranicu
* restaurant.html		- Stranica sa prikazom hotelskih restorana
* roomCrud.php			- Posebna stranica sa formom na kojoj je omogucen kompletan CRUD nad sobama
* rooms.php				- Stranica na kojoj se prikazuju sve registrovane sobe, ovu stranicu mogu vidjeti svi posjetioci
* rooms_subpage.php	  	- Podstranica sa prikazom liste svih registrovanih soba, prikazuje se u okviru admin panela
* searchEngine.php		- PHP skripta koja odgovara na AJAX zahtjev za dostavljanje traženih podataka preko search box-a
* search_subpage.php	- Stranica koja se ucitava u admin panel, sadrži search box
* summary_subpage.php  	- Stranica sa odgovarajucom PHP skriptom koja omogucava kreiranje PDF izvjestaja 
