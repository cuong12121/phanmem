
function share_facebook()
{
	u=location.href;t=document.title;
	window.open("http://www.facebook.com/share.php?u="+encodeURIComponent(u)+"&t="+encodeURIComponent(t))
}
function share_google()
{
	u=location.href;
	t=document.title;
	window.open("http://www.google.com/bookmarks/mark?op=edit&bkmk="+encodeURIComponent(u)+"&title="+t+"&annotation="+t)
}
function share_twitter()
{
	u=location.href;
	t=document.title;
	window.open("http://twitter.com/home?status="+encodeURIComponent(u))
}
function share_digg()
{
	u=location.href;
	t=document.title;
	window.open("http://digg.com/submit?phase=2&url="+encodeURIComponent(u)+"&title="+t);
	window.open("http://del.icio.us/post?v=2&url="+encodeURIComponent(u)+"&notes=&tags=&title="+t);
}
function share_delicious()
{
	u=location.href;
	t=document.title;
	window.open("http://del.icio.us/post?v=2&url="+encodeURIComponent(u)+"&notes=&tags=&title="+t);
}
function OpenPrint()
{
	u=location.href;
	window.open(u+"&print=1");
	return false
}



/*************** CHECK FORM ***************/
//If the length of the element's string is 0 then display helper message
function notEmpty(elemid, helperMsg){
	elem  = document.getElementById(elemid);
	if(elem.value.length == 0){
//		document.getElementById('msg_error').innerHTML += "<li>"+helperMsg+"</li>";
		$('<br/><label class=\'label_error\'>'+helperMsg+'</label>').insertAfter('#'+elemid);
		invalid(elemid);
		elem.focus(); // set the focus to this input
		return false;
	}
	else
	{
		valid(elemid);
		return true;
	}
}
//For texarea
function notEmptyTextarea(elemid, helperMsg){
	elem  = document.getElementById(elemid);
	if(elem.value.length==0){
		$('<br/><label class=\'label_error\'>'+helperMsg+'</label>').insertAfter('#'+elemid);
//		document.getElementById('msg_error').innerHTML += "<li>"+helperMsg+"</li>";
		invalid(elemid);
		elem.focus(); // set the focus to this input
		return false;
	}
	else
	{
		valid(elemid);
		return true;
	}
}



//If the element's string matches the regular expression it is all numbers

function isNumeric(elemid, helperMsg){
	elem  = document.getElementById(elemid);
	var numericExpression = /^[0-9]+$/;
	if(elem.value.match(numericExpression)){
		valid(elemid);
		return true;
	}else{
		$('<br/><label class=\'label_error\'>'+helperMsg+'</label>').insertAfter('#'+elemid);
//		document.getElementById('msg_error').innerHTML += "<li>"+helperMsg+"</li>";
//		alert(helperMsg);
		invalid(elemid);
		elem.focus();
		return false;
	}
}

/*
 * check number list follow: 048082354;09238549; 
 */
function isNumericList(elemid, helperMsg){
	elem  = document.getElementById(elemid);
	var numericExpression = /^[0-9; ]+$/;
	if(elem.value.match(numericExpression)){
		valid(elemid);
		return true;
	}else{
		$('<br/><label class=\'label_error\'>'+helperMsg+'</label>').insertAfter('#'+elemid);
//		document.getElementById('msg_error').innerHTML = "<li>"+ helperMsg+"</li>";
//		alert(helperMsg);
		invalid(elemid);
		elem.focus();
		return false;
	}
}

//If the element's string matches the regular expression it is all letters
function isAlphabet(elemid, helperMsg){
	elem  = document.getElementById(elemid);
	var alphaExp = /^[a-zA-Z]+$/;
	if(elem.value.match(alphaExp)){
		return true;
	}else{
		$('<br/><label class=\'label_error\'>'+helperMsg+'</label>').insertAfter('#'+elemid);
//		document.getElementById('msg_error').innerHTML = helperMsg;
		
//		alert(helperMsg);
		elem.focus();
		return false;
	}
}

//If the element's string matches the regular expression it is numbers and letters
function isAlphanumeric(elemid, helperMsg){
	
	elem  = document.getElementById(elemid);
	var alphaExp = /^[0-9a-zA-Z]+$/;
	if(elem.value.match(alphaExp)){
		return true;
	}else{
		$('<br/><label class=\'label_error\'>'+helperMsg+'</label>').insertAfter('#'+elemid);
//		document.getElementById('msg_error').innerHTML = helperMsg;
		elem.focus();
		return false;
	}
}


// Limit length
function lengthRestriction(elemid, min, max){
	elem  = document.getElementById(elemid);
	var uInput = elem.value;
	if(uInput.length >= min && uInput.length <= max){
		valid(elemid);
		return true;
	}else{
		$('<br/><label class=\'label_error\'>'+'Please enter between ' +min+ ' and ' +max+ ' characters'+'</label>').insertAfter('#'+elemid);
//		document.getElementById('msg_error').innerHTML = "Please enter between " +min+ " and " +max+ " characters";
//		alert("Please enter between " +min+ " and " +max+ " characters");
		invalid(elemid);
		elem.focus();
		return false;
	}
}

// Min length
function lengthMin(elemid, min, helperMsg){
	elem  = document.getElementById(elemid);
	var uInput = elem.value;
	if(uInput.length >= min ){
		valid(elemid);
		return true;
	}else{
		$('<br/><label class=\'label_error\'>'+helperMsg+'</label>').insertAfter('#'+elemid);
//		document.getElementById('msg_error').innerHTML  += "<li>"+helperMsg+"</li>";
//		elem.focus();
		invalid(elemid);
		return false;
	}
}


// Select box ( multi select)
function madeSelection(elemid, helperMsg){
	elem  = document.getElementById(elemid);
	  var i;
	  for (i=0; i<elem.options.length; i++) {
	    if (elem.options[i].selected && ( elem.options[i].value != "") ){
	      return true;
	    }
	  }
	  $('<br/><label class=\'label_error\'>'+helperMsg+'</label>').insertAfter('#'+elemid);
//	  document.getElementById('msg_error').innerHTML = helperMsg;
	  return false;
}

// Select checkbox
function madeCheckbox(elemid, helperMsg)
{
	elem  = document.getElementById(elemid);
	if(elem.checked == false){
		$('<br/><label class=\'label_error\'>'+helperMsg+'</label>').insertAfter('#'+elemid);
//		document.getElementById('msg_error').innerHTML += "<li>"+helperMsg+"</li>";
		return false;
	}
	else
	{
		valid(elemid);
		return true;
	}
}

/*
 *  For checkbox multi.
 *  Min 1 item is checked
 */
function checkMultiCheckbox(containerid,helperMsg) {
	fields = $('#'+containerid).find('input:checked');
	length_checked = fields.length;
	if (!length_checked) {
		$('<br/><label class=\'label_error\'>'+helperMsg+'</label>').insertAfter('#'+elemid);
//    	document.getElementById('msg_error').innerHTML += "<li>"+helperMsg+"</li>";
        return false; // The form will *not* submit
    }
    return true;
}


// Email
function emailValidator(elemid, helperMsg){
	elem  = document.getElementById(elemid);
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	if(elem.value.match(emailExp)){
		valid(elemid);
		return true;
	}else{
		$('<br/><label class=\'label_error\'>'+helperMsg+'</label>').insertAfter('#'+elemid);
//		document.getElementById('msg_error').innerHTML += "<li>"+helperMsg+"</li>";
		invalid(elemid);
		return false;
	}
}

// Password and repassword

function checkMatchPass(helperMsg){
	elem_value  = document.getElementById('password').value;
	elem2_value  = document.getElementById('re-password').value;
	
	if(elem_value != elem2_value )
	{
		$('<br/><label class=\'label_error\'>'+helperMsg+'</label>').insertAfter('#'+elemid);
//		document.getElementById('msg_error').innerHTML += "<li>"+helperMsg+"</li>";
		invalid('re-password');
		return false;
	}
	else
	{
		valid('re-password');
		return true;
	}
}
function checkMatchPass_2(pass,repass,helperMsg){
	elem_value  = document.getElementById(pass).value;
	elem2_value  = document.getElementById(repass).value;
	if(elem_value != elem2_value )
	{
		$('<br/><label class=\'label_error\'>'+helperMsg+'</label>').insertAfter('#'+elemid);
//		document.getElementById('msg_error').innerHTML += "<li>"+helperMsg+"</li>";
		invalid(repass);
		return false;
	}
	else
	{
		valid(repass);
		return true;
	}
}

// Email and re-email

function checkMatchEmail(helperMsg){
	elem_value  = document.getElementById('email').value;
	elem2_value  = document.getElementById('re-email').value;
	
	if(elem_value != elem2_value )
	{
		$('<br/><label class=\'label_error\'>'+helperMsg+'</label>').insertAfter('#email');
//		document.getElementById('msg_error').innerHTML += "<li>"+helperMsg+"</li>";
		invalid('re-email');
		return false;
	}
	else
	{	
		valid('re-email');
		return true;
	}
}
/*
 * Change border color where valid
 */

function valid(element)
{
//	document.getElementById(element).style.border = " 2px solid #F0F0F0 ";
	$("#"+element).removeClass("redborder");

}
/*
 * Change border color where invalid
 */
function invalid(element)
{
	$("#"+element).addClass("redborder");
}




