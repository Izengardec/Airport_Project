document.getElementById('id').addEventListener('click',function(){
	var elements =document.getElementById('firsttablo').getElementsByClassName('variant_airport_select');
	if (length(elements)!=0){
		elements[0].className='variant_airport';
	}
	document.getElementById('id').className='variant_airport_select';
});