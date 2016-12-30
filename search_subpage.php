<!-- Subpage Heading -->
<div class="row">
	<div class="col-d-4 noDisp"></div>
	<p class="errorProv noDisp">&nbsp;</p>
	<div class="col-d-4 noDisp"></div>
</div>
<div class="row">
	<div class="col-d-1 noDisp"></div>
	<h2 class="col-d-10 sectionHeading">Pretraga The Dream hotelskih soba</h2>
	<div class="col-d-1 noDisp"></div>
</div>
<div class="row">
	<div class="col-d-2 noDisp"></div>
	<p class="sectionParagraph col-d-8">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
	</p>
	<div class="col-d-2 noDisp"></div>
</div>

<!-- Search Form -->
<form onsubmit="return false">
	<div class="row">
		<div class="col-d-1 noDisp"></div>
		<input type="text" name="searchbox" id="searchbox" class="col-d-7" size="30" 
			placeholder="Unesite naziv sobe ili ključnu riječ iz opisa" autocomplete="off" 
				onkeyup="liveQuery(this, true)"
				onkeydown="enterQuery()">

		<button name="search" class="button col-d-3" style="margin: 0; border: 1px solid #131313;" 
			onclick="staticQuery()">Traži</button>

		<div class="col-d-1 noDisp"></div>
	</div>
	<div class="row">
		<div class="col-d-1 noDisp"></div>
		<div id="livePreview" class="col-d-7"></div>
		<div class="col-d-4 noDisp"></div>
	</div>
</form>

