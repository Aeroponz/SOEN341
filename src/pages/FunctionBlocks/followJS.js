function changeText(followId) {
	var follow = document.getElementById(followId);
	if(follow.value == 'Follow')
	{
		follow.value = 'UnFollow';
	}
	else{
		follow.value = 'Follow';
	}
	return true;
};