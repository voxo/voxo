
function commentForm() {

	var commentform = document.commentform;
    
    if(commentform.cf_name_surname.value == '' || commentform.cf_name_surname.value == null) {
        alert("Lütfen adınız ve soyadınızı yazınız");
        var l01 = document.getElementById('cf_name_surname_lab');
        l01.innerHTML = "<strong>Ad Soyad (!)</strong>";
        commentform.cf_name_surname.focus();
        return false;
        }
        
	apos=commentform.cf_email.value.indexOf("@");
	dotpos=commentform.cf_email.value.lastIndexOf(".");
	if (apos<1||dotpos-apos<2) {
		alert("Lütfen geçerli bir e-posta adresi yazınız.");
		var l01 = document.getElementById('cf_email_lab');
		l01.innerHTML = "<strong>E-Posta (!)</strong>";
		commentform.cf_email.focus();
		return false;
		}
    
    if(commentform.cf_comment.value == '' || commentform.cf_comment.value == null) {
        alert("Lütfen yorum yazınız");
        var l01 = document.getElementById('cf_comment_lab');
        l01.innerHTML = "<strong>Yorum (!)</strong>";
        commentform.cf_comment.focus();
        return false;
        }
		
	return true;
}