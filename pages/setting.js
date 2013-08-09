/**
 *     Woo superb slideshow transition gallery with random effect
 *     Copyright (C) 2011 - 2013  www.gopiplus.com
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


function woo_submit()
{
	if(document.form_woo.woo_path.value=="")
	{
		alert("Please enter the image path.")
		document.form_woo.woo_path.focus();
		return false;
	}
	else if(document.form_woo.woo_link.value=="")
	{
		alert("Please enter the target link.")
		document.form_woo.woo_link.focus();
		return false;
	}
	else if(document.form_woo.woo_target.value=="")
	{
		alert("Please enter the target status.")
		document.form_woo.woo_target.focus();
		return false;
	}
	//else if(document.form_woo.woo_title.value=="")
//	{
//		alert("Please enter the image title.")
//		document.form_woo.woo_title.focus();
//		return false;
//	}
	else if(document.form_woo.woo_type.value=="")
	{
		alert("Please select the gallery type.")
		document.form_woo.woo_type.focus();
		return false;
	}
	else if(document.form_woo.woo_status.value=="")
	{
		alert("Please select the display status.")
		document.form_woo.woo_status.focus();
		return false;
	}
	else if(document.form_woo.woo_order.value=="")
	{
		alert("Please enter the display order, only number.")
		document.form_woo.woo_order.focus();
		return false;
	}
	else if(isNaN(document.form_woo.woo_order.value))
	{
		alert("Please enter the display order, only number.")
		document.form_woo.woo_order.focus();
		return false;
	}
	_woo_escapeVal(document.form_woo.woo_text,'<br>');
}

function woo_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_woo_display.action="options-general.php?page=woo-superb-slideshow&ac=del&did="+id;
		document.frm_woo_display.submit();
	}
}	

function woo_help()
{
	window.open("http://www.gopiplus.com/work/2010/09/19/woo-superb-slideshow-transition-gallery-with-random-effect/");
}

function woo_redirect()
{
	window.location = "options-general.php?page=woo-superb-slideshow";
}

function _woo_escapeVal(textarea,replaceWith)
{
textarea.value = escape(textarea.value) //encode textarea strings carriage returns
for(i=0; i<textarea.value.length; i++)
{
	//loop through string, replacing carriage return encoding with HTML break tag
	if(textarea.value.indexOf("%0D%0A") > -1)
	{
		//Windows encodes returns as \r\n hex
		textarea.value=textarea.value.replace("%0D%0A",replaceWith)
	}
	else if(textarea.value.indexOf("%0A") > -1)
	{
		//Unix encodes returns as \n hex
		textarea.value=textarea.value.replace("%0A",replaceWith)
	}
	else if(textarea.value.indexOf("%0D") > -1)
	{
		//Macintosh encodes returns as \r hex
		textarea.value=textarea.value.replace("%0D",replaceWith)
	}
}
textarea.value=unescape(textarea.value) //unescape all other encoded characters
}