## ~ The Dream Hotel ~
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


### Sadržaj:
- - - -

* Folder SpiraleBackup
	* Design			- Dizajn stranice
	* TheDreamHotel - Spirala 1	- Kod Predat u sklopu spirale 1
	* TheDreamHotel - Spirala 2	- Kod Predat u sklopu spirale 2

* Folder css
	* reset.css 		- CSS kod za poništavanje UAS.
	* style.css		- CSS za oblikovanje svih stranica za DreamHotel
* Folder img
	* Folder hotel
	* Folder icons
* Folder js¸
	* folder validation
		* formValidation.js - JS kod za validaciju svih formi u sklopu stranice
	* dreamScripts.js	    - Pozadinski JS kod za sve funkcionalnosti stranice (galerija, dropdown menu, home page slider)
* README.md	
* aditionalScripts.php	
* admin_panel.php	
* booking.php	
* contact.php	
* download_subpage.php	
* gallery.php
* index.php	
* login.php	
* restaurant.php	
* roomCrud.php	
* rooms.php	
* rooms_subpage.php	
* searchEngine.php	
* search_subpage.php	
* summary_subpage.php

### Napomena:
- - - -

Samo folder "TheDreamHotel" u kojem se nalazi stranica stavljen je direktno na lokaciju C:/wamp/www 
tako da se iz browsera stranici pristupalo sa "localhost/thedreamhotel/index.html".