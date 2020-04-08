function changeText(iFollowId) {
	var wFollow = document.getElementById(iFollowId);
	if(wFollow.value == 'Follow')
	{
		wFollow.value = 'UnFollow';
	}
	else{
		wFollow.value = 'Follow';
	}
	return true;
};