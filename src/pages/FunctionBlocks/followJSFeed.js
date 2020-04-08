function changeText(iFollowId) {
	var wFollow = document.getElementById(iFollowId);
	if(wFollow.value == 'Follow')
	{
		wFollow.value = 'UnFollow';
	}
	else{
		wFollow.value = 'Follow';
	}
	//refresh after dealy to update other posts button
	setTimeout(location.reload.bind(location), 50)
	return true;
};